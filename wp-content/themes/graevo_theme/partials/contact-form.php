<?php
if ( function_exists('get_field') )
{
	$title = get_sub_field('title');
}
?>

<div class="partials-contact-form">
	<div class="container py-6">
		<div class="row">
			<div class="offset-0 offset-lg-3 col-12 col-lg-6">
				<h4 class="font-prata w-100 mx-auto mb-5 text-center"> <?php echo $title ?> </h4>

				<form action="#"
				      class="simple_inputs d-flex flex-wrap"
				      id="contact_form" method="post">

					<?php wp_nonce_field(); ?>

					<label for="contact_form_phone" class="w-50 px-3 mb-5">
						<input type="text"
						       name="contact_form_phone"
						       id="contact_form_phone"
						       placeholder="<?php _e('Номер телефону', 'html5blank') ?>"
							   required
						       class="w-100 py-2 simple_input">
					</label>

					<label for="contact_form_email" class="w-50 px-3 mb-5">
						<input type="text"
						       name="contact_form_email"
						       id="contact_form_email"
						       placeholder="<?php _e('Email', 'html5blank') ?>"
							   required
						       class="w-100 py-2 simple_input" >
					</label>

					<label for="contact_form_comment" class="w-100 px-3 mb-5">
						<textarea name="contact_form_comment"
						          id="contact_form_comment"
						          class="w-100 p-2 simple_input"
						          placeholder="<?php _e('Текст повідомлення', 'html5blank') ?>"
						          rows="5"></textarea>
					</label>

					<div class="w-100 text-center">
						<button type="submit" class="btn btn-yellow text-center" id="contact_form_submit">
							<?php _e('Надіслати', 'html5blank') ?>
						</button>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
