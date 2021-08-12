<?php
/* Template Name: Контакти  */
get_header();

global $SVG;
if ( function_exists( 'get_fields' ) ) {
	$contact_fields = get_fields();
}
?>


<main role="main" class="template-contacts">

	<section class="contacts">

		<div class="container">
			<div class="row">

				<div class="col-12 text-center">
					<h2 class="pt-5 pb-3 d-inline-block font-prata with-underline"> <?php echo the_title() ?> </h2>
				</div>

			</div>
		</div>

		<?php if ( $contact_fields ) : ?>
		<div class="container-1400 py-6 my-6">
			<div class="row">

				<?php if ( $contact_fields['address_text'] ) : ?>
				<div class="contact-col col-12 col-md-4 d-flex flex-column align-items-center justify-content-start">

					<h4 class="text-c_yellow_light text-center"> <?php echo $contact_fields['address_title'] ?> </h4>
					<div class="mt-4">
						<p class="mb-3 d-flex align-items-center justify-content-between">
						<?php echo $contact_fields['address_text'] ?>
						</p>
					</div>

				</div>
				<?php endif; ?>


				<?php if ( $contact_fields['work_schedule_list'] ) : ?>
					<div class="contact-col col-12 col-md-4">
						<h4 class="text-c_yellow_light text-center"> <?php echo $contact_fields['work_schedule_title'] ?>  </h4>
						<?php if ( $contact_fields['work_schedule_list'] ) : ?>
							<div class="mt-4">
								<?php foreach (  $contact_fields['work_schedule_list'] as $value ) : ?>
								<p class="mb-3 d-flex align-items-center justify-content-between">
									<span class="d-inline-block px-2"> <?php echo $value['day'] ?> </span>
									<span class="d-inline-block px-2"> <?php echo $value['time'] ?> </span>
								</p>
								<?php endforeach;?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>


				<?php if ( $contact_fields['contact_with_us_phones'] ) : ?>
					<div class="contact-col col-12 col-md-4">
						<h4 class="text-c_yellow_light text-center"> <?php echo $contact_fields['contact_with_us_title'] ?>  </h4>
						<div class="mt-4">
							<?php if ( $contact_fields['contact_with_us_phones'] ) : ?>
								<?php foreach (  $contact_fields['contact_with_us_phones'] as $key => $value2 ) : ?>
									<p class="mb-3 d-flex align-items-center justify-content-between">
										<span class="d-inline-block px-2"> <?php echo $key === 0 ? __('Телефон') : '' ?> </span>
										<span class="d-inline-block px-2"> <?php echo $value2['phone_number'] ?> </span>
									</p>
								<?php endforeach;?>
							<?php endif; ?>

							<?php if ( $contact_fields['contact_with_us_email'] ) : ?>
								<p class="mb-3 d-flex align-items-center justify-content-between">
									<span class="d-inline-block px-2"> <?php _e('Email', 'html5blank') ?> </span>
										<a class="d-inline-block px-2" href="mailto:<?php echo $contact_fields['contact_with_us_email'] ?>">
											<?php echo $contact_fields['contact_with_us_email'] ?>
										</a>
									</span>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php endif; ?>


		<?php if ( $contact_fields['google_iframe'] ) : ?>
		<div class="google-street-view">
			<div class="container-fluid">
				<div class="row">
					<div class="w-100">
                        <?php echo $contact_fields['google_iframe']; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

	</section>



	<?php
	if (have_posts() ):
	while ( have_posts() ) : the_post() ;

		if ( have_rows('page-partials' )  ) {
			while( have_rows('page-partials') )
			{
				the_row();
				$layout = get_row_layout();
				$inclusion = get_stylesheet_directory() . DIRECTORY_SEPARATOR . "partials" . DIRECTORY_SEPARATOR ."{$layout}.php";

				if( file_exists( $inclusion ) )
				{
					include( $inclusion );
				}

			}
		}

	endwhile;
	endif;
	?>

</main>


<?php get_footer(); ?>
