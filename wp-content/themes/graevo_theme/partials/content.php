<?php
if ( function_exists('get_field') )
{
	$editor = get_sub_field('editor');
}
?>



<?php if ( $editor ) : ?>

	<section class="partials-content my-3 wysiwyg-editor">
		<div class="container">
			<div class="row">

				<div class="col-12 offset-lg-2 col-lg-8">
					<?php echo $editor ?>
				</div>

			</div>
		</div>
	</section>

<?php endif; ?>
