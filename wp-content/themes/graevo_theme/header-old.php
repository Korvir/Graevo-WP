<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<!-- <link href="//www.google-analytics.com" rel="dns-prefetch"> -->
        <!-- <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon"> -->
        <!-- <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed"> -->

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<?php
		wp_head();
		global $SVG;
		?>
	</head>
	<body <?php body_class(); ?> >


	<?php
	if ( function_exists('get_field') )
	{
		$phone_number = get_field('phone_number', 'options');
	}
	?>

	<header id="header" class="header clear d-flex align-items-center justify-content-center" role="banner">
		<div class="container">
			<div class="row py-3 py-md-5 main-header">


				<div class="header-logo col-6 col-lg-4 col-xl2-2  d-flex align-items-center justify-content-start order-1 order-lg-1">
					<div class="logo d-flex">
						<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" class="d-flex">
							<svg width="174" height="67" viewBox="0 0 174 67" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M174 9.00434C174 4.01806 170.015 0 165.07 0H158.804C153.954 0 149.873 4.01806 149.873 9.00434V58.0199C149.873 63.0061 153.954 67.0242 158.804 67.0242H165.07C170.015 67.0242 174 63.0061 174 58.0199V9.00434ZM167.734 9.00434V58.0199C167.734 59.5448 166.51 60.7066 165.07 60.7066H158.804C157.387 60.7066 156.139 59.569 156.139 58.0199V9.00434C156.139 7.57623 157.363 6.31756 158.804 6.31756H165.07C166.51 6.31756 167.734 7.55202 167.734 9.00434ZM138.686 0L130.14 58.5766L121.69 0H115.232L125.387 67H134.773L145.144 0H138.686ZM111.439 6.31756V0H93.3137V67H111.343V60.6824H99.5795V33.7905H109.926V27.957H99.5795V6.31756H111.439ZM73.1962 6.22074L77.8535 41.4393H68.0828L72.7401 6.22074H73.1962ZM64.6498 67L67.4106 47.2728H78.5017L81.3584 67H87.6242L78.5977 0H67.2906L58.2641 67H64.6498ZM29.5281 0V67H35.7939V33.7905H41.5795C44.7003 33.7905 46.3328 35.3154 46.3328 38.5831V67H52.5985V38.099C52.5985 34.6618 50.798 31.7814 47.005 30.91C50.9901 28.9978 52.5985 26.2142 52.5985 22.1962V9.00434C52.5985 4.11488 48.5174 0 43.668 0H29.5281ZM35.7939 27.957V6.31756H43.668C45.0844 6.31756 46.3328 7.55202 46.3328 9.00434V21.8331C46.3328 25.8512 44.5323 27.957 40.6432 27.957H35.7939ZM15.6523 16.4595H21.918V9.00434C21.918 4.01806 17.9329 0 13.0116 0H8.93046C4.08113 0 0 4.11488 0 9.00434V58.0199C0 63.0061 3.9851 67.0242 8.93046 67.0242H13.0116C17.957 67.0242 21.9421 63.0061 21.9421 58.0199V33.8147H11.5712V39.6481H15.6523V58.0199C15.6523 59.5448 14.428 60.7066 12.9876 60.7066H8.90646C7.49007 60.7066 6.24172 59.569 6.24172 58.0199V9.00434C6.24172 7.57623 7.46606 6.31756 8.90646 6.31756H12.9876C14.5 6.31756 15.6523 7.55202 15.6523 9.00434V16.4595Z" fill="#C19400"/>
							</svg>
						</a>
					</div>
				</div>

				<div class="header-search  col-12 col-lg-5 col-xl2-4 d-flex align-items-center justify-content-center order-3 order-lg-2 mt-3 mt-lg-0">
					<div id="header-search-form" class="search-form mx-auto">
						<?php get_product_search_form(); ?>
					</div>
				</div>

				<div class="header-account col-6 col-lg-3  col-xl2-6 d-flex align-items-center justify-content-end order-2 order-lg-3">
					<nav class="icons-menu d-flex align-items-center justify-content-center">

						<div class="icons-menu--item mx-2 mx-md-3  d-flex d-lg-none align-items-center justify-content-center">
							<button type="button" class="search-button p-0 ">
								<?php echo $SVG['search_ico'] ?>
							</button>
						</div>

						<div class="icons-menu--item mx-2 mx-md-3 d-flex align-items-center justify-content-center">
							<?php
							$account_text = __('Реєстрація/Вхід', 'html5blank');
							if ( is_user_logged_in() ) $account_text = __('Особистий кабiнет', 'html5blank');
							?>

							<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
							   title="<?php _e('My Account','woocommerce'); ?>"
							   class="d-flex align-items-center justify-content-center">
								<?php echo $SVG['account'] ?>
								<span class=" ml-2 d-none d-xl2-flex"> <?php echo $account_text ?> </span>
							</a>
						</div>

						<div class="icons-menu--item mx-2 mx-md-3 d-flex align-items-center justify-content-center">
							<a href="<?php echo tel_href( $phone_number ) ?>"
							   title="<?php _e('Телефон','html5blank'); ?>"
							   class=" d-flex align-items-center justify-content-center">
								<?php echo $SVG['phone'] ?>
								<span class="d-none d-xl2-flex ml-2">  <?php echo $phone_number ?> </span>
							</a>
						</div>

						<div class="icons-menu--item mx-2 mx-md-3 d-flex align-items-center justify-content-center">
							<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
							   title="<?php _e('Кошик','html5blank'); ?>"
							   class="d-flex align-items-center justify-content-center" >
								<?php echo $SVG['cart'] ?>
								<div class="ml-2 d-none d-xl2-block">
									<p class="m-0"> <span> Товарів: </span> <span class="cart-count"> <?php echo wc()->cart->get_cart_contents_count(); ?> </span> </p>
									<p class="m-0"> <span> Cума: </span> <span class="cart-amount"> <?php echo wc()->cart->get_cart_total(); ?> </span> </p>
								</div>
							</a>
						</div>

					</nav>
				</div>


			</div>
		</div>
	</header>

	<div id="header-menu" class="header clear d-flex align-items-center justify-content-center" role="banner">
		<div class="container">
			<div class="row menu-header">
				<!-- nav -->
				<div class="nav w-100  align-items-center justify-content-between d-none d-lg-flex"
					 role="navigation">
					<?php
					theme_nav();
					?>
				</div>
				<!-- /nav -->
			</div>
		</div>
	</div>








	<div class="mobile-row bg-c_yellow_dark w-100 d-flex d-lg-none align-items-center justify-content-start " >
		<button id="toggle-mobile-menu"
				name="toggle-mobile-menu"
				class="toggle-mobile-menu mx-3 d-lg-none d-flex" type="button" >
			<i class="fas fa-bars"></i>
		</button>
	</div>

	<div class="mobile-menu">
		<div class="top-bar">

			<div class="container-fluid">
				<div class="row">
					<div class="close-row col-12 d-flex align-items-center justify-content-between">

						<button class="mobile-menu--close"
								name="mobile-menu--close"
								id="toggle-mobile-menu--close">
							<i class="fas fa-arrow-left"></i>
						</button>

					</div>
				</div>
			</div>

		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-12 p-0">
					<?php theme_nav(); ?>
				</div>
			</div>
		</div>

	</div>


