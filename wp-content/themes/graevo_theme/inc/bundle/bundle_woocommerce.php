<?php
// Event User Delete
add_action( 'wp_ajax_bundle_set_price', 'bundle_set_price' );
add_action( 'wp_ajax_nopriv_bundle_set_price', 'bundle_set_price' );

function bundle_set_price() {

	$full_cost_del  = 0;
	$full_cost_inst = 0;
	$full_price     = 0;

	$bundle_products = $_POST['bundle_products'];
	$bundle_type     = $_POST['current_type'];
	$bundle_val      = $_POST['bundle_val'];

	// Get summary price for list items
	foreach ( $bundle_products as $item )
	{
		$product_item = wc_get_product( $item );

		if ( !empty( $product_item->get_sale_price() ) ) {
			$b_product_price = $product_item->get_sale_price();
		} else {
			$b_product_price = $product_item->get_regular_price();
		}

		//$b_product_price    = $product_item->get_sale_price() ?? $product_item->get_regular_price();
		$full_price         += $full_cost_del + (float) $b_product_price;
	}


	// Сalculation
	if ( $bundle_type == 'percent' ) {
		$sale_percent   = (float) $full_price * (float) $bundle_val / 100;
		$item_sale      = (float) $full_price - $sale_percent;
	}
	else {
		$item_sale      = $full_price - (float) $bundle_val;
	}
	$full_cost_inst = $full_cost_inst + $item_sale;


	wp_send_json_success([
		'status'            => 200,
		'full_regular'      => $full_price,
		'full_sale'         => $full_cost_inst
	]);

}
