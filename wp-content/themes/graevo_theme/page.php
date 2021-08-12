<?php get_header(); ?>

	<main role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

			<?php if ( is_cart() ) : ?>


				<div class="container">
					<div class="row">
						<div class="col-12 text-center">
							<h2 class="pt-5 pb-3 d-inline-block font-prata with-underline"> <?php echo the_title() ?> </h2>
						</div>
					</div>
				</div>

				<?php
				$content = get_the_content();
				if ( $content ) : ?>
					<div class="container my-3">
						<div class="row">
							<div class="col-12">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>


			<?php elseif ( is_checkout_pay_page() ) : ?>

				<?php
				$content = get_the_content();
				if ( $content ) : ?>
					<div class="container my-3">
						<div class="row">
							<div class="col-12 pay-page">
								<?php the_content(); ?>
							</div>
						</div>
					</div>

					<style>
						#form_wayforpay{
							position: absolute;
						}
					</style>
				<?php endif; ?>


			<?php else : ?>

				<?php
				$content = get_the_content();
				if ( $content ) : ?>
					<div class="container my-3">
						<div class="row">
							<div class="col-12">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php
			if (have_posts() ):
			while ( have_posts() ) : the_post() ; ?>

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

			endwhile;
			?>

			<?php else: ?>
				<h2 class="h2">
					<?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?>
				</h2>
			<?php endif; ?>


		</article>
	</main>


<?php get_footer(); ?>
