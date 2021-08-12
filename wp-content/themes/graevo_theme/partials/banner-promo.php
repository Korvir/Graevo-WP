<?php
if ( function_exists('get_field') )
{
	$image_left     = get_sub_field('image_left');
	$image_right    = get_sub_field('image_right');
	$title          = get_sub_field('title');
	$desc           = get_sub_field('desc');
	$url            = get_sub_field('url');
}
?>


<?php if ( $title ) : ?>
<div class="partials-promo-banner">
	<div class="container-fluid mx-auto my-6">
		<div class="row">

			<div class="left-col col-12 col-lg-6 px-5 px-lg-6 py-6">

				<img src="<?php echo $image_left['sizes']['small'] ?>"
				     data-src="<?php echo $image_left['url'] ?>"
				     class="w-100 bg-image blur-up lazyload "
				     width="900" height="265"
				     alt="<?php echo $image_left['alt'] ?>"
				     loading="lazy">

				<h2 class="font-prata "> <?php echo $title ?> </h2>
				<p> <?php echo $desc ?> </p>
				<a href="<?php echo $url['url'] ?>"
				   class="link_with_arrow"
				   title="<?php echo $url['title'] ?>">
					<?php echo $url['title'] ?>
				</a>

			</div>


			<div class="right-col col-12 col-lg-6 px-0">
				<img src="<?php echo $image_right['sizes']['small'] ?>"
				     data-src="<?php echo $image_right['url'] ?>"
				     class="w-100 bg-image blur-up lazyload "
				     width="900" height="265"
				     alt="<?php echo $image_right['alt'] ?>"
				     loading="lazy">
			</div>

		</div>
	</div>
</div>
<?php endif; ?>
