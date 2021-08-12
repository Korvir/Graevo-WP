<?php
if ( function_exists('get_field') )
{
	$item_list = get_sub_field('item_list');
}
?>


<?php if ( $item_list ) : ?>

	<section class="partials-list my-3 wysiwyg-editor">
		<div class="container">

			<div class="row my-3">
				<div class="col-12 d-flex flex-column partials-list-question">
					<ul>
						<?php
						foreach ( $item_list as $key => $value ) :
							if ( !empty($value['list_title']) ) : ?>
								<li>
									<a href="#key-<?php echo $key ?>"
									   class="anchor mb-1"
									   title="<?php echo $value['list_title'] ?>">
										<?php echo  $value['list_title'] ?>
									</a>
								</li>
							<?php endif;
						endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="row my-3">
				<div class="col-12 partials-list-answer">
					<?php foreach ( $item_list as $key => $value ) :
						if ( !empty($value['list_content']) ) : ?>
							<div id="key-<?php echo $key ?>"
								 class="partials-list-answer--block py-3">
								<h2> <?php echo  $value['list_title'] ?> </h2>
								<?php echo $value['list_content'] ?>
							</div>
						<?php endif;
					endforeach; ?>
				</div>
			</div>

		</div>
	</section>

<?php endif; ?>
