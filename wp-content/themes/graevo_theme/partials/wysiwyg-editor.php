<?php
if ( function_exists('get_field') )
{
	$wysiwyg_editor = get_sub_field('wysiwyg-editor');
}
?>



<?php if ( $wysiwyg_editor ) : ?>

	<section class="partials-content my-3 wysiwyg-editor">
		<div class="container">
			<div class="row">

				<div class="col-12 offset-lg-2 col-lg-8">
					<?php echo $wysiwyg_editor ?>
				</div>

			</div>
		</div>
	</section>

<?php endif; ?>
