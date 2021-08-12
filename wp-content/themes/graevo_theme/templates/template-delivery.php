<?php
/* Template Name: Доставка  */
get_header();
?>

<main role="main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

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


		<?php
		if (have_posts() ):
			while ( have_posts() ) : the_post() ;

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
		endif;
		?>





	</article>
</main>


<?php get_footer(); ?>
