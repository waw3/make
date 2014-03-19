<?php
/**
 * @package ttf-one
 */
?>

<header id="site-header" class="site-header site-header-1" role="banner">
	<div class="sub-header">
		<div class="container">
			<?php // Header text
			$header_text = get_theme_mod( 'header-text', false );
			if ( ! empty( $header_text ) ) : ?>
			<span class="sub-header-content">
				<?php echo ttf_one_sanitize_text( $header_text ); ?>
			</span>
			<?php endif; ?>
			<?php // Search form
			if ( 1 === (int) get_theme_mod( 'header-show-search', ttf_one_get_default( 'header-show-search' ) ) ) :
				get_search_form();
			endif; ?>
			<?php // Social links
			$social_links = ttf_one_get_social_links();
			$show_social = (int) get_theme_mod( 'header-show-social', ttf_one_get_default( 'header-show-social' ) );
			if ( ! empty ( $social_links ) && 1 === $show_social ) : ?>
			<ul class="social-links header-social-links">
				<?php foreach ( $social_links as $key => $link ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>">
					<a href="<?php echo esc_url( $link['url'] ); ?>">
						<i class="fa fa-fw <?php echo esc_attr( $link['class'] ); ?>"></i>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
	</div>
	<div class="site-header-main">
		<div class="container">
			<div class="site-branding">
				<?php if ( ttf_one_get_logo()->has_logo() ) : ?>
				<div class="custom-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a>
				</div>
				<?php endif; ?>
				<h1 class="site-title">
					<?php // Site title
					if ( 1 !== (int) get_theme_mod( 'hide-site-title', ttf_one_get_default( 'hide-site-title' ) ) && get_bloginfo( 'name' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php endif; ?>
				</h1>
				<?php // Tagline
				if ( 1 !== (int) get_theme_mod( 'hide-tagline', ttf_one_get_default( 'hide-tagline' ) ) && get_bloginfo( 'description' ) ) : ?>
				<span class="site-description">
					<?php bloginfo( 'description' ); ?>
				</span>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="site-navigation" role="navigation">
				<?php $menu_label = get_theme_mod( 'navigation-mobile-label', ttf_one_get_default( 'navigation-mobile-label' ) );?>
				<span class="menu-toggle"><?php echo esc_html( $menu_label ); ?></span>
				<a class="skip-link screen-reader-text" href="#site-content"><?php _e( 'Skip to content', 'ttf-one' ); ?></a>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary'
				) );
				?>
			</nav>
		</div>
	</div>
</header>