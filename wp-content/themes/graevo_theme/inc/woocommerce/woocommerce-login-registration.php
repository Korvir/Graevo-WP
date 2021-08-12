<?php
// Registration Field validation
add_filter( 'woocommerce_registration_errors', 'account_registration_field_validation', 10, 3 );

// Save registration Field value
add_action( 'woocommerce_created_customer', 'save_account_registration_field' );

// Save Field value in Edit account
add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
add_action( 'woocommerce_save_account_details', 'save_all_account_fields', 10, 1 );

// Add new fields to wp-admin for user
add_filter( 'woocommerce_customer_meta_fields', 'woocommerce_admin_new_fields' );





function account_registration_field_validation( $errors, $username, $email ) {
	if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
		$errors->add( 'billing_phone_error', __( '<strong>Error</strong>: phone number is required!', 'woocommerce' ) );
	}
	return $errors;
}


function save_account_registration_field( $customer_id ) {
	if ( isset( $_POST['billing_phone'] ) ) {
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}
}


function save_all_account_fields( $user_id ) {
	if( isset( $_POST['billing_phone'] ) )
		update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );

	if( isset( $_POST['billing_state'] ) )
		update_user_meta( $user_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );

	if( isset( $_POST['billing_city'] ) )
		update_user_meta( $user_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );

	if( isset( $_POST['billing_address_1'] ) )
		update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );

	if( isset( $_POST['billing_address_2'] ) )
		update_user_meta( $user_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );

	if( isset( $_POST['billing_address_3'] ) )
		update_user_meta( $user_id, 'billing_address_3', sanitize_text_field( $_POST['billing_address_3'] ) );

	if( isset( $_POST['billing_postcode'] ) )
		update_user_meta( $user_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
}


function wc_save_account_details_required_fields( $required_fields ){
	unset($required_fields['account_display_name'] );
	unset($required_fields['account_first_name']);
	unset($required_fields['account_last_name']);
	unset($required_fields['billing_phone']);

	return $required_fields;
}


/**
 * Add new fields to account panel
 * @param $admin_fields
 *
 * @return array
 */
function woocommerce_admin_new_fields( $admin_fields ): array {
	$admin_fields['billing']['fields']['billing_address_3'] = array(
		'label' => 'Адреса 3',
	);
	$admin_fields['shipping']['fields']['shipping_address_3'] = array(
		'label' => 'Адреса 3',
	);

	return $admin_fields;

}
