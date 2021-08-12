<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="container">


		<div class="row">
			<div class="col-12 text-center">
				<h2 class="pt-5 pb-3 d-inline-block font-prata with-underline"> <?php _e( 'Особистий кабінет', 'html5blank'); ?> </h2>
			</div>
		</div>


		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

		<div class="row mt-5" id="customer_login">

			<div class="col-12 col-lg-6 mb-5 mb-lg-0 px-xl-5 left-col">

		<?php endif; ?>

				<h4 class="mb-3"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h4>

				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="username">
							<?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span>
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="email" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input class=" common-input woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="form-row radio-checkbox-list">
						<ul class="d-flex align-items-start justify-content-start m-0 p-0">
							<li class="mr-3">
								<input class="common-input woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" for="rememberme"> <span> <?php esc_html_e( 'Remember me', 'woocommerce' ); ?> </span> </label>
							</li>
							<li class="mr-3">
								<span class="woocommerce-LostPassword lost_password">
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
								</span>
							</li>
						</ul>
					</div>

					<p class="form-row d-flex align-items-center justify-content-center mt-5">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<button type="submit" class="btn btn-white  woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
					</p>


					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

			</div>

			<div class="col-12 col-lg-6 mb-5 mb-lg-0 px-xl-5">

				<h4 class="mb-3"><?php esc_html_e( 'Register', 'woocommerce' ); ?></h4>

				<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="tsext" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>
					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input type="email" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="reg_billing_phone" value="<?php echo ( ! empty( $_POST['billing_phone'] ) ) ? esc_attr( wp_unslash( $_POST['billing_phone'] ) ) : ''; ?>" />
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="password" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<p class="form-row d-flex align-items-center justify-content-center mt-5">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="btn btn-white-transparent woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
					</p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>

			</div>

		</div>
		<?php endif; ?>

		<?php
		/**
		 * We use "wordpress-social-login" for registration.
		 * If this plugin is active - this block is displayed
		 **/
		if ( is_plugin_active( 'wordpress-social-login/wp-social-login.php' ) ) : ?>
		<!-- Social Login -->
		<div class="row mt-5" id="social_login">
			<div class="col-12 text-center">

				<h4 class="pt-5 pb-3 d-inline-block "> <?php _e( 'Або увійти за допомогою', 'html5blank'); ?> </h4>

				<?php do_action( 'wordpress_social_login' ); ?>

			</div>
		</div>
		<!-- -->
		<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
