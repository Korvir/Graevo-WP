(function ($, root, undefined) {


	$(document).ready(function () {

		// Checkout form on init
		checkSelectedShippingMethod();

		// Create observer for Nova Poshta fields
		//maybeObserverStart();





		// Show or hide specific fields for selected method
		$('.woocommerce').on('click', '.shipping_method', function () {
			checkSelectedShippingMethod();
		});

	});






	function checkSelectedShippingMethod() {

		let currentShipping = $('.shipping_method').length > 1 ?
			$('.shipping_method:checked').val() :
			$('.shipping_method').val();

		// let np_address_delivery = $('#wcus_np_billing_custom_address_active').prop('checked');
		// console.log(np_address_delivery)



		if (currentShipping !== undefined) {

			// Rules for Local Pickap
			if (currentShipping.match(/^local_pickup.+/i) !== null) {
				const arr = [
					'billing_address_1_field',
					'billing_address_2_field',
					'billing_city_field',
				];

				const labels_req = [];

				const labels_no_req = [
					'billing_address_1_field',
					'billing_address_2_field',
					'billing_city_field',
				];

				convert_classes(arr, labels_req, labels_no_req);
			}


			// Rules for Nova Poshta
			if (currentShipping.match(/^nova_poshta_shipping.+/i) !== null ) {
				const arr = [];

				const labels_req = [];

				const labels_no_req = [
					'billing_address_1_field',
					'billing_address_2_field',
					'billing_city_field',
				];

				convert_classes(arr, labels_req, labels_no_req);
			}


			// Rules for Flat Rate
			if (currentShipping.match(/^flat_rate.+/i) !== null) {
				const arr = [];

				const labels_req = [
					'billing_address_1_field',
					'billing_city_field',
				];

				const labels_no_req = [];

				convert_classes(arr, labels_req, labels_no_req);
			}

		}


		return currentShipping;

	}

	function convert_classes(arr, labels_req, labels_no_req) {
		try {
			let elems = $('.woocommerce-billing-fields .form-row');
			$(elems).each(function () {

				$(this).removeClass('hide_field');
				// $(this).removeClass('validate-required');


				// Hide some fields
				if ($.inArray($(this).attr('id'), arr) !== -1) {
					$(this).addClass('hide_field');
				}

				// Validate required fields
				if ($.inArray($(this).attr('id'), labels_req) !== -1) {
					$(this).addClass('validate-required');
				}

				// set label requered for fields
				if ($.inArray($(this).attr('id'), labels_req) !== -1) {
					let label = $(this).find('label');
					$(label).find('span').remove();
					$(label).find('abbr').remove();
					$(label).append('<abbr class="required" title="обов\'язкове">*</abbr>');
				}

				// set label no requred for fields
				if ($.inArray($(this).attr('id'), labels_no_req) !== -1) {
					let label = $(this).find('label');
					$(label).find('span').remove();
					$(label).find('abbr').remove();
					$(label).append('<span className="optional">(необов\'язково)</span>');
				}


			});
		} catch (e) {
			console.log(e);
		}
	}

	function maybeObserverStart(){

		// Update 'cart-shipping' table on change Nova Poshta fields
		// Create an observer instance
		let target = $("#select2-wcus_np_billing_city-container")[0];

		if (target !== undefined ) {
			try {
				var observer = new MutationObserver(function (mutations) {
					mutations.forEach(function (mutation) {
						var newNodes = mutation.addedNodes; // DOM NodeList
						if (newNodes !== null) { // If there are new nodes added
							var $nodes = $(newNodes); // jQuery set
							$nodes.each(function () {
								var $node = $(this);

								$.ajax({
									url: '/?wc-ajax=update_order_review',
									type: 'POST',
									data: {
										security: wc_checkout_params.update_order_review_nonce,
										post_data: $('form.checkout').serialize()
									},

									success: function (data) {
										$(document).find('.woocommerce-checkout-review-order-table').empty().append(data.fragments['.woocommerce-checkout-review-order-table'])
									},
									complete: function (data) {
										console.log( 'complete', data);
									},
									error: function (data) {
										console.log('error', data);
									}

								});

							});
						}
					});
				});

				// Configuration of the observer:
				var config = {
					attributes: true,
					childList: true,
					characterData: true
				};

				// Pass in the target node, as well as the observer options
				observer.observe(target, config);

			} catch (e) {
				console.log('no observer', e);
			}
		}

		// Disable oserver if not checkout page
		let cur_url = window.location.href;
		if (cur_url !== app_vars.checkoutUrl && observer !== undefined) {
			observer.disconnect();
		}

	}


})(jQuery);

