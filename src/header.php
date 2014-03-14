<?php
/**
 * @package ttf-one
 */
?><!DOCTYPE html>
<!--[if lte IE 9]><html class="no-js IE9 IE" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="site-wrapper" class="site-wrapper">

			<header id="site-header" class="site-header" role="banner">
				<div class="sub-header">
					<div class="container">
						<span class="sub-header-content"><i class="fa fa-phone"></i> 7291-2827</span>
						<?php get_search_form(); ?>
						<ul class="sub-header-social">
							<li><i class="fa fa-twitter"></i></li>
							<li><i class="fa fa-facebook"></i></li>
							<li><i class="fa fa-google-plus"></i></li>
							<li><i class="fa fa-flickr"></i></li>
							<li><i class="fa fa-pinterest"></i></li>
							<li><i class="fa fa-instagram"></i></li>
							<li><i class="fa fa-linkedin"></i></li>
							<li><i class="fa fa-youtube"></i></li>
							<li><i class="fa fa-vimeo"></i></li>
							<li><i class="fa fa-envelope"></i></li>
							<li><i class="fa fa-rss"></i></li>
						</ul>
					</div>
				</div>
				<div class="container">
					<div class="site-branding">
						<h1 class="site-title<?php if ( ttf_one_get_logo()->has_logo() ) echo ' custom-logo'; ?>">
							<?php $hide_site_title = (int) get_theme_mod( 'hide-site-title', 0 ); ?>
							<?php if ( 1 !== $hide_site_title ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
							<?php endif; ?>
						</h1>
						<?php $hide_site_title = (int) get_theme_mod( 'hide-tagline', 0 ); ?>
						<?php if ( 1 !== $hide_site_title ) : ?>
						<span class="site-description">
							<?php bloginfo( 'description' ); ?>
						</span>
						<?php endif; ?>
					</div>

					<nav id="site-navigation" class="site-navigation" role="navigation">
						<?php $menu_label = get_theme_mod( 'navigation-mobile-label', __( 'Menu', 'ttf-one' ) );?>
						<span class="menu-toggle"><?php echo esc_html( $menu_label ); ?></span>
						<a class="skip-link screen-reader-text" href="#site-content"><?php _e( 'Skip to content', 'ttf-one' ); ?></a>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary'
						) );
						?>
					</nav>
				</div>
			</header>

			<div id="site-content" class="site-content">
				<div class="container">