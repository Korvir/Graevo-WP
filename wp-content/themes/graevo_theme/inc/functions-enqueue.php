<?php
add_action('wp_enqueue_scripts', 'theme_scripts');
add_action('wp_enqueue_scripts', 'theme_styles');
add_filter('script_loader_tag', 'scripts_add_defer_or_async', 10, 2);


add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

add_action( 'admin_enqueue_scripts', 'admin_assets' );





function theme_scripts()
{
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'lazysizes', get_template_directory_uri() . '/assets/dist/lazysizes.js', array(), $ver, true );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/dist/app.js', array(), $ver, true);

	wp_localize_script( 'app', 'app_vars', array(
		'ajaxUrl' => admin_url("admin-ajax.php"),
		'checkoutUrl' => wc_get_checkout_url()
	) );
}



function theme_styles()
{
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style('gfont-roboto', 'https://fonts.googleapis.com/css2?family=Prata&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', array(), $ver, 'all');
	wp_enqueue_style('gfont-prata', 'https://fonts.googleapis.com/css2?family=Prata&display=swap', array(), $ver, 'all');

	wp_enqueue_style('vendors', get_template_directory_uri() . '/assets/dist/vendors.css', array(), $ver, 'all');
	wp_enqueue_style('app', get_template_directory_uri() . '/assets/dist/app.css', array(), $ver, 'all');

}



function admin_assets(){
	wp_enqueue_style('theme-admin-style',    get_stylesheet_directory_uri() . '/assets/dist/admin/admin_style.css');
	wp_enqueue_script('theme-admin-script',  get_stylesheet_directory_uri() .'/assets/dist/admin/admin_script.js');
	wp_localize_script( 'theme-admin-script', 'admin_vars', array(
		'ajaxUrl' => admin_url("admin-ajax.php")
	) );
}



function sdt_remove_ver_css_js( $src, $handle )
{
	$handles_with_version = [ 'style' ]; // <-- Adjust to your needs!
	if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}


function scripts_add_defer_or_async($tag, $handle)
{
	if ( is_admin() ){
		return $tag;
	}

	$handles = [
		'vendors',
		'bootstrap',
		'app',
	];
	$handles_aysnc = [
//		'jquery',
		'lazysizes',
		'jquery-migrate',
	];

	foreach ($handles as $defer_script) {
		if ($defer_script === $handle) {
			return str_replace(' src', ' defer="defer" src', $tag);
		}
	}

	foreach ($handles_aysnc as $async_script) {
		if ($async_script === $handle) {
			return str_replace(' src', ' async src', $tag);
		}
	}

	return $tag;
}
