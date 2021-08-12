try {
    window.jQuery = window.$ = require('jquery');
	require("owl.carousel/dist/owl.carousel.min");
	require("magnific-popup/dist/jquery.magnific-popup.min");
	require("bootstrap/dist/js/bootstrap.min");
	require("./modules/cookies");
    require("./modules/main");
	require("./modules/contact-form");
    require("./modules/header-menu");
	require("./modules/sliders");
	require("./modules/modals");
	require("./modules/zoomer");
	require("./modules/woocommerce");
	require("./modules/woocommerce-checkout");
}
catch (e) {
	console.log('JS ERROR!!!', e);
}







