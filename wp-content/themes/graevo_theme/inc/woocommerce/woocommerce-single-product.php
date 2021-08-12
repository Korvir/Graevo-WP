<?php

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

//reorder
remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );


add_action( 'woocommerce_single_product_summary', 'graevo_add_content', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_awards', 25);


remove_action('template_redirect', 'wc_track_product_view', 20);
add_action( 'template_redirect', 'graevo_track_product_view_always', 20 );
add_shortcode("woocommerce_recently_viewed_products", "graevo_recently_viewed_products");
add_filter( 'woocommerce_output_related_products_args', 'graevo_related_products_args', 20 );
add_filter( 'woocommerce_upsell_display_args', 'graevo_upsell_display_args', 20 );

add_filter( 'woocommerce_product_tabs', 'graevo_remove_product_tabs_review', 98 );

function graevo_add_content(){
    echo '<div class="product-description">';
    echo the_content();
    echo '</div>';
}

function graevo_remove_product_tabs_review( $tabs ) {
	unset( $tabs['description'] );
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );
	return $tabs;
}

/**
 * Change number of related products output
 */
function graevo_upsell_display_args( $args ) {
    $args['columns'] = 2;
    $args['posts_per_page'] = 2;
    return $args;
}


function graevo_related_products_args( $args ) {
    $args['posts_per_page'] = 2;
    $args['columns'] = 2;
    return $args;
}


/**
 * Track product views. Always.
 */
function graevo_track_product_view_always() {
    if ( ! is_singular( 'product' ) /* remove this condition to run: || ! is_active_widget( false, false, 'woocommerce_recently_viewed_products', true )*/ ) {
        return;
    }

    global $post;

    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );
    }

    // Unset if already in viewed products list.
    $keys = array_flip( $viewed_products );

    if ( isset( $keys[ $post->ID ] ) ) {
        unset( $viewed_products[ $keys[ $post->ID ] ] );
    }

    $viewed_products[] = $post->ID;

    if ( count( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }

    // Store for session only.
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}


/**
 * Recently viewed Products
 *
 * @param $atts
 * @param null $content
 *
 * @return string|void
 */
function graevo_recently_viewed_products( $atts, $content = null ) {

    global $woocommerce;

    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
    $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

    extract(shortcode_atts(array(
        "per_page" => '5'
    ), $atts));

	if ( empty( $viewed_products ) )
        return _e( 'Ви ще не переглянули жодного товару!', 'html5blank' );


    ob_start();
    if( !isset( $per_page ) ? $number = 5 : $number = $per_page )

        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'post__in'       => $viewed_products,
            'orderby'        => 'rand'
        );


    $query_args['meta_query'] = array();

    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

    $r = new WP_Query($query_args);

    if ( $r->have_posts() ) {

        $content = '<ul class=" products columns-2  recently_viewed_products">';

        while ( $r->have_posts()) {
            $r->the_post();
            global $product;
            $css_class = '<div class="product-block--content position-relative">';
            if(has_post_thumbnail()){
                $css_class = '<div class="product-block--content position-relative padding-for-thumbnail">';
            }
            $args = array(
                'maxchar'   => 150,
                'text'      => '',
                'autop'     => true,
                'save_tags' => '',
                'more_text' => 'Read more...',
            );
            $link = apply_filters(
                'woocommerce_loop_add_to_cart_link',
                sprintf(
                    '<a href="%s" data-quantity="%s" class="%s btn btn-yellow  add_to_cart_button ajax_add_to_cart" %s>%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                    esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                    isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                    esc_html( $product->add_to_cart_text() )
                ),
                $product,
                $args
            );
            if (method_exists($product, 'get_stock_status')) {
                $stock_status = $product->get_stock_status();
            } else {
                $stock_status = $product->stock_status;
            }
            $content .= '<li  class="product ' . $stock_status . '" >';
            $content.= '<div class="product-block  position-relative d-flex align-items-center justify-content-center bg-c_grey_dark">';
            $content .= '<div class="product-block--image">';
            $content .= '
                        <a href="' . get_permalink() . '" title="' .get_the_title() .'">
                            ' . ( has_post_thumbnail() ? get_the_post_thumbnail( $r->post->ID, 'large' ) : '' ) .  '
                        </a> ';
            $content .= '</div>';

            $content .= $css_class;

	        $content .= '<a href="'.get_permalink().'" title="'.get_the_title().'">';
	        $content .= '<h2 class="woocommerce-loop-product__title font-prata">' . get_the_title() . '</h2> ';
	        $content .= '</a>';

	        $content .= '<div class="woocommerce-loop-product__desc">';
            $content .=  kama_excerpt( $args );
            $content .= '</div>';

            if($stock_status != 'outofstock'):

            $content .= '<span class="price d-block w-100 mb-4">';
            $content .=  $product->get_price_html();
            $content .= '</span>';
            $content .= $link;
            else:
                $content .= '<span style="color: #F14336;">Немає в наявності</span>';
            endif;

            $content .= '</div>';
            $content .= '</li>';
        }
        $content .= '</div>';
        $content .= '</ul>';

    }

    $content .= ob_get_clean();


    return $content;
}


function woocommerce_template_loop_awards( $product_id = false )
{
	global $product;
	if ( $product_id ){
		$product = wc_get_product( $product_id );
	}
	$attributes = $product->get_attributes();
	$awards_desc = get_field('reward_description',$product->get_id());

	// Get avaliable attributes in array
	if ( $attributes )
	{

		$swatch_arr = [];
		foreach ( $attributes as $attribute )
		{

			if ( $attribute->is_taxonomy() )
			{
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all'  ) );

				foreach ( $attribute_values as $attribute_value )
				{
					$value_name  = esc_html( $attribute_value->name );
					$value_meta  = get_term_meta( $attribute_value->term_id, 'swatch_image', true );
					if ( ! empty($value_meta) )
					{
						$image_params = wp_get_attachment_image_src( $value_meta, 'thumbnail', false );
						array_push( $image_params, $value_name );
						array_push( $swatch_arr, $image_params  );
					}

				}

			}

		}

	}


	// Display attribute swatches
	if ( is_array($swatch_arr) && ! empty($swatch_arr) )
	{

		echo '<div class="product-awards  p-0 my-4">';

		echo '<h5 class="w-100 font-prata mb-3">' . __('Нагороди', 'html5blank') . '</h5>';

		echo '<div class="d-flex">';

		foreach ( $swatch_arr as $swatch )
        {
			?>
                <div class="mr-3 mb-3 awards-item">
                    <?php
                     if(!empty($awards_desc)) {
                        foreach ($awards_desc as $value){
                            if($swatch[4] == $value['nagoroda']->name){
                                ?>
                                <div class="awards-desc">
                                    <?php echo $value['harakterystyka']; ?>
                                </div>
                                <?php
                            }

                        }
                     }
                     ?>
                    <img src="<?= $swatch[0] ?>"
                         data-src="<?= $swatch[0] ?>"
                         class="blur-up lazyload"
                         width="75" height="75"
                         alt="<?= $swatch[4] ?>"
                         loading="lazy">

                </div>

			<?php
        }

		echo '</div>';

		echo '</div>';

	}


}
