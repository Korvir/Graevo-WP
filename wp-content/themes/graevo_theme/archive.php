<?php get_header(); ?>

<main role="main" class="archive-page">

	<div class="container mt-5">
		<div class="row">
			<div class="col-12">

				<h1 class="w-100 text-center ">
					<?php _e( 'Archives', 'html5blank' ); ?>
				</h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>
