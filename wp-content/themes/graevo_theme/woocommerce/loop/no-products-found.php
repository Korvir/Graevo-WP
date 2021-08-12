<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="shop_not_found_product d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-lg-6 mb-lg-6 mt-3 mb-3 text-center">
                <p class="woocommerce-info"><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
            </div>
        </div>
    </div>
</div>
