<?php
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');

add_action( 'woocommerce_checkout_init', 'disable_checkout_terms_and_conditions', 10 );

add_filter( 'woocommerce_checkout_fields', 'change_woo_checkout_fields' );
add_filter( 'woocommerce_checkout_fields', 'add_classes_for_inputs' );
add_filter( 'woocommerce_checkout_fields', 'change_billing_checkout_fields_onchange_shipping_method', 20);

add_action( 'woocommerce_after_checkout_validation', 'checkout_validation_unique_error', 9999, 2 );
//add_action( 'woocommerce_after_checkout_validation', 'validate_phone_field');

add_filter( 'woocommerce_package_rates', 'free_shipping_price_condition', 20, 2 );

add_filter( 'wc_add_to_cart_message_html', 'show_notice_condition', 10, 3 );

add_filter( 'woocommerce_default_address_fields' , 'filter_default_address_fields', 20, 1 );



function filter_default_address_fields( $address_fields ) {
	// Only on checkout page
	if( ! is_checkout() ) return $address_fields;

	// All field keys in this array
	$fields = array('country','city','state','postcode');

	// Loop through each address fields (billing and shipping)
	foreach( $fields as $key_field ){
		$address_fields[$key_field]['required'] = false;
	}


	return $address_fields;
}

function disable_checkout_terms_and_conditions(){
	remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
	remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
}


function checkout_validation_unique_error( $data, $errors ){

	// Check for any validation errors
	if( ! empty( $errors->get_error_codes() ) ) {

		// Remove all validation errors becouse incorrect translations
		foreach( $errors->get_error_codes() as $code ) {
			//$errors->remove( $code );
		}
		$errors->add( 'validation', __('Вкажіть всі обов\'язкові поля', 'html5blank') );

	}

	if ( ! empty( $_POST['billing_phone'] ) ) {
		$is_ua_valid = validate_phone_field( $_POST['billing_phone'] );
		if ( ! $is_ua_valid )
		{
			$errors->add( 'validation', __( 'Некоректний номер телефону', 'html5blank' ) );
		}
	}

}



function add_classes_for_inputs($fields) {
	foreach ($fields as &$fieldset) {
		foreach ($fieldset as &$field) {
			// add class around the label and the input
			//$field['class'][] = 'form-group';

			// add class to the actual input
			$field['input_class'][] = 'common-input';
		}
	}
	return $fields;
}


function change_woo_checkout_fields( $fields ): array {


	// billing fields
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_state']);
//	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_postcode']);

	$fields['billing']['billing_address_1']['label'] = __( 'Номер будинку на назва вулиці', 'html5blank' );

	$fields['billing']['billing_address_2']['label'] =  __( 'Квартира, офіс, блок, тощо', 'html5blank' );
	$fields['billing']['billing_address_2']['label_class'] = [''];

	$fields['billing']['billing_city']['priority'] = 45;




	// shipping fields
	unset($fields['shipping']['shipping_company']);
	unset($fields['shipping']['shipping_state']);
//	unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_postcode']);

	// Additional information
	$fields['order']['order_comments']['custom_attributes']['rows'] = 5;

	return $fields;
}


function free_shipping_price_condition( $rates, $package ) {

	$cart_amount = WC()->cart->get_subtotal();
	$free_level = 700;

	if ( $cart_amount >= $free_level )
	{

		foreach( $rates as $rate_key => $rate )
		{

			// For "free shipping" method (enabled), remove it
			if( $rate->method_id == 'free_shipping'){
				unset($rates[$rate_key]);
			}
			else {
				// For other shipping methods
				$rates[$rate_key]->cost = 0;

				// Set taxes rate cost (if enabled)
				$taxes = array();
				foreach ($rates[$rate_key]->taxes as $key => $tax){
					if( $rates[$rate_key]->taxes[$key] > 0 )
						$taxes[$key] = 0;
				}
				$rates[$rate_key]->taxes = $taxes;
			}
		}


	}

	return $rates;

}


/**
 * Dont show any notice if isset parameter in $_REQUEST
 *
 * @param $message
 * @param $products
 * @param $show_qty
 *
 * @return mixed|string
 */
function show_notice_condition( $message, $products, $show_qty )
{
	if(  $_REQUEST['is_show_notice'] === 'false' )
	{
		$message = '';
	}
	return $message;
}


/**
 * Set and unset fields when select specific shipping method:
 * --- local_pickup
 * --- nova_poshta_shipping
 * --- flat_rate
 *
 * Also, check woocommerce-checkout.js and add rules for
 * show correct labels
 *
 * @param $fields
 *
 * @return array
 */
