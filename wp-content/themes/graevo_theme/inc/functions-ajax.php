<?php
// Contact Form feedback
add_action( 'wp_ajax_add_feedback', 'feedback_function_callback' );
add_action( 'wp_ajax_nopriv_add_feedback', 'feedback_function_callback' );

// Event Registration
add_action( 'wp_ajax_event_registration', 'event_registration_callback' );
add_action( 'wp_ajax_nopriv_event_registration', 'event_registration_callback' );

// Buy in one click
add_action( 'wp_ajax_by_one_click', 'by_one_click_callback' );
add_action( 'wp_ajax_nopriv_by_one_click', 'by_one_click_callback' );



/**
 * Add CPT Feedback new post with data
 * from fronend
 */
function feedback_function_callback(){

	$data = $_POST['data'];

	$nonce = $data['_wpnonce'] ;
	if( ! wp_verify_nonce( $nonce ) ) {
		wp_send_json_error( 'Security check' );
	}


	$current_time = current_time('d.m.Y');
	$post_content = wp_kses(
		 '<p>'.$data['contact_form_phone'] .'</p>
				<p>'. $data['contact_form_email'] .'</p>
				<p>'. $data['contact_form_comment'].'</p>',
		[ 'p' => [] ]
	);

	$post_data = array(
		//'post_title'    => sanitize_text_field( $_POST['post_title'] ),
		'post_title'    => 'New feedback',
		'post_type'     => 'cpt_feedback',
		'post_content'  => $post_content,
		'post_status'   => 'draft',
	);
	$post_id = wp_insert_post( $post_data );


	if ( $post_id )
	{
		$post_data_update = [
			'ID'            => $post_id,
			'post_title'    => sanitize_text_field(
				'#'.$post_id.'---'.$current_time
			)
		];
		wp_update_post( wp_slash($post_data_update) );
	}

	wp_send_json_success( [
		'form_content' => $data,
		'response' => __('Дякуємо за запитання. Ми обов\'язково Вам відповімо!', 'html5blank')
	] );
}


/**
 * Register user for specific event
 * from fronend
 */
function event_registration_callback(){

	global $wpdb;

	$data   = $_POST['data']  ;
	$nonce  = $data['_wpnonce'] ;
	$reCaptcha_validate = ReCaptchaValidate( $data['g-recaptcha-response'] );

	if( ! wp_verify_nonce( $nonce ) ) {
		wp_send_json_error( 'Security check' );
	}

	$errors = [];
	if ( empty( $data['name'] ) ) $errors['name'] = __('Ви не вказали ім\'я ', 'html5blank' );
	if ( empty( $data['phone'] ) ) $errors['name'] = __('Ви не вказали номер телефону', 'html5blank');
	if ( ! $reCaptcha_validate ) $errors['recaptcha'] = __('reCaptcha не пройдена', 'html5blank');


	if ( ! $errors ) {

		$array_to_insert = [
			'event_id'     => $data['event_id'],
			'date'         => current_time('mysql'),
			'name'         => $data['name'],
			'phone'        => $data['phone'],
			'confirm'      => 0,
		];

		$table_name = 'events_user_table';
		$wp_track_table = $wpdb->prefix . "$table_name";
		$insert_to_db = $wpdb->insert( $wp_track_table, $array_to_insert );

	}


	if ( $insert_to_db ) {
		wp_send_json_success( __('Дякуємо за реєстрацію', 'html5blank') );
	}
	else{
		wp_send_json_error( __('Вибачте, трапилась якась прикра несподіванка', 'html5blank') );
	}


}


/**
 * Action for "By one click" button
 * @throws WC_Data_Exception
 */
function by_one_click_callback()
{
	$data = $_POST['data'];
	$reCaptcha_validate = ReCaptchaValidate( $data['g-recaptcha-response'] );

	$nonce = $data['_wpnonce'] ;
	if( ! wp_verify_nonce( $nonce ) ) {
		wp_send_json_error( 'Security check' );
	}

	$errors = [];
	if ( empty( $data['name'] ) ) $errors['name'] = __('Ви не вказали ім\'я ', 'html5blank' );
	if ( empty( $data['phone'] ) ) $errors['name'] = __('Ви не вказали номер телефону', 'html5blank');
	if ( ! $reCaptcha_validate ) $errors['recaptcha'] = __('reCaptcha не пройдена', 'html5blank');

	if ( $errors ) {
		wp_send_json_error(
			[
				'response'  => __('Вибачте, трапилась якась прикра несподіванка', 'html5blank'),
				'error'     => $errors
			]
		);
	}




	$names = explode(" ", $data['name'], 2);

	$order = wc_create_order();

	if ( is_user_logged_in() ){
		$address = array(
			'first_name'    => $names[0],
			'last_name'     => $names[1],
			'email'         => WC()->customer->get_billing_email(),
			'phone'         => $data['phone'],
			'address_1'     => WC()->customer->get_billing_address_1(),
			'address_2'     => WC()->customer->get_billing_address_2(),
			'address_3'     => get_user_meta( WC()->customer->get_id(), 'billing_address_3', true),
			'postcode'      => WC()->customer->get_billing_postcode(),
		);
		$customer_id = WC()->customer->get_id();
		$order->set_customer_id( $customer_id );

	}
	else{
		$address = array(
			'first_name' => $names[0],
			'last_name'  => $names[1],
			'phone'      => $data['phone'],
		);
	}

	try {
		$order->add_product( wc_get_product( $data['product_id'] ), 1);
		$order->set_address( $address, 'billing' );
		$order->calculate_totals();
		$order->update_status('oneclick', '', TRUE);
		$order->add_order_note( $data['comment'] );

		// Send email to admin
		$email = WC()->mailer()->emails['WC_Email_New_Order'];
		$email->trigger( $order->get_id() );

		wp_send_json_success(
			[
				'response' => __('Дякуємо за замовлення! <br> Ми передзвонимо якомога швидше! ', 'html5blank')
			]
		);

	} catch (Exception $e) {
		wp_send_json_error(
			[
				'response'  => __('Вибачте, трапилась якась прикра несподіванка', 'html5blank'),
				'error'     => $e->getMessage()
			]
		);
	}

}
