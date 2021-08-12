<?php
/* Template Name: Події / Заходи  */
get_header();

if ( function_exists( 'get_fields' ) ) {
	$event_fields = get_fields();
}
?>


<main role="main" class="template-events">

	<?php if ( $event_fields ) : ?>
		<section class="banner-with-text ">
			<div class="banner-with-text-wrapper w-100 position-relative d-flex align-items-center justify-content-start">

				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1 class="font-prata position-relative"> <?php echo $event_fields['banner_title'] ?>  </h1>
						</div>
					</div>
				</div>

				<div class="img-gradient"></div>
				<img src="<?php echo $event_fields['banner_image']['sizes']['medium'] ?>"
					 data-src="<?php echo $event_fields['banner_image']['url'] ?>"
					 class="w-100 blur-up lazyload"
					 width="100%"
					 alt="<?php echo $event_fields['banner_image']['alt'] ?>"
					 loading="lazy">

			</div>
		</section>
	<?php endif; ?>



	<?php
	$current_date = current_time('Y-m-d');
	$args  = [
		'post_type'  => 'cpt_events',
		'posts_per_page' => -1,
		'meta_query' => [
			[
				'key'     	=> 'date_time_event',
				'value'   	=> $current_date,
				'compare' 	=> '>=',
				'type'		=> 'date'
			]
		],
		'meta_key' => 'date_time_event',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	];
	$query = new WP_Query( $args );
	?>

	<?php if ( $query->posts ) : ?>

		<section class="events-slider my-3">
		<div class="container">
			<div class="row">

				<div class="my-5 events-slider--gallery col-12">
					<div class="events-flicktify-init main-carousel">
					<?php foreach ( $query->posts as $key => $single_event ) : ?>
						<div class="carousel-cell px-0 px-md-4 px-md-6 w-100  d-flex flex-column align-items-center justify-content-center">


							<?php if ( $single_event->post_title ) : ?>
							<div class="partials-slider--title col-12 text-center">
								<h3 class="py-5 px-5 px-md-4 px-md-6 d-inline-block font-prata with-underline"> <?php echo $single_event->post_title ?> </h3>
							</div>
							<?php endif; ?>


							<?php
							$event_date = get_post_meta( $single_event->ID,'date_time_event', true);
							if ( $event_date ) : ?>
								<div class="pt-5 px-0 px-md-4 px-md-6 partials-slider--desc col-12 text-center">
									<?php echo date_i18n('d.m.Y  H:i', strtotime( $event_date ) ) ?>
								</div>
							<?php endif; ?>


							<?php if ( $single_event->post_content ) : ?>
							<div class="pt-5 px-0 px-md-4 px-md-6 partials-slider--desc col-12 text-center">
								<?php echo $single_event->post_content ?>
							</div>
							<?php endif; ?>


							<?php
							$img_medium = get_the_post_thumbnail_url( $single_event->ID, 'medium' );
							$img_full 	= get_the_post_thumbnail_url( $single_event->ID, 'full' );

							if ( $img_medium || $img_full ) : ?>
								<img src="<?php echo $img_medium ?>"
									 data-src="<?php echo $img_full ?>"
									 class="pt-5 px-0 px-md-4 px-md-6 w-100 blur-up lazyload"
									 alt="event image"
									 width="100%" height="380"
									 loading="lazy" >
							<?php endif; ?>

							<button type="button"
									class="event-registration-btn my-5 btn btn-white"
									data-event_id="<?php echo $single_event->ID ?>"
									data-toggle="modal"
									data-target="#event_registration">
								<?php _e('Заєреструватися', 'html5blank' ) ?>
							</button>


						</div>
					<?php endforeach; ?>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php else: ?>

		<section class="my-6">
			<div class="container">
				<div class="row">
					<div class="col-12">

						<h3 class="font-prata my-6 text-center">
							<?php _e('Наразі немає жодного заходу', 'html5blank'); ?>
						</h3>

					</div>
				</div>
			</div>
		</section>

	<?php endif; ?>


</main>


<?php
get_template_part( '/partials/modal', 'event-registration');
?>

<?php get_footer(); ?>
