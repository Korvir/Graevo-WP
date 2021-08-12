<?php get_header(); ?>

	<main role="main">

		<div class="container my-5">
			<div class="row">
				<div class="col-12">

					<?php if (have_posts() ): while ( have_posts() ) : the_post() ; ?>

						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<!-- post thumbnail -->
							<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
								<?php the_post_thumbnail(); // Fullsize image for the single post ?>
							<?php endif; ?>
							<!-- /post thumbnail -->

							<!-- post title -->
							<h1 class="my-5 post-title">
								<?php the_title(); ?>
							</h1>
							<!-- /post title -->

							<?php the_content(); // Dynamic Content ?>

						</article>
						<!-- /article -->

						<?php
						if ( have_rows('page-partials' )  ) {
							while( have_rows('page-partials') )
							{
								the_row();
								$layout = get_row_layout();
								$inclusion = get_template_directory() . DIRECTORY_SEPARATOR . "partials" . DIRECTORY_SEPARATOR ."{$layout}.php";

								if( file_exists( $inclusion ) )
								{
									include( $inclusion );
								}

							}
						}
						?>

						<?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

					<?php endwhile; ?>

					<?php else: ?>
						<h2 class="h2">
							<?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?>
						</h2>
					<?php endif; ?>

				</div>
			</div>
		</div>

	</main>

<?php get_footer(); ?>
