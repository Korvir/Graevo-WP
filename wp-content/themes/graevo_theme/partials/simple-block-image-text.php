<?php
if ( function_exists('get_field') )
{
	$image  = get_sub_field('image');
	$text   = get_sub_field('text');
}
?>



<section class="partials-delivery simple-block-image-text my-6 wysiwyg-editor">
	<div class="container-1400">
		<div class="row">

			<div class="col-12 col-md-6 px-3 px-md-6">
				<?php if ( $image ) : ?>
					<img src="<?php echo $image['sizes']['small'] ?>"
					     data-src="<?php echo $image['url'] ?>"
					     class="w-100 mb-5 blur-up lazyload "
					     alt="<?php echo $image['alt'] ?>"
					     loading="lazy">
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6 px-3 px-md-6">
				<?php echo $text ?>
			</div>

		</div>
	</div>
</section>


