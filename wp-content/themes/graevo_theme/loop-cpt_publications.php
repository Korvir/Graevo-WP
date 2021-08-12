<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		if ( function_exists('get_field') )
		{
			$link = get_field( 'link' );
			$file = get_field( 'file' );
		}
		?>
		<div class="container single-cpt_publications py-5">
			<div class="row">

				<div class="col-12 col-lg-6">
					<?php if ( has_post_thumbnail() ) : ?>

						<?php
						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						$src_thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
						$src_large = wp_get_attachment_image_src( $thumbnail_id, 'large' );
						?>
						<img src="<?php echo $src_thumb[0] ?>"
							 data-src="<?php echo $src_large[0] ?>"
							 class="w-100 d-flex flex-column align-items-start justify-content-center m-auto blur-up lazyload"
							 height="300"
							 alt="<?php the_title(); ?>"
							 loading="lazy" >

					<?php else : ?>

						<?php
						$src_no_img = no_image($sq = true);
						?>
						<img src="<?php echo $src_no_img ?>"
							 data-src="<?php echo $src_no_img ?>"
							 class="blur-up lazyload"
							 height="300"
							 alt="<?php the_title(); ?>"
							 loading="lazy" >

					<?php endif; ?>
				</div>


				<div class="col-12 col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center pt-3 pt-lg-0 " >

					<h2 class="mb-2 text-center text-lg-left">
						<?php the_title(); ?>
					</h2>

					<a href="<?php echo $link['url'] ?>" target="_blank" class="mb-2 text-center text-lg-left">
						<?php echo $link['title'] ?>
					</a>

					<a href="<?php echo $file['url'] ?>" target="_blank" class="mb-2 text-center text-lg-left">
						<?php _e('Article in PDF', 'html5blank'); ?>
					</a>

					<br>
					<?php edit_post_link(); ?>

				</div>

			</div>
		</div>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
