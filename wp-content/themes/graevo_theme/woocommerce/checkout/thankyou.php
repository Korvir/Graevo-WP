<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
?>

<div class="woocommerce-order">

	<?php if ( $order ) : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'cancelled' ) ) : ?>

			<div class="woocommerce-order--failed my-6 d-flex flex-column align-items-center justify-content-center">

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<div class="mt-6">
							<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
						</div>
					<?php endif; ?>
				</p>

			</div>

			<?php elseif ( $order->has_status( 'failed' ) ) : ?>

				<div class="woocommerce-order--failed my-6 d-flex flex-column align-items-center justify-content-center">

					<div class="success-ico mt-6 mb-6">
						<svg width="84" height="83" viewBox="0 0 84 83" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M38.8024 2.89097L24.5448 26.7555H59.4552L45.192 2.89097L50.008 0L65.9848 26.7555H80.0632C82.236 26.7555 84 28.5272 84 30.7095V33.1786C84.0001 49.7356 80.1617 66.0652 72.7888 80.874C72.4705 81.5131 71.9813 82.0505 71.3759 82.426C70.7706 82.8015 70.0731 83.0003 69.3616 83H14.6384C13.9265 82.9991 13.2288 82.7992 12.6235 82.4228C12.0183 82.0463 11.5292 81.5081 11.2112 80.8683C3.83828 66.0596 -0.000131442 49.73 3.37584e-09 33.173L3.37585e-09 30.7095C3.37585e-09 28.5272 1.764 26.7555 3.9368 26.7555H18.0152L33.992 0L38.7968 2.89097H38.8024Z" fill="#D4AF37"/>
						</svg>
					</div>

					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed text-center">
						<?php esc_html_e( 'Здається ви скасували оплату.' ); ?>
						<br>
						<?php esc_html_e( 'Якщо передумали - можете сплатити зараз =)' ); ?>
					</p>

					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
						<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
						<?php if ( is_user_logged_in() ) : ?>
							<div class="mt-6">
								<p> <?php esc_html_e( 'Також ми зберегли ваш замовлення і Ви завжди можете до нього повернутися в особистому кабінеті' ); ?> </p>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
							</div>
						<?php endif; ?>
					</p>

				</div>

		<?php else : ?>

			<div class="woocommerce-order--success my-6 d-flex flex-column align-items-center justify-content-center">

				<div class="success-ico mt-6">
					<svg width="112" height="85" viewBox="0 0 112 85" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M35.6364 67.2388L8.90909 40.597L0 49.4776L35.6364 85L112 8.8806L103.091 0L35.6364 67.2388Z" fill="url(#paint0_linear)"/>
						<defs>
							<linearGradient id="paint0_linear" x1="56" y1="0" x2="56" y2="85" gradientUnits="userSpaceOnUse">
								<stop stop-color="#D4AF37"/>
								<stop offset="1" stop-color="#FFCC33"/>
							</linearGradient>
						</defs>
					</svg>
				</div>

				<div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received text-center my-6">
					<h3 class="font-prata"> <?php _e('Дякую!', 'html5blank'); ?> </h3>
					<h3 class="font-prata"> <?php _e('Ваше замовлення успішно оформлене!', 'html5blank'); ?> </h3>
				</div>

				<div class="line-separator mb-6"></div>

				<p class="text-center"> <?php _e('Наш кур’єр зв’яжеться з Вами у найближчий час', 'html5blank'); ?> </p>

				<a class="btn btn-white d-flex align-items-center justify-content-center my-6 font-weight-bold"
				   href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
				   title="<?php esc_html_e( 'До магазину', 'woocommerce' ); ?>">
					<?php esc_html_e( 'До магазину', 'woocommerce' ); ?>
				</a>



			</div>

		<?php endif; ?>


	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
