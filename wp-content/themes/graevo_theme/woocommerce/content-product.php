<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$with_image = woocommerce_get_product_lazy_image_html( $product );

$class_list = '';
$class_list =  $with_image ? '' : 'no-image';
?>

<li <?php wc_product_class( $class_list, $product ); ?>>


	<div class="product-block  position-relative d-flex align-items-center justify-content-center bg-c_grey_dark">

		<?php
		$css_class = '';
		if ( has_post_thumbnail() ) :
			$css_class = 'padding-for-thumbnail';
			echo '<div class="product-block--image">';

			/**
			 * Hook: woocommerce_product_link_open.
			 *
			 * @hooked woocommerce_template_loop_product_link_open - 5
			 */
			do_action( 'woocommerce_product_link_open' );

			echo woocommerce_get_product_lazy_image_html( $product );

			/**
			 * Hook: woocommerce_product_link_close.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 */
			do_action( 'woocommerce_product_link_close' );

			echo '</div>';
		endif;
		?>


		<div class="product-block--content position-relative <?php echo $css_class ?> ">
			<?php
			/**
			 * Hook: woocommerce_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_product_description - 4
			 * @hooked woocommerce_template_loop_rating - 5 --removed
			 * @hooked woocommerce_template_loop_rating - 6
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );

			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5 --removed
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>

	</div>


</li>
