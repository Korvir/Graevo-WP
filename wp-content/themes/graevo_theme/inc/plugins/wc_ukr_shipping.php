<?php

add_filter('wcus_get_areas', function ($areas) {
	unset($areas['71508128-9b87-11de-822f-000c2965ae0e']);

	return $areas;
});

//add_filter('wcus_checkout_validation_active', function ($active) {
//	return false;
//});

add_filter('wcus_calculate_shipping_cost', function ($cost, $orderData) {
	if ( $orderData->getSubTotal() >= 700 ){
		return 0;
	}
	return $cost;
//	return $orderData->getSubTotal() >= 700 ? 0 : 60;
}, 10, 2);
