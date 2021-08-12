		<?php
		if ( function_exists('get_field') )
		{
			$social_networks = get_field('social_networks', 'options');
			$jivochat_script = get_field('jivochat_script', 'options');
		}
		?>

		<!-- footer -->
		<footer class="footer py-5 bg-c_grey_dark" role="contentinfo" >
			<div class="container">
				<div class="row">

					<div class="col-12 col-md-2 mb-5 my-md-0 d-flex align-items-center justify-content-center justify-content-md-start">
						<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" class="d-flex">
							<svg width="154" height="59" viewBox="0 0 154 59" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M154 7.92919C154 3.5383 150.473 0 146.096 0H140.55C136.259 0 132.647 3.5383 132.647 7.92919V51.0921C132.647 55.483 136.259 59.0213 140.55 59.0213H146.096C150.473 59.0213 154 55.483 154 51.0921V7.92919ZM148.454 7.92919V51.0921C148.454 52.435 147.371 53.4581 146.096 53.4581H140.55C139.297 53.4581 138.192 52.4563 138.192 51.0921V7.92919C138.192 6.6716 139.276 5.56322 140.55 5.56322H146.096C147.371 5.56322 148.454 6.65029 148.454 7.92919ZM122.745 0L115.181 51.5824L107.702 0H101.987L110.974 59H119.282L128.461 0H122.745ZM98.6297 5.56322V0H82.588V59H98.5447V53.4368H88.1336V29.7558H97.2911V24.6189H88.1336V5.56322H98.6297ZM64.7828 5.47796L68.9048 36.4913H60.2572L64.3791 5.47796H64.7828ZM57.2188 59L59.6623 41.6283H69.4785L72.0069 59H77.5524L69.5635 0H59.556L51.5671 59H57.2188ZM26.1341 0V59H31.6796V29.7558H36.8002C39.5624 29.7558 41.0072 31.0986 41.0072 33.9762V59H46.5527V33.5499C46.5527 30.5231 44.9592 27.9866 41.6021 27.2193C45.1291 25.5354 46.5527 23.0842 46.5527 19.5459V7.92919C46.5527 3.62355 42.9407 0 38.6487 0H26.1341ZM31.6796 24.6189V5.56322H38.6487C39.9023 5.56322 41.0072 6.65029 41.0072 7.92919V19.2262C41.0072 22.7645 39.4136 24.6189 35.9716 24.6189H31.6796ZM13.8532 14.4942H19.3987V7.92919C19.3987 3.5383 15.8717 0 11.516 0H7.90397C3.61203 0 0 3.62355 0 7.92919V51.0921C0 55.483 3.52704 59.0213 7.90397 59.0213H11.516C15.8929 59.0213 19.42 55.483 19.42 51.0921V29.7771H10.2412V34.914H13.8532V51.0921C13.8532 52.435 12.7696 53.4581 11.4948 53.4581H7.88273C6.62914 53.4581 5.52428 52.4563 5.52428 51.0921V7.92919C5.52428 6.6716 6.60789 5.56322 7.88273 5.56322H11.4948C12.8333 5.56322 13.8532 6.65029 13.8532 7.92919V14.4942Z" fill="#C19400"/>
							</svg>
						</a>
					</div>

					<div class="col-12 col-md-10 my-1 my-md-0 d-flex flex-column flex-sm-row align-items-center justify-content-end ">
						<?php if ( $social_networks ) : ?>

							<div class="decorate-line decorate-line-prev mx-3 d-none d-sm-block"></div>

							<div class="social-networks-list d-flex flex-column flex-sm-row align-items-center justify-content-center">
								<?php foreach ( $social_networks as $s_network) : ?>
									<a href="<?php echo $s_network['url'] ?>"
                                       target="_blank"
									   class=" social-networks text-center  py-3 py-sm-0"
									   title="<?php echo $s_network['name'] ?>">
										<?php echo $s_network['name'] ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

				</div>
                <div class="row">
                    <div class="col-12 col-md-12 my-1 my-md-0 footer-menu">
                        <?php
                        footer_nav();
                        ?>
                    </div>
                </div>
			</div>



		</footer>
		<!-- /footer -->



		<?php
		if ( ! isset( $_COOKIE[ 'adult_checker'] ) ) {
			get_template_part( '/partials/modal', 'adult-check');
		}

		get_template_part( '/partials/modal', 'response' );


        if (!is_page('cart') || !is_cart()) {
            /**
             * Hook: graevo_show_cart_modal.
             *
             * @hooked graevo_show_cart_modal - 10 (show cart in modal window)
             */
            do_action('graevo_show_cart_modal');
        }


        wp_footer();
		?>

		<!--TODO: add to actions this shit-->
		<?php echo $jivochat_script ?>
		<script src="https://www.google.com/recaptcha/api.js?hl=uk" async defer></script>

		</body>
</html>
