(function ($, root, undefined) {
	$(document).ready(function () {

		// const cookiesFunc = require('cookies.js');
		let adult_checker = window.readCookie( 'adult_checker' );


		if ( adult_checker !== '1' )
		{
			setTimeout( show_adult_modal, 500);
		}



		// Adult check
		$('#adult_check__yes').on('click', function(event){
			event.preventDefault();
			createCookie( 'adult_checker', 1, 1 );
			$('#adult_check').modal('hide')
		});




		// Event registration
		$('.event-registration-btn').on('click', function(event){
			event.preventDefault();
			$(document).find('#event_id').val( $(this).data('event_id') );
		});

		$('#event_registration__no').on('click', function(event){
			event.preventDefault();
			$('#event_registartion_form').trigger("reset");
		});

		$('#event_registartion_form').on( 'submit', function (event) {
			event.preventDefault();
			let _this = $(this);
			let data = formToJSON( $(this) );
			$.ajax({
				url: app_vars.ajaxUrl,
				type: 'POST',
				data: {
					action: 'event_registration',
					data: data,
				},
				dataType: 'json',

				success:function(data) {
					console.log( 'success', data);
					if ( data.success ){
						hide_modal_by_id('#event_registration');
						$(_this).trigger("reset");
						grecaptcha.reset();
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h3 class="w-100 font-prata text-center">' + data.data + '</h3>' );
						show_modal_by_id( '#modal-response' );
					}
					else{
						hide_modal_by_id('#event_registration');
						$(_this).trigger("reset");
						grecaptcha.reset();
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h3 class="w-100 font-prata text-center">' + data.data + '</h3>' );
						show_modal_by_id( '#modal-response' );
					}
				},
				complete: function (data) {
					//console.log( 'complete', data);
				},
				error:function(data) {
					console.log( 'error', data);
					hide_modal_by_id('#event_registration');
					$(_this).trigger("reset");
					grecaptcha.reset();
					$(document).find('#modal-response .modal-body').empty();
					$(document).find('#modal-response .modal-body').append( '<h3 class="w-100 font-prata text-center">' + data.data + '</h3>' );
					show_modal_by_id( '#modal-response' );
					// hide_modal_by_id('#event_registration');
				}
			});
		});

		//hide cart modal
		$(document).on('click', '.btn-continue-modal', function (e) {
			hide_modal_by_id('#cart_modal');
		});
		$('.woocommerce-cart-modal .btn-close').on('click', function(event){
			hide_modal_by_id('#cart_modal');
		});





		// By in one click
		$('.by-one-click-btn').on('click', function(event){
			event.preventDefault();
			$(document).find('#product_id').val( $(this).data('product_id') );
		});

		$('#by_one_click_form').on( 'submit', function (event) {
			event.preventDefault();
			let _this = $(this);
			let data = formToJSON( $(this) );
			$.ajax({
				url: app_vars.ajaxUrl,
				type: 'POST',
				data: {
					action: 'by_one_click',
					data: data,
				},
				dataType: 'json',

				success:function(data) {

					if ( data.success ){
						hide_modal_by_id('#by_one_click');
						// $(_this).trigger("reset");
						grecaptcha.reset();
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h4 class="w-100 font-prata text-center">' + data.data.response + '</h4>' );
						show_modal_by_id( '#modal-response' );
					}
					else{
						hide_modal_by_id('#by_one_click');
						// $(_this).trigger("reset");
						grecaptcha.reset();
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h4 class="w-100 font-prata text-center">' + data.data.response + '</h4>' );
						console.log( 'error', data.data.error);
						show_modal_by_id( '#modal-response' );
					}
				},
				complete: function (data) {
					//console.log( 'complete', data);
				},
				error:function(data) {
					console.log( 'error', data);
					hide_modal_by_id('#event_registration');
					$(_this).trigger("reset");
					grecaptcha.reset();
					$(document).find('#modal-response .modal-body').empty();
					$(document).find('#modal-response .modal-body').append( '<h3 class="w-100 font-prata text-center">' + data.data + '</h3>' );
					show_modal_by_id( '#modal-response' );
					// hide_modal_by_id('#event_registration');
				}
			});
		});

	});
})(jQuery);
