<?php

if ( function_exists('get_field') )
{
	$image = get_sub_field('image');
	$image_mobile = get_sub_field('image_mobile');
}
?>



<?php if ( $image || $image_mobile ) : ?>

	<section class="partials-banner">
		<div class="container-fluid">
			<div class="row">
				<div class="w-100">

					<img src="<?php echo $image['sizes']['medium'] ?>"
					     data-src="<?php echo $image['url'] ?>"
					     class="w-100 blur-up lazyload d-none d-md-flex"
					     width="100%"
					     alt="<?php echo $image['alt'] ?>"
					     loading="lazy" >

					<img src="<?php echo $image_mobile['sizes']['medium'] ?>"
						 data-src="<?php echo $image_mobile['url'] ?>"
						 class="w-100 blur-up lazyload d-flex d-md-none"
						 width="100%"
						 alt="<?php echo $image_mobile['alt'] ?>"
						 loading="lazy" >

				</div>
			</div>
		</div>
	</section>

<?php endif; ?>

