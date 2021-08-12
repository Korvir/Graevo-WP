<?php
$products_slider = get_sub_field( 'products_slider' );
?>

<section class="partials-products-slider my-3">
	<div class="container">
		<div class="row">

			<?php if ( $products_slider ) : ?>
				<div class="my-5 partials-products-slider--gallery col-12">
					<div class="products-flicktify-init main-carousel">
						<?php
						foreach ( $products_slider as $gallery_item ) {

							$wc_product = wc_get_product( $gallery_item );

							$thumb_id = get_post_thumbnail_id( $gallery_item );
							$image_thumb = wp_get_attachment_image_src( $thumb_id, 'woocommerce_thumbnail' );
							$image_small = wp_get_attachment_image_src( $thumb_id, 'small' );

							$product_name = $wc_product->get_name();
							$product_desc = $wc_product->get_short_description();
							$product_url  = get_permalink( $gallery_item );
							$product_cat  = wp_get_post_terms( $wc_product->get_id(), 'product_cat' );
                            if (method_exists($wc_product, 'get_stock_status')) {
                                $stock_status = $wc_product->get_stock_status();
                            } else {
                                $stock_status = $wc_product->stock_status;
                            }
							?>

							<div class="carousel-cell  d-flex flex-column flex-lg-row align-items-center justify-content-center <?php echo $stock_status; ?>">

								<a href="<?php echo $product_url ?>" class="carousel-cell--content-url mb-3" title="<?php echo $product_name ?>">
									<img src="<?php echo $image_thumb[0] ?>"
										 data-src="<?php echo $image_small[0] ?>"
										 class="px-6 mb-3 mb-lg-0 blur-up lazyload carousel-cell--image"
										 alt="<?php echo $product_name ?>"
										 loading="lazy">
								</a>

								<div class="carousel-cell--content d-flex flex-column flex-column align-items-ccenter align-items-lg-start justify-content-center justify-content-lg-start pl-0 pl-lg-3">

									<a href="<?php echo $product_url ?>" class="carousel-cell--content-url mb-3" title="<?php echo $product_name ?>">
										<h2 class="carousel-cell--content-title w-100 font-prata mb-1 text-center text-lg-left"> <?php echo $product_name ?> </h2>
									</a>

									<p class="carousel-cell--content-cat text-left mb-4 w-100 text-center text-lg-left"> <?php echo $product_cat[0]->name ?> </p>

									<p class="carousel-cell--content-desc text-left mb-4"> <?php echo $product_desc ?> </p>

									<?php woocommerce_template_loop_awards( $wc_product->get_id() ) ?>

									<a href="<?php echo $product_url ?>" class="carousel-cell--content-url mb-3" title="<?php echo $product_name ?>">
										<?php _e('Детальніше', 'html5blank') ?>
									</a>
                                    <?php if($stock_status != 'outofstock'): ?>
									<p class="carousel-cell--content-price w-100 text-center text-lg-left mb-5 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
										<?php echo $wc_product->get_price_html(); ?>
									</p>

									<?php if( $wc_product->is_type( 'simple' ) ) : ?>
									<div class="btn-row w-100 d-flex align-items-center  justify-content-center justify-content-lg-start">
										<a href="<?php echo wc_get_cart_url() ?>?add-to-cart=<?php echo $wc_product->get_id()?>&is_show_notice=false" class="btn btn-yellow  d-flex align-items-center justify-content-center">
											<?php echo esc_html( $wc_product->single_add_to_cart_text() ); ?>
										</a>
									</div>
									<?php endif; ?>
                                    <?php else:?>
                                        <span style="color: #F14336;">Немає в наявності</span>
                                    <?php endif; ?>
								</div>

							</div>
							<?php
						}
						?>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
