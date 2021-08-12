<?php
// Add new Order Status
add_action( 'init', 'register_order_status_in_oneclick' );

// Register in wc_order_statuses.
add_filter( 'wc_order_statuses', 'in_oneclick_wc_order_statuses' );

// Registration Emails
add_filter( 'woocommerce_email_actions', 'add_woocommerce_email_actions' );


function register_order_status_in_oneclick() {
	register_post_status( 'wc-oneclick', array(
		'label'                     => _x( 'В один клік', 'Order status', 'woocommerce' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'В один клік <span class="count">(%s)</span>', 'В один клік <span class="count">(%s)</span>', 'woocommerce' )
	) );
}


function in_oneclick_wc_order_statuses( $order_statuses ) {
	$order_statuses['wc-oneclick'] = _x( 'В один клік', 'Order status', 'woocommerce' );
	return $order_statuses;
}


function add_woocommerce_email_actions( $actions ){
	$actions[] = 'woocommerce_order_status_wc-order-oneclick';
	return $actions;
}
