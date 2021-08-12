(function ($, root, undefined) {
	$(document).ready(function () {
		$('.menu').on('click', '.menu-item a[href^=\'#\']', function(event){
			event.preventDefault();

			let menus = $(document).find('.sub-menu');
			let cur_menu = $(this).siblings('.sub-menu');

			if ( cur_menu.hasClass('active') ) {
				cur_menu.removeClass('active');
			}
			else{
				$(document).find('.menu-item a').removeClass('active');
				menus.removeClass('active');
				$(this).addClass('active');
				cur_menu.addClass('active');
			}

		});


		// Open mobile menu
		$('#toggle-mobile-menu').on('click', function(event){
			event.preventDefault();
			$(document).find('body').addClass('overflow_this');
			$(document).find('.mobile-menu').css('left', 0);
		});


		// Close mobile menu
		$('#toggle-mobile-menu--close').on('click', function(event){
			event.preventDefault();
			$(document).find('body').removeClass('overflow_this');
			$(document).find('.mobile-menu').css('left', -100+'%');
		});


		$('.mobile-menu').on('click', '.menu-item-has-children', function(event){
			// event.preventDefault();
			$(this).children('.sub-menu').slideToggle('fast');
		});



		$(' .search-button').on('click', function (event){
			event.preventDefault();
			$(document).find('.search-form-wrap').slideToggle('fast');
			$(this).removeClass('d-flex').hide();
			$(document).find('.search-button-close').addClass('d-flex');
		});
		$('.search-button-close').on('click', function (event){
			event.preventDefault();
			$(document).find('.search-form-wrap').slideToggle('fast');
			$(this).removeClass('d-flex');
			$(document).find('.search-button').addClass('d-flex').show();
		});

	});




	$(window).on('resize', function(){


		let win = $(this);


		if (win.width() >= 991) {
			//$('#header-search-form').css('display', 'flex');
		} else{
			//$('#header-search-form').css('display', 'none');
		}

	});

})(jQuery);
