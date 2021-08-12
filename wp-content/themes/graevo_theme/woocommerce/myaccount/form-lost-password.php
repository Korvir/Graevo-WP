<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="container-1300 m-auto">
	<div class="row">

		<form method="post" class="w-100 woocommerce-ResetPassword lost_reset_password">
			<div class="d-flex flex-column align-items-center justify-content-center my-6 py-6">

				<p class="my-3 w-100 text-center">
					<?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?> <?php // @codingStandardsIgnoreLine ?>
				</p>

				<p class="my-3 woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
					<input class="common-input woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<p class="woocommerce-form-row form-row my-3">
					<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="btn btn-white-transparent woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
				</p>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

			</div>
		</form>

	</div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
