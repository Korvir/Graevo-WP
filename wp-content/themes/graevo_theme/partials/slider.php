<?php
if ( function_exists( 'get_field' ) ) {
	$title       = get_sub_field( 'title' );
	$description = get_sub_field( 'description' );
	$gallery     = get_sub_field( 'gallery' );
}
?>


<section class="partials-slider my-3">
	<div class="container">
		<div class="row">


			<?php if ( $title ) : ?>
				<div class="partials-slider--title col-12 text-center">
					<h2 class="py-5 d-inline-block font-prata with-underline"> <?php echo $title ?> </h2>
				</div>
			<?php endif; ?>


			<?php if ( $description ) : ?>
				<div class="py-5 partials-slider--desc offset-0 col-12 offset-lg-2 col-lg-8  text-center">
					<?php echo $description ?>
				</div>
			<?php endif; ?>


			<?php if ( $gallery ) : ?>
				<div class="my-3 my-sm-5 partials-slider--gallery col-12">
					<div class="gallery-flicktify-init main-carousel">
						<?php
						foreach ( $gallery as $gallery_item ) {
							?>
							<div class="carousel-cell d-flex align-items-center justify-content-center">
                                <a class="image-popup-vertical-fit" href="<?php echo $gallery_item['sizes']['large'] ?>" >
                                    <img src="<?php echo $gallery_item['sizes']['medium'] ?>"
                                         data-src="<?php echo $gallery_item['url'] ?>"
                                         class="px-6 blur-up lazyload "
                                         alt="<?php echo $gallery_item['alt'] ?>"
                                         loading="lazy">
                                </a>

							</div>
							<?php
						}
						?>
					</div>
				</div>
			<?php endif; ?>


		</div>
	</div>
</section>

