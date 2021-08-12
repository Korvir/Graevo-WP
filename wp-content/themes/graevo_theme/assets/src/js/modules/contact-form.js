(function ($, root, undefined) {
	$(document).ready(function () {


		$('#contact_form').on( 'submit', function (event) {
			event.preventDefault();

			let data = formToJSON( $(this) );

			$.ajax({
				url: app_vars.ajaxUrl,
				type: 'POST',
				data: {
					action: 'add_feedback',
					data: data,
				},
				dataType: 'json',

				success:function(data) {
					console.log( 'success', data);
					if ( data.success ){
						$('#contact_form').trigger("reset");
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h4 class="w-100 font-prata text-center">' + data.data.response + '</h4>' );
						show_modal_by_id( '#modal-response' );
					}
					else{
						console.log( 'error', data.data.error);
						$(document).find('#modal-response .modal-body').empty();
						$(document).find('#modal-response .modal-body').append( '<h4 class="w-100 font-prata text-center">' + data.data.response + '</h4>' );
						show_modal_by_id( '#modal-response' );
					}
				},
				complete: function (data) {
					//console.log( 'complete', data);
				},
				error:function(data) {
					console.log( 'error', data);
					$(document).find('#modal-response .modal-body').empty();
					$(document).find('#modal-response .modal-body').append( '<h3 class="w-100 font-prata text-center">' + data.data + '</h3>' );
					show_modal_by_id( '#modal-response' );
				}

			});


		});



	});
})(jQuery);
