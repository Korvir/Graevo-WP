<?php
add_filter( 'woocommerce_account_orders_columns', 'change_myAccount_orders_columns' );
add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'valid_order_statuses_for_cancel', 10, 1 );

function change_myAccount_orders_columns( $columns ): array {
	// Unset
	unset( $columns['order-actions'] );

	// Reorder
	$columns = [
		'order-number' => __( 'Order', 'woocommerce' ),
		'order-date'   => __( 'Date', 'woocommerce' ),
		'order-total'  => __( 'Total', 'woocommerce' ),
		'order-status' => __( 'Status', 'woocommerce' ),
	];

	return $columns;
}


/**
 * @param $statuses
 *
 * @return array
 */
function valid_order_statuses_for_cancel( $statuses ): array {
	return array_merge( $statuses, array('processing', 'pending'));
}
