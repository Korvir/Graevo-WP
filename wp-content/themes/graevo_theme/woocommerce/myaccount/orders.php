<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<section class="w-100 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

		<?php
		foreach ( $customer_orders->orders as $customer_order ) {
			$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$item_count = $order->get_item_count() - $order->get_item_count_refunded();
			?>
			<div class="d-flex flex-wrap align-items-center justify-content-center p-2 pb-3 mb-4 woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order order-line">

				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :

					switch ( $column_id ) {
						case 'order-number':
							$css_justify = 'justify-content-start';
							break;
						case 'order-date':
							$css_justify = 'justify-content-end justify-content-md-start';
							break;
						case 'order-status':
							$css_justify = 'justify-content-end justify-content-lg-center';
							break;
						default:
							$css_justify = 'justify-content-start';
							break;
					}

					?>
					<div class="px-2 py-3 d-flex align-items-center <?php echo $css_justify ?> woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>"
						 data-title="<?php echo esc_attr( $column_name ); ?>">
						<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
							<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

						<?php elseif ( 'order-number' === $column_id ) : ?>
							<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
								<?php echo esc_html( _x( '№ ', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
							</a>

						<?php elseif ( 'order-date' === $column_id ) : ?>
							<time class="text-c_yellow_dark" datetime="<?php echo esc_attr( $order->get_date_created()->date( 'd F Y , H:m' ) ); ?>">
								<?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'd F Y' ) ); ?>
							</time>

						<?php elseif ( 'order-total' === $column_id ) : ?>
							<span class="text-c_yellow_dark ">
								<?php
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
								?>
							</span>

						<?php elseif ( 'order-status' === $column_id ) : ?>
							<?php echo woocommerce_render_order_status_name( $order ) ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>

				<div class="w-100 woocommerce-order-details woocommerce-orders-table__row ">

					<!-- wrapper-->
					<div class="w-100 d-flex align-items-center justify-content-center pt-2 pb-0 pb-lg-5 mt-3 mt-md-5" >
						<section class="w-75 d-flex flex-column woocommerce-order-details--items">

							<div class="woocommerce-order-details--items-single mb-6 pb-3 w-100 text-c_yellow_dark d-flex d-md-none flex-column align-items-start justify-content-center">
								<small><?php _e('Статус замовлення:'); ?></small>
								<h3>
									<?php echo woocommerce_render_order_status_name( $order, false ) ?>
								</h3>
							</div>

							<?php
							$shipping_method = $order->get_shipping_method();
							$shipping_total = $order->get_shipping_total();
							$order_total = $order->get_total();

							foreach ( $order->get_items() as $item_key => $item_values ) :
								$item_data = $item_values->get_data();
								$thumb_id = get_post_thumbnail_id( $item_data['product_id'] );
								$image_thumb = wp_get_attachment_image_src( $thumb_id, 'woocommerce_thumbnail' );
								$image_small = wp_get_attachment_image_src( $thumb_id, 'small' );

								$product_name = $item_data['name'];
								$quantity     = $item_data['quantity'];
								$line_total   = $item_data['total'];
								$product_url  = get_permalink( $item_data['product_id'] );
								?>


								<!-- Order Line items-->
								<div class="woocommerce-order-details--items-single mb-6 pb-5 w-100 d-flex align-items-center justify-content-start">

									<a href="<?php echo $product_url ?>"
									   title="<?php echo $item_data['name'] ?>">
										<div class="item-image-square ">
											<?php if ( $image_thumb ) : ?>
												<img src="<?php echo $image_thumb[0] ?>"
													 data-src="<?php echo $image_small[0] ?>"
													 class="blur-up lazyload"
													 width="50px" height="200px"
													 alt="<?php echo $item_data['name'] ?>"
													 title="<?php echo $item_data['name'] ?>"
													 loading="lazy">
											<?php endif; ?>
										</div>
									</a>

									<div class="item-details pl-3 pl-md-5 d-flex flex-column align-items-start justify-content-center text-c_yellow_dark">
										<a href="<?php echo $product_url ?>"
										   title="<?php echo $item_data['name'] ?>">
											<h5 class="w-100 pr-3 mb-3"> <?php echo $product_name ?> </h5>
										</a>
										<p class="w-100 pr-3 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
											<span><?php _e('Кількість:') ?> <?php echo $quantity ?></span>
											<span><?php echo wc_price( $line_total ) ?></span>
										</p>
									</div>

								</div>
								<!-- -->

							<?php endforeach; ?>

							<!-- Shipping method and Totals-->
							<div class="woocommerce-order-details--items-single shipping-totals mb-3 pb-5 w-100 d-flex flex-column  align-items-start justify-content-center text-c_yellow_dark">

								<?php if ( $shipping_method ) : ?>
								<div class="shipping w-100 pl-0 pl-lg-5 pr-3 d-flex flex-column align-items-start justify-content-center ">
									<h4 class="w-100"> <?php _e('Доставка:') ?> </h4>
									<p class="w-100 d-flex align-items-center justify-content-between">
										<span class="pr-3"> <?php echo $shipping_method ?> </span>
										<span> <?php echo wc_price( $shipping_total ) ?> </span>
									</p>
								</div>
								<?php endif; ?>

								<?php if ( $order_total ) : ?>
								<div class="totals w-100 pl-0 pl-lg-5 pr-3 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
									<h4><?php _e('Разом до оплати:') ?> </h4>
									<h3 class="m-0"> <?php echo wc_price( $order_total ) ?></h3>
								</div>
								<?php endif; ?>


							</div>
							<!---->

							<div class="woocommerce-order-details--buttons d-flex d-lg-none flex-column align-items-center justify-content-center ">
								<?php woocommerce_render_order_again_button( $order, 1); ?>
								<?php echo woocommerce_render_order_payment_button( $order ); ?>
								<?php echo woocommerce_render_order_cancel_button( $order ) ?>
							</div>



						</section>

						<section class="woocommerce-order-details--status w-25 d-none d-lg-flex flex-column align-items-center justify-content-center">
							<?php echo woocommerce_render_order_status_name( $order, true ) ?>
							<?php woocommerce_render_order_again_button( $order, 1); ?>
							<?php echo woocommerce_render_order_payment_button( $order ); ?>
							<?php echo woocommerce_render_order_cancel_button( $order ) ?>
						</section>
					</div>
					<!-- -->


				</div>

			</div>
			<?php
		}
		?>

	</section>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button"
				   href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button"
				   href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="d-flex flex-column align-items-center justify-content-center text-center">

		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>

		<a class="woocommerce-Button btn btn-white d-flex align-items-center justify-content-center my-6"
		   href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>

	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
