(function ($, root, undefined) {

	$(document).ready(function () {
		console.log('admin js ready!!!');

		function formToJSON(f) {
			let fd = $(f).serializeArray();
			let d = {};
			$(fd).each(function() {
				if (d[this.name] !== undefined){
					if (!Array.isArray(d[this.name])) {
						d[this.name] = [d[this.name]];
					}
					d[this.name].push(this.value);
				}else{
					d[this.name] = this.value;
				}
			});
			return d;
		}



		// Update event row
		$('.event-user-confirm').on( 'click', function (event) {
			event.preventDefault();

			let _this = $(this);

			let parent_row = $(this).closest('.registered-users-row');
			let data = formToJSON( $(parent_row).find('input') );

			$.ajax({
				url: admin_vars.ajaxUrl,
				type: 'POST',
				data: {
					action: 'event_user_confirmation',
					data: data,
				},
				dataType: 'json',

				success:function(data) {
					console.log( 'success', $(_this) );
					$(_this).css('background', 'green');
				},
				complete: function (data) {
					//console.log( 'complete', data);
				},
				error:function(data) {
					console.log( 'error', data);
				}
			});
		});

		// Delete event row
		$('.event-user-delete').on( 'click', function (event) {
			event.preventDefault();

			let _this = $(this);

			let parent_row = $(this).closest('.registered-users-row');
			let data = formToJSON( $(parent_row).find('input') );

			$.ajax({
				url: admin_vars.ajaxUrl,
				type: 'POST',
				data: {
					action: 'event_user_delete',
					data: data,
				},
				dataType: 'json',

				success:function(data) {
					console.log( 'success', $(_this) );
					parent_row.remove();
				},
				complete: function (data) {
					//console.log( 'complete', data);
				},
				error:function(data) {
					console.log( 'error', data);
				}
			});
		});



		// $('#product_catchecklist  input[type=checkbox]').on('change', function (e) {
		// 	let test = $('#product_catchecklist  input[type=checkbox]:checked');
		// 	test.each(function( index, select ) {
		// 		console.log(select.value);
		// 		if(select.value == '22'){
		// 			initBundle = true;
		// 		}
		// 	});
		// });

		let initBundle = false;
		let bundle_val = $('.bundle_value input');
		let bundle_type =  $('.bundle_type input');

		if( $('#acf-group_60646fb5dca7e .acf-postbox.acf-hidden')) {

		}else{

			$('#_regular_price').prop('readonly', true);
			$("#_sale_price").prop('readonly', true);
		}

		$('.bundle_value input, .bundle_type input').on('change', function (e) {

			//clear val
			$('#_regular_price').val('');
			$("#_sale_price").val('');

			let bundle_list = $('#bundle_list .values-list li span');
			let bundle_types = $('.bundle_type input:checked').val();
			let bundle_val  = $('.bundle_value input').val();

			let current_type;

			if(bundle_types == '%'){
				current_type = 'percent';
			}else{
				current_type = 'number';
			}

			console.log(current_type);
			let bundle_products = [];

			bundle_list.each(function( index ) {
				let post_id = $(this).data('id');
				bundle_products.push(post_id);
			});

			if(bundle_val == 0 ){
				alert('Значення не можу бути 0!');
			}else{
				$.ajax({

					url: admin_vars.ajaxUrl,
					type: 'POST',
					data: {
						action: 'bundle_set_price',
						bundle_products:bundle_products,
						bundle_val: bundle_val,
						current_type: current_type
					},
				}).done(function (answer) {
					console.log(answer);
					try {
						if (answer.data.status === 200) {
							$('#_regular_price').prop('readonly', true).val(answer.data.full_regular);
							$("#_sale_price").prop('readonly', true).val(answer.data.full_sale);
							setTimeout(function (){
								$("#_sale_price").trigger('change');

							},100);
							setTimeout(function (){
								$('#_regular_price').trigger('change');
							},200);


						}

					} catch (err) {
						console.log('err', err);
					}
				});
			}


		}).trigger('change');
	});

})(jQuery);