function change_billing_checkout_fields_onchange_shipping_method($fields): array {

	$chosen_methods     = WC()->session->get( 'chosen_shipping_methods' );
	$chosen_shipping    = $chosen_methods[0];



	switch ( $chosen_shipping ) {

		case stripos( $chosen_shipping, 'nova_poshta_shipping' ):
		case stripos( $chosen_shipping, 'local_pickup' ) :

			$fields['billing']['billing_address_1']['required'] = false;
			$fields['billing']['billing_city']['required'] = false;

			break;


		case stripos( $chosen_shipping, 'flat_rate' ) :

			$fields['billing']['billing_address_1']['required'] = true;
			$fields['billing']['billing_city']['required'] = true;

			break;

	}

	return $fields;

}


/**
 * Validate phone number for UA rules
 *
 * @param $phone
 *
 * @return bool
 */
function validate_phone_field( $phone ): bool {
	$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
	try {
		$swissNumberProto   = $phoneUtil->parse( $phone , "UA");
		$isValid            = $phoneUtil->isValidNumberForRegion( $swissNumberProto, 'UA' );
		if ( ! $isValid ){
			//wc_add_notice( __( 'Некоректний номер телефону' ), 'error' );
			return false;
		}
		else return true;

	}
	catch (\libphonenumber\NumberParseException $e) {
		//wc_add_notice( __( 'Помилка валідації телефону' ), 'error' );
		return false;
	}
}



/**
 * Get shipping methods.
 */
function graevo_wc_cart_totals_shipping_html()
{
	$packages = WC()->shipping()->get_packages();
	$first    = true;

	foreach ( $packages as $i => $package ) {
		$chosen_method = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
		$product_names = array();

		if ( count( $packages ) > 1 ) {
			foreach ( $package['contents'] as $item_id => $values ) {
				$product_names[ $item_id ] = $values['data']->get_name() . ' &times;' . $values['quantity'];
			}
			$product_names = apply_filters( 'woocommerce_shipping_package_details_array', $product_names, $package );
		}

		wc_get_template(
			'cart/graevo-cart-shipping.php',
			array(
				'package'                  => $package,
				'available_methods'        => $package['rates'],
				'show_package_details'     => count( $packages ) > 1,
				'show_shipping_calculator' => is_cart() && apply_filters( 'woocommerce_shipping_show_shipping_calculator', $first, $i, $package ),
				'package_details'          => implode( ', ', $product_names ),
				/* translators: %d: shipping package number */
				'package_name'             => apply_filters( 'woocommerce_shipping_package_name', ( ( $i + 1 ) > 1 ) ? sprintf( _x( 'Shipping %d', 'shipping packages', 'woocommerce' ), ( $i + 1 ) ) : _x( 'Shipping', 'shipping packages', 'woocommerce' ), $i, $package ),
				'index'                    => $i,
				'chosen_method'            => $chosen_method,
				'formatted_destination'    => WC()->countries->get_formatted_address( $package['destination'], ', ' ),
				'has_calculated_shipping'  => WC()->customer->has_calculated_shipping(),
			)
		);

		$first = false;
	}
}



add_filter( 'woocommerce_cart_shipping_total', 'woocommerce_cart_shipping_total_filter_callback', 11, 2 );
function woocommerce_cart_shipping_total_filter_callback( $total, $cart )
{
	// Default total assumes Free shipping.
	$total = __( 'Free!', 'woocommerce' );
//
//	if ( 0 < $cart->get_shipping_total() ) {
//
//		if ( $cart->display_prices_including_tax() ) {
//			$total = wc_price( $cart->shipping_total + $cart->shipping_tax_total );
//
//			if ( $cart->shipping_tax_total > 0 && ! wc_prices_include_tax() ) {
//				$total .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
//			}
//		} else {
//			$total = wc_price( $cart->shipping_total );
//
//			if ( $cart->shipping_tax_total > 0 && wc_prices_include_tax() ) {
//				$total .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
//			}
//		}
//	}
//	return apply_filters( 'woocommerce_cart_shipping_total', $total, $cart );

	$cur_ship_id = wc_get_chosen_shipping_method_ids();

	$cart  = WC()->cart;
	$total = __( 'Free!', 'woocommerce' );
	if ( $cur_ship_id[0] === 'nova_poshta_shipping' ){
		$total = __( 'За тарифами Нової Пошти', 'html5blank' );
	}

	if ( 0 < $cart->get_shipping_total() ) {
		if ( $cart->display_prices_including_tax() ) {
			$total = wc_price( $cart->shipping_total + $cart->shipping_tax_total );

			if ( $cart->shipping_tax_total > 0 && ! wc_prices_include_tax() ) {
				$total .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		} else {
			$total = wc_price( $cart->shipping_total );

			if ( $cart->shipping_tax_total > 0 && wc_prices_include_tax() ) {
				$total .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		}
	}
	return  $total;

}
