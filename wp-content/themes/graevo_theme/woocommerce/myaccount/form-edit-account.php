<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;


do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="container">
		<div class="row">

			<div class="col-12 col-md-6 left-col">

				<fieldset class="mb-5 px-0  px-xl-5">
					<legend><?php esc_html_e( 'Інформація', 'woocommerce' ); ?></legend>


					<!-- first name-->
					<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
						<label for="account_first_name">
							<?php esc_html_e( 'First name', 'woocommerce' ); ?>
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
					</p>

					<!-- last name -->
					<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
						<label for="account_last_name">
							<?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
					</p>

					<!-- phone -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_billing_phone">
							<?php _e( 'Phone', 'woocommerce' ); ?>
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="reg_billing_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>" />
					</p>

					<!-- email -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="account_email">
							<?php esc_html_e( 'Email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span>
						</label>
						<input type="email" class="common-input woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
					</p>
				</fieldset>

				<fieldset class="mb-5 px-0  px-xl-5">
					<legend><?php esc_html_e( 'Адреса', 'woocommerce' ); ?></legend>

					<!-- billing_state -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="billing_state">
							<?php esc_html_e( 'State', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_state" id="billing_state" value="<?php echo esc_attr( $user->billing_state ); ?>" />
					</p>

					<!-- billing_address_city -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="billing_city">
							<?php esc_html_e( 'City', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_city" id="billing_city" value="<?php echo esc_attr( $user->billing_city ); ?>" />
					</p>

					<!-- billing_address_1 -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="billing_address_1">
							<?php esc_html_e( 'Вулиця', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr( $user->billing_address_1 ); ?>" />
					</p>

					<!-- billing_address_2 -->
					<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
						<label for="billing_address_2">
							<?php esc_html_e( 'Дім', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--text input-text" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr( $user->billing_address_2 ); ?>" />
					</p>

					<!-- billing_address_3 -->
					<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
						<label for="billing_address_3">
							<?php esc_html_e( 'Квартира', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--texts input-text" name="billing_address_3" id="billing_address_3" value="<?php echo esc_attr( $user->billing_address_3 ); ?>" />
					</p>

					<!-- zip code -->
					<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
						<label for="billing_postcode">
							<?php esc_html_e( 'Postal Code', 'woocommerce' ); ?>&nbsp;
						</label>
						<input type="text" class="common-input woocommerce-Input woocommerce-Input--texts input-text" name="billing_postcode" id="billing_postcode" value="<?php echo esc_attr( $user->billing_postcode ); ?>" />
					</p>

				</fieldset>

			</div>

			<div class="col-12 col-md-6 right-col">
				<fieldset class="mb-5 px-0  px-xl-5">
					<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password_current">
							<?php esc_html_e( 'Поточний пароль', 'woocommerce' ); ?>
						</label>
						<input type="password" class="common-input woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password_1">
							<?php esc_html_e( 'Новий пароль', 'woocommerce' ); ?>
						</label>
						<input type="password" class="common-input woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password_2">
							<?php esc_html_e( 'Підтвердити новий пароль', 'woocommerce' ); ?>
						</label>
						<input type="password" class="common-input woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<small> <?php _e('Залиште ці поля порожніми, якщо не збираєтеся міняти пароль', 'woocommerce') ?></small>
					</p>
				</fieldset>
			</div>

			<div class="col-12 mt-5 mb-3 d-flex flex-column flex-md-row align-items-center justify-content-center">
				<?php do_action( 'woocommerce_edit_account_form' ); ?>
				<p class="text-center mx-3 my-3 my-md-3">
					<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
					<button type="submit" class="btn btn-white woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
					<input type="hidden" name="action" value="save_account_details" />
				</p>
				<p class="text-center mx-3 my-3 my-md-3">
					<a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"
					   class="btn btn-red d-flex align-items-center justify-content-center font-weight-bold  m-auto" >
						<?php _e('Logout', 'woocommerce') ?>
					</a>
				</p>
				<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
			</div>

		</div>
	</div>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
