<?php
/**
 * @package Make
 */

// Header Options
$subheader_class = ( make_get_thememod_value( 'header-show-social', 'template' ) ) ? ' right-content' : '';
$hide_site_title = (int) get_theme_mod( 'hide-site-title', ttfmake_get_default( 'hide-site-title' ) );
$hide_tagline    = (int) get_theme_mod( 'hide-tagline', ttfmake_get_default( 'hide-tagline' ) );
$menu_label      = get_theme_mod( 'navigation-mobile-label', ttfmake_get_default( 'navigation-mobile-label' ) );
$header_bar_menu = wp_nav_menu( array(
	'theme_location'  => 'header-bar',
	'container_class' => 'header-bar-menu',
	'depth'           => 1,
	'fallback_cb'     => false,
	'echo'            => false,
) );
?>

<header id="site-header" class="<?php echo esc_attr( ttfmake_get_site_header_class() ); ?>" role="banner">
	<?php // Only show Sub Header if it has content
	if (
		make_get_thememod_value( 'header-text', 'template' )
		||
		( make_has_socialicons() && make_get_thememod_value( 'header-show-social', 'template' ) )
		||
		! empty( $header_bar_menu )
	) : ?>
	<div class="header-bar<?php echo esc_attr( $subheader_class ); ?>">
		<div class="container">
			<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'make' ); ?></a>
			<?php // Social links
			make_socialicons( 'header' ); ?>
			<?php // Header text; shown only if there is no header menu
			if ( ( make_get_thememod_value( 'header-text', 'template' ) || is_customize_preview() ) && empty( $header_bar_menu ) ) : ?>
				<span class="header-text">
				<?php echo make_get_thememod_value( 'header-text', 'template' ); ?>
				</span>
			<?php endif; ?>
			<?php echo $header_bar_menu; ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="site-header-main">
		<div class="container">
			<div class="site-branding">
				<?php // Logo
				if ( ttfmake_get_logo()->has_logo() ) : ?>
				<div class="custom-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a>
				</div>
				<?php endif; ?>
				<?php // Site title
				if ( get_bloginfo( 'name' ) ) : ?>
				<h1 class="site-title<?php if ( 1 === $hide_site_title ) echo ' screen-reader-text'; ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<?php endif; ?>
				<?php // Tagline
				if ( get_bloginfo( 'description' ) ) : ?>
				<span class="site-description<?php if ( 1 === $hide_tagline ) echo ' screen-reader-text'; ?>">
					<?php bloginfo( 'description' ); ?>
				</span>
				<?php endif; ?>
			</div>

			<?php // Search form
			if ( make_get_thememod_value( 'header-show-search', 'template' ) ) :
				get_search_form();
			endif; ?>

			<nav id="site-navigation" class="site-navigation" role="navigation">
				<span class="menu-toggle"><?php echo esc_html( $menu_label ); ?></span>
				<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'make' ); ?></a>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary'
				) );
				?>
			</nav>
		</div>
	</div>
</header>