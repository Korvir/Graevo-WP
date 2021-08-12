<?php
if ( function_exists('get_field') ) {
	$reCaptcha_site_key = get_field('recaptcha_site_key', 'options');
}
?>

<!-- Modal Event Registration -->
<div class="modal fade" id="by_one_click" tabindex="-1" role="dialog" aria-labelledby="by_one_click_Label" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content bg-c_grey_dark">

			<div class="modal-top-line w-100 d-flex align-items-center justify-content-start px-3 bg-c_yellow_light">
				<h5> <?php _e('Замовлення в один клік', 'html5blank') ?> </h5>
			</div>


			<div class="modal-top px-2 pt-1 text-center">
				<h3 class="px-2 py-4 font-prata d-inline-block modal-title text-center with-underline border-c_yellow_dark" id="event_registration_Label">
					<?php _e( 'Наш менеджер зв’яжеться з Вами.', 'html5blank' ); ?>
				</h3>
			</div>

			<div class="modal-body px-2 py-5 w-100">

				<?php
				if ( is_user_logged_in() )
				{
					$customer_name = WC()->customer->get_billing_first_name() . ' ' . WC()->customer->get_billing_last_name();
					$customer_phone = WC()->customer->get_billing_phone();
				}
				?>

				<form action="#" method="post" id="by_one_click_form">
					<div class=" modal-body--content d-flex flex-column align-items-center justify-content-center">

						<?php wp_nonce_field(); ?>

						<input type="hidden" id="product_id" name="product_id" value="">

						<div class="form-row w-100">
							<label for="name" class="d-flex flex-column w-100 mb-4">
								<span class="mb-1"> <?php _e('Ім\'я', 'html5blank' ) ?> <span class="required">*</span> </span>
								<input type="text" name="name" title="name" class="common-input" value="<?php echo $customer_name ?>" required >
							</label>
						</div>

						<div class="form-row w-100">
							<label for="phone" class="d-flex flex-column w-100 mb-4">
								<span class="mb-1"> <?php _e('Номер телефону', 'html5blank' ) ?> <span class="required">*</span> </span>
								<input type="text" name="phone" title="phone" class="common-input" value="<?php echo $customer_phone ?>" required >
							</label>
						</div>

						<div class="form-row w-100">
							<label for="phone" class="d-flex flex-column w-100 mb-4">
								<span class="mb-1"> <?php _e('Коментар', 'html5blank' ) ?> <span class="required">*</span> </span>
								<textarea name="comment" id="comment" title="comment" cols="30" rows="4" class="common-input"></textarea>
							</label>
						</div>

						<?php if ( $reCaptcha_site_key ) : ?>
							<div class="g-recaptcha" data-sitekey="<?php echo $reCaptcha_site_key ?>" ></div>
						<?php endif; ?>

						<div class="responce"></div>

					</div>


					<div class="modal-body--actions text-center pt-5">
						<button id="by_one_click__yes" type="submit" class="btn btn-white mx-1">
							<?php _e('Замовити зараз', 'html5blank' ) ?>
						</button>
					</div>

				</form>

			</div>

		</div>
	</div>
</div>
<!-- -->
