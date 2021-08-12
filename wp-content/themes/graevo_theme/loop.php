<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="container single-post py-5">
			<div class="row">

				<div class="col-12 col-md-6">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php
							$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
							$src_thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
							$src_large = wp_get_attachment_image_src( $thumbnail_id, 'large' );
							?>
							<img src="<?php echo $src_thumb[0] ?>"
								 data-src="<?php echo $src_large[0] ?>"
								 class="w-100 blur-up lazyload"
								 width="100%" height="300"
								 alt="<?php the_title(); ?>"
								 loading="lazy" >
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php
							$src_no_img = no_image($sq = false);
							?>
							<img src="<?php echo $src_no_img ?>"
								 data-src="<?php echo $src_no_img ?>"
								 class="w-100 blur-up lazyload"
								 width="100%" height="300"
								 alt="<?php the_title(); ?>"
								 loading="lazy" >
						</a>
					<?php endif; ?>
				</div>


				<div class="col-12 col-md-6 d-flex flex-column align-items-start justify-content-center pt-3 pt-lg-0">

					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>

					<div class="single-post--content">
						<?php
						$content = get_the_content();
						$args = array(
							'maxchar'   => 350,
							'text'      => '',
							'autop'     => true,
							'save_tags' => '',
							'more_text' => 'Read more...',
						);
						echo kama_excerpt( $args );
						?>
					</div>

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
