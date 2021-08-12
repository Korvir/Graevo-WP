<?php
/* Template Name: Акціі  */
get_header();

if ( function_exists( 'get_fields' ) ) {
	$stroke_fields = get_fields();
}
?>


<main role="main" class="template-stroke">


	<?php if ( $stroke_fields['banner_image'] ) : ?>
	<section class="banner-with-text ">
		<div class="banner-with-text-wrapper w-100 position-relative d-flex align-items-center justify-content-start">

			<div class="container">
				<div class="row">
					<div class="col-12">
						<h1 class="font-prata text-c_yellow_light text-center text-md-left position-relative">
							<?php echo $stroke_fields['banner_title'] ?>
						</h1>
					</div>
				</div>
			</div>

			<div class="img-gradient"></div>
			<img src="<?php echo $stroke_fields['banner_image']['sizes']['medium'] ?>"
			     data-src="<?php echo $stroke_fields['banner_image']['url'] ?>"
			     class="w-100 blur-up lazyload"
			     width="100%"
			     alt="<?php echo $stroke_fields['banner_image']['alt'] ?>"
			     loading="lazy">

		</div>
	</section>
	<?php endif; ?>


	<?php if ( $stroke_fields['stroke_list'] ) : ?>
	<section class="stroke-list woocommerce">
		<div class="container">

			<?php foreach ( $stroke_fields['stroke_list'] as $single_stroke ) : ?>
				<div class="row my-5 stroke-list--single">


					<?php if ( $single_stroke['stroke_title'] ) : ?>
						<div class="stroke-list--single-title col-12 text-center">
                            <div class="py-5 px-md-4 px-md-6 d-inline-block with-underline">
                                <h3 class="font-prata"> <?php echo $single_stroke['stroke_title'] ?> </h3>
                                <?php if ( $single_stroke['date'] ) : ?>
                                    <span class="stroke-list--single-date"><?php echo $single_stroke['date']; ?></span>
                                <?php endif; ?>
                            </div>
						</div>
					<?php endif; ?>



					<?php if ( $single_stroke['stroke_description'] ) : ?>
						<div class="pt-5 px-md-4 px-md-6 partials-slider--desc col-12 text-center">
							<?php echo $single_stroke['stroke_description'] ?>
						</div>
					<?php endif; ?>


					<?php if ( $single_stroke['stroke_products'] ) : ?>
                    <div class="stoke-product-slider">
                        <div class="owl-carousel">
                            <?php
                            $products_slider = $single_stroke['stroke_products'];
                            foreach ( $products_slider as $gallery_item ) {

                                $wc_product = wc_get_product( $gallery_item );

                                $thumb_id = get_post_thumbnail_id( $gallery_item );
                                $image_thumb = wp_get_attachment_image_src( $thumb_id, 'large' );
                                $image_small = wp_get_attachment_image_src( $thumb_id, 'large' );

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
                                <div class="product-block d-flex flex-md-column position-relative <?php echo $stock_status; ?> bg-c_grey_dark">
                                    <?php if(!empty($image_thumb)): ?>
                                      <div class="product-block--image">
                                        <a href="<?php echo $product_url ?>" class="carousel-cell--content-image mb-3" title="<?php echo $product_name ?>">
                                            <img src="<?php echo $image_thumb[0] ?>"
                                                 data-src="<?php echo $image_small[0] ?>"
                                                 class="px-6 mb-3 mb-lg-0 blur-up lazyload carousel-cell--image"
                                                 alt="<?php echo $product_name ?>"
                                                 loading="lazy">
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <div class="product-block--content position-relative <?= (!empty($image_thumb))? 'padding-for-thumbnail': '' ?>  ">
                                        <a href="<?php echo $product_url ?>" class="product-title-link mb-3" title="<?php echo $product_name ?>">
                                            <h2 class="product-title font-prata"> <?php echo $product_name ?> </h2>
                                        </a>
                                        <p class="product--desc"> <?php echo $product_desc ?> </p>
                                        <?php woocommerce_template_loop_awards( $wc_product->get_id() ) ?>
                                        <?php if($stock_status != 'outofstock'): ?>
                                            <span class="price d-block w-100 mb-4"><?php echo $wc_product->get_price_html(); ?></span>
                                            <?php if( $wc_product->is_type( 'simple' ) ) : ?>
                                                <div class="btn-row w-100">
                                                    <a href="<?php echo wc_get_cart_url() ?>?add-to-cart=<?php echo $wc_product->get_id()?>" data-quantity="1" class="btn btn-yellow button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $wc_product->get_id()?>"  aria-label="Додайте “Цитронний Магарича / Сапераві Сандотрен / Рожеве напівсолодке” до кошика" rel="nofollow">
                                                        <?php echo esc_html( $wc_product->single_add_to_cart_text() ); ?> <i class="fas fa-spinner ml-2"></i> <i class="fas fa-check ml-2"></i>
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
			<?php endforeach; ?>

		</div>
	</section>
	<?php endif; ?>


	<?php
	if (have_posts() ):
		while ( have_posts() ) : the_post() ; ?>

			<?php
			if ( have_rows('page-partials' )  ) {
				while( have_rows('page-partials') )
				{
					the_row();
					$layout = get_row_layout();
					$inclusion = get_stylesheet_directory() . DIRECTORY_SEPARATOR . "partials" . DIRECTORY_SEPARATOR ."{$layout}.php";

					if( file_exists( $inclusion ) )
					{
						include( $inclusion );
					}

				}
			}

		endwhile;
	endif;
	?>

</main>




<?php get_footer(); ?>
