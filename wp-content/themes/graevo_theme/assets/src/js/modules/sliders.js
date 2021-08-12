// import Flickity from 'flickity';
let Flickity = require('flickity');


// Gallery Slider
if ( document.querySelector(".gallery-flicktify-init") ) {

	let galleryElems = document.querySelectorAll('.gallery-flicktify-init');

	for ( let i = 0, len = galleryElems.length; i < len; i++ ) {
		let galleryElem = galleryElems[i];

		new Flickity( galleryElem, {
			wrapAround: true,
			imagesLoaded: true,
			percentPosition: false,
			groupCells: true,
			cellSelector: '.carousel-cell',
			lazyLoad: true,
			prevNextButtons: true,
			draggable: true,
			pageDots: false,
			fade: true,
			cellAlign: 'left',
			contain: true
		});

	}

}


// Products Slider
if ( document.querySelector(".products-flicktify-init") ) {

	let galleryElems = document.querySelectorAll('.products-flicktify-init');

	for ( let i = 0, len = galleryElems.length; i < len; i++ ) {
		let galleryElem = galleryElems[i];

		new Flickity( galleryElem, {
			wrapAround: true,
			imagesLoaded: true,
			percentPosition: false,
			groupCells: false,
			cellSelector: '.carousel-cell',
			lazyLoad: true,
			prevNextButtons: true,
			draggable: true,
			pageDots: false,
			fade: true,
			cellAlign: 'left',
			contain: true,
			autoPlay: 5000,
			pauseAutoPlayOnHover: true
		});

	}

}



// Event slider
if ( document.querySelector(".events-flicktify-init") ) {

	let galleryElems = document.querySelectorAll('.events-flicktify-init');

	for ( let i = 0, len = galleryElems.length; i < len; i++ ) {
		let galleryElem = galleryElems[i];

		new Flickity( galleryElem, {
			wrapAround: true,
			imagesLoaded: true,
			percentPosition: false,
			groupCells: false,
			cellSelector: '.carousel-cell',
			lazyLoad: true,
			prevNextButtons: true,
			draggable: true,
			pageDots: false,
			fade: true,
			cellAlign: 'left',
			contain: true
		});

	}

}

// Stoke product slider
if ( document.querySelector(".owl-carousel") ) {

	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:50,
		nav:true,
		autoHeight: true,
		navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1200:{
				items:2
			}
		}
	})

}

$('.image-popup-vertical-fit').magnificPopup({
	type: 'image',
	closeOnContentClick: true,
	image: {
		verticalFit: false
	}
});