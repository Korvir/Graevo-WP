let mix = require('laravel-mix');
require('laravel-mix-purgecss');


mix
	.js('assets/src/js/app.js', 'assets/dist/app.js')
	.js( 'assets/src/js/lazysizes.js', 'assets/dist/lazysizes.js')
	.sass('assets/src/scss/app.scss', 'assets/dist/app.css')

	// Vendors
	.sass('assets/src/scss/_vendors.scss', 'assets/dist/vendors.css')
	.options({
		processCssUrls: false
	})

	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'assets/dist/webfonts')


	// Purge
	.then( () => {
		console.log(' \n\n ⚠️  ⚠️  ⚠️  Laravel-Mix configure with purgecss-plugin. ⚠️  ⚠️  ⚠️ ');
		console.log(' ⚠️  ⚠️  ⚠️  Remember, that unused CSS-classes will be removed with "production" build !  ⚠️  ⚠️  ⚠️ \n\n');
	})
	.purgeCss(
		{
			enabled: mix.inProduction(),
			extend:{
				content: [
					"**/*.php",
					"**/*.html",
					"**/*.vue",
					"**/*.twig",
					"assets/src/**/*.js",
					"assets/src/**/*.jsx",
					"assets/src/**/*.ts",
					"assets/src/**/*.tsx",
				],
				safelist:[
					/lazyloaded/,
					/is-active/,
					/current-menu-item/,
					/added_to_cart/,
					/^woocommerce(-.*)?$/,
					/^flickity(-.*)?$/,
					/^mfp(-.*)?$/,
					/^wp-social-login(-.*)?$/,
					/^modal(-.*)?$/,
				],
				defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
			}
		}
	);
