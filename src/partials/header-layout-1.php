<?php
/**
 * @package ttf-one
 */
?>

<header id="site-header" class="site-header site-header-1" role="banner">
	<div class="sub-header">
		<div class="container">
			<?php $subheader_text = get_theme_mod( 'header-subheader-text', false ); ?>
			<?php if ( ! empty( $subheader_text ) ) : ?>
			<span class="sub-header-content"><?php echo $subheader_text; ?></span>
			<?php endif; ?>
			<?php get_search_form(); ?>
			<?php $links = ttf_one_get_social_links(); $hide_social = (int) get_theme_mod( 'header-hide-social', 1 ); ?>
			<?php if ( ! empty ( $links ) && 1 === $hide_social ) : ?>
				<ul class="sub-header-social">
					<?php foreach ( $links as $key => $link ) : ?>
						<li>
							<a href="<?php echo esc_url( $link['url'] ); ?>">
								<i class="fa <?php echo esc_attr( $link['class'] ); ?>"></i>
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
				<h1 class="site-title<?php if ( ttf_one_get_logo()->has_logo() ) echo ' custom-logo'; ?>">
					<?php
					$hide_site_title = (int) get_theme_mod( 'hide-site-title', 0 );
					if ( 1 !== $hide_site_title && get_bloginfo( 'name' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php endif; ?>
				</h1>
				<?php
				$hide_site_tagline = (int) get_theme_mod( 'hide-tagline', 0 );
				if ( 1 !== $hide_site_tagline && get_bloginfo( 'description' ) ) : ?>
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
	</div>
</header>