<?php
if ( function_exists('get_field') )
{
	$text_left  = get_sub_field('text_left');
	$text_right = get_sub_field('text_right');
}
?>



<section class="partials-delivery simple-block-text-text my-6 wysiwyg-editor">
	<div class="container-1400">
		<div class="row">

			<div class="col-12 col-md-6 px-3 px-md-6">
				<?php echo $text_left ?>
			</div>

			<div class="col-12 col-md-6 px-3 px-md-6">
				<?php echo $text_right ?>
			</div>

		</div>
	</div>
</section>


