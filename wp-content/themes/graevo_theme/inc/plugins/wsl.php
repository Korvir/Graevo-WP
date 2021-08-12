<?php
/**
 * Change template for wsl buttons
 */
add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'wsl_custom_button_template', 10, 3 );
function wsl_custom_button_template( $provider_id, $provider_name, $authenticate_url )
{
	global $SVG;

	?>
	<a
		rel           = "nofollow"
		href          = "<?php echo $authenticate_url; ?>"
		data-provider = "<?php echo $provider_id ?>"
		class         = "btn btn-square btn-<?php echo strtolower( $provider_id ); ?> m-3 d-flex align-items-center justify-content-center wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?>"
	>
		<?php echo $SVG[strtolower($provider_id)] ?>
		<?php echo $provider_id ?>
	</a>
	<?php
}


// display WSL widget in woocommerce forms
add_action( 'woocommerce_before_customer_login_form', 'wsl_action_wordpress_social_login' );
add_action( 'woocommerce_before_checkout_form'      , 'wsl_action_wordpress_social_login' );

/**
 * Our hooked in function - $fields is passed via the filter
 */
function custom_override_checkout_fields( $fields )
{
	$current_user = wp_get_current_user();

	$fields['billing']['billing_first_name']['default'] = $current_user->user_firstname;
	$fields['billing']['billing_last_name']['default']  = $current_user->user_lastname;

	return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
