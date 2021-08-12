<?php
if ( function_exists( 'get_field' ) ) {
	$title = get_sub_field( 'title' );
	$text  = get_sub_field( 'text' );
	$video = get_sub_field( 'video' );
    $poster = get_sub_field( 'poster' );
}
global $SVG;
?>

<div class="partials-text-video mb-6 mt-0 mt-0 mt-sm-6">
	<div class="container">
		<div class="row">
			<div class="col-12 d-flex flex-column flex-lg-row px-0 px-lg-6">
				<div class="col-with-text p-5 d-flex flex-column align-items-center justify-content-center text-center bg-c_beige_light">
					<h2 class="font-prata with-underline pb-3 text-center text-c_dark"> <?php echo $title ?> </h2>
					<div class="text-c_dark pt-3"> <?php echo $text ?> </div>
					<div class="empty-with-border"></div>
				</div>
				<div class="col-with-video">
					<div class="embed-responsive embed-responsive-16by9">
						<?php if ( $video ) : ?>
                            <video class="embed-responsive-item" height="100" width="100" controls poster="<?php echo $poster ?>">
                                <source src="<?php echo $video ?>" type='video/mp4' />
                            </video>
                            <div class="btn-play-wrap">
                                <span><?= $SVG['play-icon'];?></span>
                            </div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



