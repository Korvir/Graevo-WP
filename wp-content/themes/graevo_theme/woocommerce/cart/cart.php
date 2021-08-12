<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>


<div class="woocommerce-cart-wrapper">

	<div class="mb-3">
        <?php do_action( 'woocommerce_before_cart' ); ?>
    </div>

    <div class="here_render_cart ">
        <div class="position-relative">

			<div class="overlay_shop">
                <div class="cssload-loader">
                    <div class="cssload-inner cssload-one"></div>
                    <div class="cssload-inner cssload-two"></div>
                    <div class="cssload-inner cssload-three"></div>
                </div>
            </div>

            <div class="mb-3">
                <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

					<?php do_action( 'woocommerce_before_cart_table' ); ?>

                    <div>
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>
                    </div>

                    <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                        <div class="shop_table_head d-flex flex-wrap justify-content-start align-items-center">
                            <p class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></p>
                            <p class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></p>
                            <p class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></p>
                            <p class="product-subtotal"><?php _e( 'Сума', 'html5blank'); ?></p>
                        </div>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <div class="woocommerce-cart-form__cart-item pt-1 pb-1 pt-md-4 pb-md-4 d-flex flex-wrap justify-content-start align-items-center <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                    <!--Image-->
                                    <div class="product-thumbnail">
                                        <div class="wrap text-center pb-2">
                                            <?php

                                            $image = get_the_post_thumbnail($product_id, 'medium');

                                            $variation = wc_get_product($product_id);

                                            $parent =  $variation->parent_id;
                                            $post_type = $variation->post_type;

                                            if(empty($image) && $post_type == 'product_variation'){
                                                $image = get_the_post_thumbnail($parent, 'medium');
                                            }

                                            if ( ! $product_permalink ) {
                                                echo $image;
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $image );
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!--Product Name-->
                                    <div class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                        <h3>
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                            }
                                            else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }
                                            ?>
                                        </h3>
                                        <span class="product-remove d-inline-block">
											<?php
											echo apply_filters(
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">'.__('Delete', 'woocommerce').'</a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													esc_html__( 'Remove this item', 'woocommerce' ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
											?>
										</span>

                                    </div>

                                    <!--Quantity-->
                                    <div class="product_qty_custom">
                                        <div class="product_qty_symbol">
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                            }
                                            else {
                                                echo '<span class="product_qty_plus"> <i class="fas fa-plus"></i> </span>';
                                                echo '<span class="product_qty_minus"> <i class="fas fa-minus"></i> </span>';
                                                $product_quantity = woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => apply_filters( 'woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product ),
                                                        'min_value'    => '1',
                                                        'product_name' => $_product->get_name(),
                                                    ),
                                                    $_product,
                                                    true
                                                );
                                            }
                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Price-->
                                    <div class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
									   <span>
										 <?php  echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.?>
									   </span>
                                    </div>

                                    <!-- Subtotal-->
                                    <div class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                                        <p>
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.?>
                                        </p>
                                    </div>

                                </div>
                            <?php
                            endif;
                        endforeach;
                        ?>

                        <div>

                            <?php do_action( 'woocommerce_cart_contents' ); ?>

                            <div class="d-none">
                                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                                <?php do_action( 'woocommerce_cart_actions' ); ?>

                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </div>

                            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                        </div>
                    </div>

                    <div>
                        <?php do_action( 'woocommerce_after_cart_table' ); ?>
                    </div>

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon my-6">
							<label class="d-flex mb-1"><?php esc_html_e( 'Якщо у вас є код купона, застосуєте його нижче:', 'woocommerce' ); ?>
							</label>
							<div class="d-flex align-items-center justify-content-between flex-wrap">
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Застосуйте', 'html5blank' ); ?>" />
								<button type="submit" class="button btn btn-grey apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							</div>
							<div>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						</div>
					<?php } ?>

                </form>
            </div>

            <div>
                <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
            </div>

            <div class="cart-collaterals">
                <?php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action( 'woocommerce_cart_collaterals' );
                ?>
            </div>

            <div>
                <?php do_action( 'woocommerce_after_cart' ); ?>
            </div>

        </div>
    </div>

</div>
