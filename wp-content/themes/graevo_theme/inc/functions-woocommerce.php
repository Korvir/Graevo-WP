<?php
/**
 * Separete woocommerce functions
 * by templates where they used
 */
require 'woocommerce/woocommerce-core-options.php';
require 'woocommerce/woocommerce-login-registration.php';
require 'woocommerce/woocommerce-dashboard.php';
require 'woocommerce/woocommerce-shop.php';
require 'woocommerce/woocommerce-single-product.php';
require 'woocommerce/woocommerce-cart.php';
require 'woocommerce/woocommerce-checkout.php';



add_action( 'init', 'register_product_category');
add_filter( 'woocommerce_enqueue_styles', 'woocommerce_dequeue_styles' );
add_filter( 'woocommerce_currency_symbol', 'graevo_change_existing_currency_symbol', 10, 2);
add_filter( 'woocommerce_product_single_add_to_cart_text', 'graevo_custom_single_add_to_cart_text',10, 2  );
add_filter( 'woocommerce_product_add_to_cart_text', 'graevo_custom_product_add_to_cart_text', 10, 2  );

add_filter( 'woocommerce_min_password_strength', 'woocommerce_password_strength', 10 );
add_filter( 'password_hint', 'smarter_password_hint' );




/**
 * Register category term on wp initialization for Woocommerce taxonomy 'product_cat'
 */
function register_product_category()
{

	if ( ! term_exists('akczijni-tovary') )
	{
		wp_insert_term(
		__('Акційні товари', 'html5blank' ),
		'product_cat',
		array(
			'slug' => 'akczijni-tovary',
		));
	}

}


/**
 * Reduce the strength requirement for woocommerce registration password.
 * Strength Settings:
 * 0 = Nothing = Anything
 * 1 = Weak
 * 2 = Medium
 * 3 = Strong (default)
 * @return int
 */
function woocommerce_password_strength(): int {
	return 0;
}


/**
 * Change password hint
 * Set it empty for now
 * @param $hint
 *
 * @return string
 */
function smarter_password_hint ( $hint ): string {
	$hint = '';
	return $hint;
}


/**
 * Remove WooCommerce style
 */
function woocommerce_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	    // common styles
// unset( $enqueue_styles['woocommerce-layout'] );		// layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Rsmallscreen optimisation
	return $enqueue_styles;
}


/**
 * Change a currency symbol
 */
function graevo_change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'UAH': $currency_symbol = 'грн'; break;
    }
    return $currency_symbol;
}


// To change add to cart text on single product page
function graevo_custom_single_add_to_cart_text($text, $product) {
    if( $product->is_type( 'variable' ) ){
        $text = __('Вибрати', 'woocommerce');
    }else{
        $text = __('В кошик', 'woocommerce');
    }
    return $text;
}


// To change add to cart text on product archives(Collection) page
function graevo_custom_product_add_to_cart_text($text, $product) {
    if( $product->is_type( 'variable' ) ){
        $text = __('Вибрати', 'woocommerce');
    }else{
        $text = __('В кошик', 'woocommerce');
    }
    return $text;
}


/**
 * Generate order status name
 * @param object $order
 * @param false $margin
 *
 * @return false|string
 */
function woocommerce_render_order_status_name( object $order, $margin = false )
{

	if ( $margin === true ) $btn_margin = 'mb-5';

	$order_status = $order->get_status();
	switch( $order_status )
	{
		case 'completed':
			$btn_type = 'text-c_green_light';
			break;
		case 'cancelled':
		case 'failed':
			$btn_type = 'text-c_red_light';
			break;
		default:
			$btn_type = 'text-c_yellow_dark';
			break;
	}

	ob_start();
	?>
	<strong class="<?php echo $btn_type ?> <?php echo $btn_margin ?>" >
		<?php echo esc_html( wc_get_order_status_name( $order_status ) ); ?>
	</strong>
	<?php
	return ob_get_clean();

}


/**
 * Display an 'order again' button on the view order page.
 *
 * @param object $order Order.
 * @param bool $type
 */
function woocommerce_render_order_again_button( object $order, bool $type ) {

	if ( ! $order || ! $order->has_status( apply_filters( 'woocommerce_valid_order_statuses_for_order_again', array( 'completed' ) ) ) || ! is_user_logged_in() ) {
		return;
	}

	switch ( $type ) {
		case 1:
			wc_get_template(
				'order/order-again-button.php',
				array(
					'order'           => $order,
					'order_again_url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
				)
			);
			break;
		default:
			wc_get_template(
				'order/order-again.php',
				array(
					'order'           => $order,
					'order_again_url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
				)
			);
			break;
	}

}


/**
 * @param object $order
 *
 * @return false|string|void
 */
function woocommerce_render_order_payment_button( object $order )
{
	if ( ! $order->has_status( 'pending' ) ) {
		return;
	}
	$pay_now_url = esc_url( $order->get_checkout_payment_url() );

	ob_start();
	?>
	<div class="d-flex">
		<a href="<?php echo esc_url( $pay_now_url ); ?>" class="btn btn-white-transparent mb-3 font-weight-bold button d-flex align-items-center justify-content-center"><?php esc_html_e( 'Сплатити', 'html5blank' ); ?></a>
	</div>
	<?php
	return ob_get_clean();

}


/**
 * Order cancel button
 * @param object $order
 *
 * @return false|string|void
 */
function woocommerce_render_order_cancel_button( object $order )
{
	if ( ! $order->has_status( array( 'pending', 'processing' ) ) ) {
		return;
	}
	$cancel_url = esc_url(  $order->get_cancel_order_url( wc_get_endpoint_url( 'orders' ) ) );

	ob_start();
	?>
	<div class="d-flex">
		<a href="<?php echo esc_url( $cancel_url ); ?>" class="btn btn-red mb-3 font-weight-bold button d-flex align-items-center justify-content-center"><?php esc_html_e( 'Cancel', 'woocommerce' ); ?></a>
	</div>
	<?php
	return ob_get_clean();

}



