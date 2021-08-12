(function ($, root, undefined) {

    $(document).ready(function () {
        console.log('ready!!!');

		// Open mobile menu
		$('#toggle-mobile-menu').on('click', function(event){
			event.preventDefault();
			$(document).find('body').addClass('overflow_this');
			$(document).find('.mobile-menu').css('right', 0);
		});

		// Close mobile menu
		$('#toggle-mobile-menu--close').on('click', function(event){
			event.preventDefault();
			$(document).find('body').removeClass('overflow_this');
			$(document).find('.mobile-menu').css('right', -100+'%');
		});

		$('.mobile-menu').on('click', '.menu-item a', function(event){

			//close menu
			$(document).find('body').removeClass('overflow_this');
			$(document).find('.mobile-menu').css('right', -100+'%');
			// open submenu
			$(this).children('.sub-menu').slideToggle('fast');
			$(this).children('.menu-item-has-children a').toggleClass('after_el_rotated');
		});

		$("a.anchor[href^='#']").on('click', function(e) {
			// prevent default anchor click behavior
			e.preventDefault();

			// animate
			$('html, body').animate({
				scrollTop: $(this.hash).offset().top - 60,
			}, 900, function(){
			});
		});

		$(".btn-play-wrap").on('click', function(e) {
			let video = $('video.embed-responsive-item')[0];
			if (video.paused) {
				video.play();
				$('.btn-play-wrap').addClass('hide');
			}
		});

		window.formToJSON = function (f) {
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

		window.show_adult_modal = function (f) {
			$('#adult_check').modal({
				backdrop: 'static',
				keyboard: true,
				show: true
			});
		}

		window.show_modal_by_id = function ( string ) {
			$( string ).modal('show');
		}

		window.hide_modal_by_id = function ( string ) {
			$( string ).modal('hide');
		}

	});

})(jQuery);
