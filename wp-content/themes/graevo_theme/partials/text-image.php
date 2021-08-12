<?php
if ( function_exists( 'get_field' ) ) {
	$title = get_sub_field( 'title' );
	$text  = get_sub_field( 'text' );
	$url   = get_sub_field( 'url' );
	$image = get_sub_field( 'image' );
}
?>

<div class="partials-text-image">
	<div class="container">
		<div class="row">
			<div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-center px-3 px-lg-6">

				<div class="empty-with-border"></div>

				<div class="col-with-text">
					<h2 class="font-prata text-center"> <?php echo $title ?> </h2>
					<p> <?php echo $text ?> </p>
					<a href="<?php echo $url['url'] ?>"
					   class="link_with_arrow"
					   title="<?php echo $url['title'] ?>">
						<?php echo $url['title'] ?>
					</a>
				</div>

				<div class="col-with-image">
					<img src="<?php echo $image['sizes']['small'] ?>"
						 data-src="<?php echo $image['url'] ?>"
						 class="w-100 blur-up lazyload "
						 width="835" height="540"
						 alt="<?php echo $image['alt'] ?>"
						 loading="lazy">
				</div>

			</div>
		</div>
	</div>
</div>
