<?php
/**
 * @package ttf-start
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
				<div class="site-branding">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<h2 class="site-description">
						<?php bloginfo( 'description' ); ?>
					</h2>
				</div>

				<nav id="site-navigation" class="site-navigation" role="navigation">
					<span class="menu-toggle"><?php _e( 'Menu', 'ttf-start' ); ?></span>
					<a class="skip-link screen-reader-text" href="#site-content"><?php _e( 'Skip to content', 'ttf-start' ); ?></a>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary'
					) );
					?>
				</nav>
			</header>

			<div id="site-content" class="site-content">
