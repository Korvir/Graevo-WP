<?php

// Cart fragments
add_filter( 'woocommerce_add_to_cart_fragments', 'add_to_cart_fragment' );

//modal cart
add_action('graevo_show_cart_modal', 'display_cart_in_modal', 10);

add_filter('woocommerce_cart_needs_shipping', 'woocommerce_remove_my_shipping', 10, 1);

//AJAX
add_action('wp_ajax_update_cart_shop', 'update_cart_shop');
add_action('wp_ajax_nopriv_update_cart_shop', 'update_cart_shop');

add_action('wp_ajax_remove_item_shop', 'remove_item_shop');
add_action('wp_ajax_nopriv_remove_item_shop', 'remove_item_shop');

add_action('wp_ajax_woocommerce_coupon_shop', 'woocommerce_coupon_shop');
add_action('wp_ajax_nopriv_woocommerce_coupon_shop', 'woocommerce_coupon_shop');

add_action('wp_ajax_woocommerce_coupon_shop_remove', 'woocommerce_coupon_shop_remove');
add_action('wp_ajax_nopriv_woocommerce_coupon_shop_remove', 'woocommerce_coupon_shop_remove');

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'graevo_empty_cart_message', 10 );



function add_to_cart_fragment( $fragments ) {
	$fragments['.cart-count']     = '<span class="cart-count">' . wc()->cart->get_cart_contents_count() . ' </span>';
	$fragments['.cart-amount']    = '<span class="cart-amount">' . wc()->cart->get_cart_total() . ' </span>';
	return $fragments;
}


function display_cart_in_modal(){
    global $SVG;
    ?>
    <div class="modal fade woocommerce-cart-modal" id="cart_modal" tabindex="-1" role="dialog" aria-labelledby="event_registration_Label" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content bg-c_grey_dark">
                <div class="modal-body pt-2 pb-5 w-100">
                    <h2 class="text-center mb-3 mb-xl-5"><?= _e('Кошик','html5blank') ?></h2>
                    <!-- Here will be rendered cart-->
                    <div class="here_render_cart"></div>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>
    <?php
}


function woocommerce_remove_my_shipping($needs_shipping)
{
    if (is_cart()) {
        return false;
    }
    return $needs_shipping;
}


function update_cart_shop() {

    if ( !empty( $_POST['hash'] ) ){
        $cart_item_key = $_POST['hash'];
        $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );
        $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );
        $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );
        if ( $passed_validation ) {
            WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
        }
        // Refresh the page
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }
    else{
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }
}


function remove_item_shop() {
    $cart = WC()->instance()->cart;
    $id = $_POST['product_id'];
    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);

    if($cart_item_id){
        $cart->set_quantity($cart_item_id, 0);
        echo  do_shortcode( '[woocommerce_cart]' );
    }
    die();

}


function woocommerce_coupon_shop() {
    global $woocommerce;
    $couponcode = $_POST['couponcode'];
    if (isset($_POST['couponcode'])) {
        WC()->cart->remove_coupons();
        $ret = WC()->cart->add_discount( $couponcode );
        $array = array('return' => $ret);
        // Refresh the page
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }else{
        // Refresh the page
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }
    exit;
}


function woocommerce_coupon_shop_remove() {
    global $woocommerce;
    $couponcode = $_POST['couponcode'];
    if (isset($_POST['couponcode'])) {
        WC()->cart->remove_coupons();
        $ret = WC()->cart->add_discount( $couponcode );
        $array = array('return' => $ret);
        // Refresh the page
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }else{
        // Refresh the page
        echo do_shortcode( '[woocommerce_cart]' );
        die();
    }
    exit;
}


function graevo_empty_cart_message() {
	$html  = '<p class="text-center cart-empty woocommerce-info">';
	$html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) );
	echo $html . '</p>';
}

