<?php get_header(); ?>

<main role="main" class="archive-page">

	<div class="container  mt-5">
		<div class="row">
			<div class="col-12">

				<h1 class="w-100 text-center ">
					<?php
					$postType = get_queried_object();
					echo esc_html( $postType->labels->singular_name );
					?>
				</h1>

				<?php get_template_part('loop', 'cpt_publications'); ?>

				<?php get_template_part('pagination'); ?>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>
