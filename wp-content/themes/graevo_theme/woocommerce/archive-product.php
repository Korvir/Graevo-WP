<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
global $SVG;
?>

<div class="position-relative overflow-hidden">
    <div>
        <?php
        /**
         * Hook: woocommerce_before_main_content.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         * @hooked WC_Structured_Data::generate_website_data() - 30
         */
        do_action( 'woocommerce_before_main_content' );
        ?>
    </div>
    <div class="decor decor--grapes">
        <?= $SVG['decor_grapes']?>
    </div>
    <div class="decor decor--burrel">
        <?= $SVG['decor_burrel']?>
    </div>

    <!--content-->
    <div class="woocommerce-shop-menu-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 woocommerce-shop-menu d-flex">
                    <div class="shop_nav w-100">
                        <?php shop_nav(); ?>
                    </div>
<!--                    <div class="ordering ordering--right">-->
                        <?php
                        /**
                         *  woocommerce_catalog_ordering
                         */
                        //woocommerce_catalog_ordering();
                        ?>
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <div>
        <?php

        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20 -- removed
         * @hooked woocommerce_catalog_ordering - 30 -- removed
         */
        do_action( 'woocommerce_before_shop_loop' );
        ?>
    </div>

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="woocommerce-products-header">
                        <?php
                        /**
                         * Hook: woocommerce_archive_description.
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action( 'woocommerce_archive_description' );
                        ?>
                    </div>
                    <?php
                    if ( woocommerce_product_loop() ) {
                    ?>
						<div class="loop_products_list_wrap">
							<?php
							woocommerce_product_loop_start();

							if ( wc_get_loop_prop( 'total' ) ) {
								while ( have_posts() ) {
									the_post();

									/**
									 * Hook: woocommerce_shop_loop.
									 */
									do_action( 'woocommerce_shop_loop' );

									wc_get_template_part( 'content', 'product' );
								}
							}

							woocommerce_product_loop_end();

							/**
							 * Hook: woocommerce_after_shop_loop.
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							do_action( 'woocommerce_after_shop_loop' );
							} else {
								/**
								 * Hook: woocommerce_no_products_found.
								 *
								 * @hooked wc_no_products_found - 10
								 */
								do_action( 'woocommerce_no_products_found' );
							}
							?>
						</div>
                    <?php

                    /**
                     * Hook: woocommerce_after_main_content.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action( 'woocommerce_after_main_content' );

                    /**
                     * Hook: woocommerce_sidebar.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */
                    do_action( 'woocommerce_sidebar' );
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>


<?php get_footer( 'shop' ); ?>

