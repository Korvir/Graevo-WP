<?php
/*
 * Actions & Filters
 * */
add_filter( 'loop_shop_columns', 'loop_columns', 999 ); // Change number or products per row to 3
add_filter( 'loop_shop_per_page', 'graevo_loop_shop_per_page', 20 );
add_filter( 'woocommerce_default_catalog_orderby', 'graevo_default_catalog_orderby' );
//add_action( 'woocommerce_product_query', 'graevo_pre_get_posts_query' ); // hide bundle in loop


remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_description', 4 );


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_product_link_open', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_product_link_close', 'woocommerce_template_loop_product_link_close', 5 );

//add_action( 'woocommerce_product_query', 'exclude_bandle_cpt_pre_get_posts_query' ); // Exclude Bundle CPT on shop page

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_awards', 6);

/**
 * Exclude Bundle CPT on shop page
 * @param $q
 */
function exclude_bandle_cpt_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() || ! is_shop() ) {
		return;
	}

	$tax_query = (array) $q->get( 'tax_query' );
	$tax_query[] = array(
		'taxonomy' => 'product_cat',
		'field'    => 'slug',
		'terms'    => array( 'bandl' ),
		'operator' => 'NOT IN'
	);

	$q->set( 'tax_query', $tax_query );

}



/**
 * limit short description in loop
 **/
add_filter( 'woocommerce_short_description', 'reigel_woocommerce_short_description', 10, 1 );
function reigel_woocommerce_short_description( $post_excerpt ) {
	if ( is_product() ) {
		$post_excerpt = substr( $post_excerpt, 0, 10 );
	}
	return $post_excerpt;
}


/*
 * Functions
 * */
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 2;
	}
}


function woocommerce_get_product_lazy_image_html( $product ) {
	global $product;
	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'medium' );
	$image_full  = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'woocommerce_single' );

	if ( $image_thumb || $image_full )
	{
		ob_start();
		?>
		<img src="<?php echo $image_thumb[0] ?>"
			 data-src="<?php echo $image_full[0] ?>"
			 class="w-100 m-0 blur-up lazyload"
			 width="175" height="600"
			 alt="<?php echo $product->title ?>"
			 loading="lazy">
		<?php
		return ob_get_clean();
	}

	return false;

}


/**
 * Show the product title in the product loop. By default this is an H2.
 */
if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		echo '<a href="'.get_permalink().'" title="'.get_the_title().'">';
		echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title font-prata' ) ) . '">' . get_the_title() . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</a>';
	}
}


/**
 * Show the product description in the product loop.
 */
if ( ! function_exists( 'woocommerce_template_loop_product_description' ) ) {
	function woocommerce_template_loop_product_description() {
		echo '<p class="woocommerce-loop-product__desc">' .  get_the_excerpt() . '</p>';
	}
}


/**
 * Change number of products that are displayed per page (shop page)
 */
function graevo_loop_shop_per_page( $cols ): int {
	$cols = 8;
	return $cols;
}


/**
 * Exclude products from a particular category on the shop page
 */
function graevo_pre_get_posts_query( $q ) {
	$tax_query   = (array) $q->get( 'tax_query' );
	$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( 'nabor' ),
			'operator' => 'NOT IN'
	);
	$q->set( 'tax_query', $tax_query );
}


function graevo_default_catalog_orderby() {
	return 'date';
}


