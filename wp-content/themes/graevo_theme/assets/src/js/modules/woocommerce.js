(function ($, root, undefined) {


	$('body').on('click', '.product_qty_minus', function () {
        let qty = $(this).closest('.product_qty_custom');
        _decrease(qty);
    });
    $('body').on('click', '.product_qty_plus', function () {
        let qty = $(this).closest('.product_qty_custom');
        _increase(qty);
    });
    $('body').on('change', '.quantity input', function() {
        let qty = $(this).closest('.product_qty_custom');
        _updateCart(qty);
    });

    let qtyInput, qtyMinVal, qtyMaxVal;
    let gtySingle = function gtySingle() {
        if ($('.product_qty_custom').length == 0) {
            return;
        }
    };
    gtySingle()

    let _updateCart = function(qty) {

        setTimeout(function() {
            let item_qty = $(qty).find('.quantity input');
            let item_hash = $( item_qty ).attr( 'name' ).replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
            let item_quantity = $( item_qty ).val();
            let currentVal = parseFloat(item_quantity);

            qty_cart();
            function qty_cart() {

                $.ajax({
                    type: 'POST',
                    url: app_vars.ajaxUrl,
                    data: {
                        action: 'update_cart_shop',
                        hash: item_hash,
                        quantity: currentVal
                    },
                    beforeSend: function() {
                        $('.overlay_shop').css("display", "block");
                    },
                    success: function(response) {
                        $('.overlay_shop').css("display", "none");
                        $(document.body ).trigger( 'wc_fragment_refresh' );
                        $(document).find('.here_render_cart').empty();
                        $(document).find('.here_render_cart').html(response);
                    }
                });
            }
        }, 500);
    };
    // Call function _updateCart() if user do nothing 500ms
    let clickingTimer;
    let _decrease = function _decrease(qty) {
        qtyInput = $('input', qty);
        qtyMinVal = qtyInput.attr('min');
        qtyMaxVal = qtyInput.attr('max');
        let qrtCurrent = parseInt(qtyInput.val());

        if (qrtCurrent - 1 >= qtyMinVal) {
            qtyInput.val(qrtCurrent - 1);
        }


        clearTimeout(clickingTimer);
        clickingTimer = setTimeout(function() {
            _updateCart(qty);
        }, 500);
    };
    let _increase = function _increase(qty,e) {
        qtyInput = $('input', qty);
        qtyMinVal = qtyInput.attr('min');
        qtyMaxVal = qtyInput.attr('max');


        let qrtCurrent = parseInt(qtyInput.val());

        if (qrtCurrent == qtyMaxVal) {
            return false;
        }else{
            qtyInput.val(qrtCurrent + 1);
        }


        clearTimeout(clickingTimer);
        clickingTimer = setTimeout(function() {
            _updateCart(qty);
        }, 500);
    };

    // ajax remove product item
    $('.woocommerce-cart-modal').on( 'click', '.woocommerce a.remove', function(e) {
        e.preventDefault();
        let product_id  = $(document).find(this).attr('data-product_id');
        $.ajax({
            url: app_vars.ajaxUrl,
            type: 'POST',
            data: {
                action: 'remove_item_shop',
                product_id : product_id
            },
            beforeSend: function() {
                $('.overlay_shop').css("display", "block");
            },
            success: function(response) {
                console.log(response);
                $('.overlay_shop').css("display", "none");
                $( document.body ).trigger( 'wc_fragment_refresh' );
                $(document).find('.here_render_cart').empty();
                $(document).find('.here_render_cart').html(response);
            }
        })
    });

    // ajax coupon code
    $('.woocommerce-cart-modal').on( 'click', '.woocommerce .apply_coupon', function(e) {
        e.preventDefault();
        let coupon  = $(document).find('#coupon_code');
        let couponcode = coupon.val();
        $.ajax({
            url: app_vars.ajaxUrl,
            type: 'POST',
            data: {
                action: 'woocommerce_coupon_shop',
                couponcode : couponcode
            },
            beforeSend: function() {
                $('.overlay_shop').css("display", "block");
            },
            success: function(response) {
                $('.overlay_shop').css("display", "none");
                $( document.body ).trigger( 'wc_fragment_refresh');
                $(document).find('.here_render_cart').empty();
                $(document).find('.here_render_cart').html(response);
            }
        })
    });

    // ajax coupon code remove
    $('.woocommerce-cart-modal').on( 'click', 'a.woocommerce-remove-coupon', function(e) {
        e.preventDefault();
        let coupon  = $(document).find('#coupon_code');
        let couponcode = coupon.val();
        $.ajax({
            url: app_vars.ajaxUrl,
            type: 'POST',
            data: {
                action: 'woocommerce_coupon_shop_remove',
                couponcode : couponcode
            },
            beforeSend: function() {
                $('.overlay_shop').css("display", "block");
            },
            success: function(response) {
                $('.overlay_shop').css("display", "none");
                $( document.body ).trigger( 'wc_fragment_refresh');
                $(document).find('.here_render_cart').empty();
                $(document).find('.here_render_cart').html(response);
            }
        })
    });

    //popup
    // ajax_add_to_cart
    $(document).on('click', '.added_to_cart', function (e){
        e.preventDefault();
        $.ajax({
            url: app_vars.ajaxUrl,
            type: 'POST',
            data: {
                action: 'update_cart_shop',
            },
        })
            .done(function(response) {
                $(document).find('.here_render_cart').empty();
                $(document).find('.here_render_cart').html(response);
                $('#cart_modal').modal({
                    backdrop: 'static',
                    keyboard: true,
                    show: true
                });
            });
    });




	// My Account - Orders page
	$('.woocommerce-orders-table__cell').on( 'click', function (e){
		// e.preventDefault();
		$(this).closest('.order-line').toggleClass('selected');
		$(this).closest('.order-line').find('.woocommerce-order-details').slideToggle();
		// $(this).closest('.order-line').find('.woocommerce-orders-table__cell-order-status').toggleClass('hide');
	});

})(jQuery);
