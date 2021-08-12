<?php

if ( function_exists('get_field') )
{
	$code_editor = get_sub_field('code_editor');
}
?>



<?php if ( $code_editor ) : ?>

	<section class="partials-content my-3 wysiwyg-editor">
		<div class="container">
			<div class="row">

				<div class="col-12">

					<div class="wp-geshi-highlight">
						<?php
						$geshi = new GeSHi( $code_editor, 'xml');
						echo  $geshi->parse_code();;
						?>
					</div>

				</div>

			</div>
		</div>
	</section>

<?php endif; ?>

