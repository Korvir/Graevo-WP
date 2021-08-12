<!-- search -->
<?php
global $SVG;
?>
<form role="search" method="get" class="d-flex search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Пошук по сайту', 'label' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Пошук по сайту...', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Пошук по сайту', 'label' ) ?>" />
	</label>
	<button type="submit" class="search-submit">
		<?php echo $SVG['search_ico'] ?>
	</button>
</form>
<!-- /search -->
