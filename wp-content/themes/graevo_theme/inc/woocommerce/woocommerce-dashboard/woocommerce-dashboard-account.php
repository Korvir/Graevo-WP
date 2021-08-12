<?php
add_filter( 'woocommerce_account_menu_items', 'graevo_remove_account_links' );
add_filter( 'woocommerce_account_menu_items', 'graevo_reorder_account_links' );

add_action( 'parse_request', 'change_default_account_endpoint' ); // my-account/edit-account


function graevo_remove_account_links( $menu_links ) {
	unset( $menu_links['dashboard'] );
	unset( $menu_links['payment-methods'] );
	//unset( $menu_links['orders'] );
	unset( $menu_links['downloads'] );
	//unset( $menu_links['edit-account'] );
	unset( $menu_links['edit-address'] );
	unset( $menu_links['customer-logout'] );

	return $menu_links;
}


function graevo_reorder_account_links() {
	$myorder = array(
		'edit-account'      => __( 'Особисті дані', 'woocommerce' ),
		'orders'            => __( 'мої замовлення', 'woocommerce' ),
	);

	return $myorder;
}



function change_default_account_endpoint( $wp ) {
	// TODO: Check only allowed endpoints
	$allowed_endpoints = [
		'orders',
		'edit-account',
		'edit-address',
		'lost-password',
		'customer-wishlist',
		'customer-logout',
		'?action=registration'
	];

	if ( $wp->request === 'my-account' && is_user_logged_in() && ! $_GET['action'] ) {
		wp_redirect( '/my-account/edit-account' );
		exit;
	}

	//	if (
	//		preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $wp->request, $m ) &&
	//		( empty( $m[1] ) || ! in_array( $m[1], $allowed_endpoints ) )
	//	) {
	//		wp_redirect( '/my-account/edit-account' );
	//		exit;
	//	}
}
