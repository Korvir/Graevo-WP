<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

global $product, $SVG;
if ( function_exists( 'get_fields' ) ) {
	$product_fields = get_fields();
}


if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.

	return;
}
$bundle_meta = $product_fields['set_bundle_product'];
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<div class="position-relative">
		<div class="container-1300">
			<div class="row">
				<div class="col-12 text-center ">
					<?php
					/**
					 * Hook: woocommerce_before_single_product.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 */
					do_action( 'woocommerce_before_single_product' );
					?>
				</div>
				<div class="col-12">
					<?php
					$class_info = '';
					$has_bundle = '';
					if ( has_post_thumbnail() ) {
						$class_info = 'has_image_thumbnail';
					}
                    if(empty($bundle_meta)){
                        $not_has_bundle = ' not_has_bundle';
                    }
					?>
					<div class="d-flex wrap-information-product <?= $class_info,  $not_has_bundle; ?>">
						<?php
						/**
						 * Hook: woocommerce_before_single_product_summary.
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action( 'woocommerce_before_single_product_summary' );
						?>

						<div class="summary entry-summary   mt-3 mb-3  mt-lg-6 mb-lg-6">
							<div class="summary-info">
								<?php
								/**
								 * Hook: woocommerce_single_product_summary.
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_loop_awards - 25
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 * @hooked WC_Structured_Data::generate_product_data() - 60
								 */
								do_action( 'woocommerce_single_product_summary' );
								?>
							</div>

							<?php
							if ( ! empty( $bundle_meta ) ):
								?>
								<div class="bundles-wrap mt-6 mt-lg-3">
									<?php
									$bundle_post_id  = $product_fields['set_bundle_product'];
									$bundle_products = get_field( 'tovar', $bundle_post_id );
									?>
									<?php if ( ! empty( $bundle_products ) and isset( $bundle_products ) ): ?>

										<ul class="bundles-list">
											<?php
											$full_cost_del  = 0;
											$full_cost_inst = 0;
											$full_price     = 0;

											$bundle_type      = get_field( 'typ_dyskonta', $bundle_post_id );
											$bundle_val       = get_field( 'znachennya', $bundle_post_id );
											$bundle_product   = wc_get_product( $bundle_post_id );


											foreach ( $bundle_products as $item )
											{
												$product_item = wc_get_product( $item->ID );

												if ( !empty( $product_item->get_sale_price() ) ) {
													$b_product_price = $product_item->get_sale_price();
												} else {
													$b_product_price = $product_item->get_regular_price();
												}
												$full_price         += $full_cost_del + (float) $b_product_price;

												//render only in stock
												if ( $product_item->get_stock_quantity() != '0' ) :
													$image = get_the_post_thumbnail( $item->ID, 'large' );

													$variation = wc_get_product( $item->ID );
													$parent    = $variation->parent_id;
													$post_type = $variation->post_type;

													if ( empty( $image ) && $post_type == 'product_variation' ) {
														$image = get_the_post_thumbnail( $parent, 'large' );
													}
													?>
														<li class="product-item text-center">

															<div class="box-image">
																<a href="<?= get_post_permalink( $item->ID ); ?>"
																   title="<?= $product_item->get_name() ?>"
																   target="_blank">
																	<?php echo $image; ?>
																</a>
															</div>
																<p> <?= $product_item->get_name() ?> </p>

														</li>
													<?php
												endif;

											}

											// Сalculation
											if ( $bundle_type == 'percent' ) {
												$sale_percent   = (float) $full_price * (float) $bundle_val / 100;
												$item_sale      = (float) $full_price - $sale_percent;
											}
											else {
												$item_sale      = $full_price - (float) $bundle_val;
											}
											$full_cost_inst = $full_cost_inst + $item_sale;

											$saving = (float) $full_price - (float) $full_cost_inst;
											?>
										</ul>

										<div class="bundles-footer mt-1 mt-lg-4">
											<p class="bundles_full_price">
												<?php _e( 'Повна вартість', 'html5blank' ) ?>
												<del>
                                                 <span class="woocommerce-Price-amount amount">
                                                   <bdi> <?= wc_price( $full_price ); ?> </bdi>
                                                  </span>
												</del>
												<ins>
													<span class="woocommerce-Price-amount amount"><bdi> <?= wc_price( $full_cost_inst ); ?> </bdi></span>
												</ins>
											</p>

											<?php if ( ! empty( $bundle_product->get_sale_price() ) ): ?>
												<p class="economy"><?php _e( 'Економія', 'html5blank' ) ?> <?= wc_price( $saving ); ?></p>
											<?php endif; ?>
										</div>

										<?php $price_bundle = (float) $full_cost_inst; ?>
										<input type="hidden" id="price_bundle" data-price="<?= $price_bundle; ?>"
											   data-id="<?= $bundle_post_id; ?>">
										<a href="/cart/?add-to-cart=<?= $bundle_post_id; ?>"
										   class="by-now-bundles mt-3 btn btn-white-transparent button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a>
									<?php endif; ?>
								</div>
							<?php endif;
							?>

						</div>
					</div>
				</div>
			</div>

			<div class="decor decor--grapes">
				<?= $SVG['decor_grapes'] ?>
			</div>

			<div class="decor decor--wineglass">
				<?= $SVG['decor_wineglass'] ?>
			</div>

		</div>
	</div>

	<div class="product_information with_border_top">
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>

	</div>

	<div class="recently_viewed_products with_border_top position-relative">
		<div class="decor decor--burrel">
			<?= $SVG['decor_burrel'] ?>
		</div>
		<div class="container">
			<div class="col-12">
				<h2><?php _e( 'Переглянутi товари:', 'html5blank' ) ?></h2>
				<div>
					<?php
					echo do_shortcode( "[woocommerce_recently_viewed_products per_page='2']" );
					?>
				</div>
			</div>
		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php
get_template_part( '/partials/modal', 'by-one-click');
?>
