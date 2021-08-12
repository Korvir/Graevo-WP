<?php
if ( function_exists('get_field') ) {
	$reCaptcha_site_key = get_field('recaptcha_site_key', 'options');
}
?>

<!-- Modal Event Registration -->
<div class="modal fade" id="event_registration" tabindex="-1" role="dialog" aria-labelledby="event_registration_Label" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content bg-c_grey_dark">

			<div class="modal-top-line w-100 bg-c_yellow_light"></div>


			<div class="modal-top px-2 pt-1 text-center">
				<h3 class="px-2 py-4 font-prata d-inline-block modal-title text-center with-underline border-c_yellow_dark" id="event_registration_Label">
					<?php _e( 'Реєстрація на дегустацію', 'html5blank' ); ?>
				</h3>
			</div>

			<div class="modal-body px-2 py-5 w-100">

				<form action="#" method="post" id="event_registartion_form">
					<div class=" modal-body--content d-flex flex-column align-items-center justify-content-center">

						<?php wp_nonce_field(); ?>

						<input type="hidden" id="event_id" name="event_id" value="">

						<div class="form-row w-100">
							<label for="name" class="d-flex flex-column w-100 mb-4">
								<span class="mb-1"> <?php _e('Ім\'я', 'html5blank' ) ?> <span class="required">*</span> </span>
								<input type="text" name="name" title="name" class="common-input" required >
							</label>
						</div>

						<div class="form-row w-100">
							<label for="phone" class="d-flex flex-column w-100 mb-4">
								<span class="mb-1"> <?php _e('Номер телефону', 'html5blank' ) ?> <span class="required">*</span> </span>
								<input type="text" name="phone" title="phone" class="common-input" required >
							</label>
						</div>

						<?php if ( $reCaptcha_site_key ) : ?>
						<div class="g-recaptcha" data-sitekey="<?php echo $reCaptcha_site_key ?>" ></div>
						<?php endif; ?>

						<div class="responce"></div>

					</div>


					<div class="modal-body--actions text-center pt-5">
						<button id="event_registration__yes" type="submit" class="btn btn-yellow mx-1">
							<?php _e('Заєреструватися', 'html5blank' ) ?>
						</button>
						<button id="event_registration__no" type="button" class="btn btn-grey mx-1" data-dismiss="modal">
							<?php _e( 'Скасувати', 'html5blank'); ?>
						</button>
					</div>

				</form>

			</div>

		</div>
	</div>
</div>
<!-- -->
