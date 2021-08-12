<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="container">
	<div class="row">

		<div class="col-12 text-center">
			<h2 class="pt-5 pb-3 d-inline-block font-prata with-underline"> <?php _e( 'Особистий кабінет', 'html5blank'); ?> </h2>
		</div>

		<div class="col-12 p-0">
			<?php
			/**
			 * My Account navigation.
			 *
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_navigation' ); ?>
		</div>

		<div class="col-12">
			<div class="woocommerce-MyAccount-content">
				<?php
				/**
				 * My Account content.
				 *
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_content' );
				?>
			</div>
		</div>

	</div>
</div>



