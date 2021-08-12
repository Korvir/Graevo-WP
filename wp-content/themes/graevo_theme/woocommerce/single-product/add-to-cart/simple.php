<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>


	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>


	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="d-flex form-summary py-4">
            <div class="woocommerce-simple-price ">
                <p class="mb-0 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
            </div>

<!--                --><?php
//                echo '<div class="quantity-wrapper">';
//                do_action( 'woocommerce_before_add_to_cart_quantity' );
//                woocommerce_quantity_input(
//                    array(
//                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
//                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
//                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
//                    )
//                );
//                do_action( 'woocommerce_after_add_to_cart_quantity' );
//                echo '</div>';
//                ?>

            <?php
            $stock_amount = wc_stock_amount( $product->get_max_purchase_quantity());

            if($stock_amount != 1):
                ?>
                <div class="product_qty_custom">
                    <div class="product_qty_symbol">
                        <span class="product_qty_plus"> <i class="fas fa-plus"></i> </span>
                        <span class="product_qty_minus"> <i class="fas fa-minus"></i> </span>

                        <?php
                        woocommerce_quantity_input( array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                        ) );

                        ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="footer-button">
            <div class="d-flex">
                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button btn btn-yellow button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
				<button type="button"
						class="by-one-click-btn btn btn-white-transparent button ml-0 ml-sm-3 mt-3 mt-sm-0"
						data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
						data-toggle="modal"
						data-target="#by_one_click">
					<?php _e('Придбати в один клiк', 'html5blank' ) ?>
				</button>
            </div>
        </div>


        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>


	</form>



	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
