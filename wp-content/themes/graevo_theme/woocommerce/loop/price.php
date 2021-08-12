<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
if (method_exists($product, 'get_stock_status')) {
    $stock_status = $product->get_stock_status(); // For version 3.0+
} else {
    $stock_status = $product->stock_status; // Older than version 3.0
}
if($stock_status != 'outofstock'):
  if ( $price_html = $product->get_price_html() ) : ?>
	<span class="price d-block w-100 mb-4" ><?php echo $price_html; ?>  </span>
<?php
  endif;
endif; ?>
