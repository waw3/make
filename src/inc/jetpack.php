<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_jetpack_setup' ) ) :
/**
 * Jetpack compatibility
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_jetpack_setup() {
	// Add theme support for Infinite Scroll
	add_theme_support( 'infinite-scroll', array(
		'container'       => 'site-main',
		'footer'          => 'site-footer',
		'footer_callback' => 'ttf_one_jetpack_infinite_scroll_footer_callback',
		'footer_widgets'  => array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' ),
		'render'          => 'ttf_one_jetpack_infinite_scroll_render'
	) );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_jetpack_setup' );

if ( ! function_exists( 'ttf_one_jetpack_infinite_scroll_footer_callback' ) ) :
/**
 * Callback to render the special footer added by Infinite Scroll
 *
 * @since 1.0.0.
 *
 * @return void
 */
function ttf_one_jetpack_infinite_scroll_footer_callback() {
	$footer_layout = (int) get_theme_mod( 'footer-layout', ttf_one_get_default( 'footer-layout' ) );
	$footer_text   = ttf_one_sanitize_text( get_theme_mod( 'footer-text', ttf_one_get_default( 'footer-text' ) ) );
	$social_links  = ttf_one_get_social_links();
	?>
	<div id="infinite-footer">
		<footer class="site-footer footer-layout-<?php echo $footer_layout; ?>" role="contentinfo">
			<?php if ( $footer_text ) : ?>
			<div class="footer-text">
				<?php echo ttf_one_sanitize_text( $footer_text ); ?>
			</div>
			<?php endif; ?>

			<div class="site-info">
				<?php // Footer credit
				printf(
					__( '%s theme', 'ttf-one' ),
					'<span class="theme-name">One</span>'
				);
				?>
				<span class="theme-by"><?php _ex( 'by', 'attribution', 'ttf-one' ); ?></span>
				<span class="theme-author"><a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'ttf-one' ); ?>" href="https://thethemefoundry.com/">
					The Theme Foundry
				</a></span>
			</div>
		</footer>
	</div>
<?php
}
endif;

if ( ! function_exists( 'ttf_one_jetpack_infinite_scroll_has_footer_widgets' ) ) :
/**
 * Determine whether any footer widgets are actually showing.
 *
 * @since 1.0.0.
 *
 * @return bool
 */
function ttf_one_jetpack_infinite_scroll_has_footer_widgets() {
	// Get the view
	$view = ttf_one_get_view();

	// Get the relevant options
	$hide_footer = (bool) get_theme_mod( 'layout-' . $view . '-hide-footer', ttf_one_get_default( 'layout-' . $view . '-hide-footer' ) );
	$widget_areas = (int) get_theme_mod( 'footer-widget-areas', ttf_one_get_default( 'footer-widget-areas' ) );

	// No widget areas are visible
	if ( true === $hide_footer || $widget_areas < 1 ) {
		return false;
	}

	// Check for active widgets in visible widget areas
	$i = 1;
	while ( $i <= $widget_areas ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
			return true;
		}
		$i++;
	}

	// Still here? No footer widgets.
	return false;
}
endif;

add_filter( 'infinite_scroll_has_footer_widgets', 'ttf_one_jetpack_infinite_scroll_has_footer_widgets' );

if ( ! function_exists( 'ttf_one_jetpack_infinite_scroll_render' ) ) :
/**
 * Render the additional posts added by Infinite Scroll
 *
 * @since 1.0.0.
 *
 * @return void
 */
function ttf_one_jetpack_infinite_scroll_render() {
	while ( have_posts() ) : the_post();
		get_template_part( 'partials/content', 'archive' );
	endwhile;
}
endif;

if ( ! function_exists( 'ttf_one_jetpack_remove_sharing' ) ) :
/**
 * Remove the Jetpack Sharing output from the end of the post content
 * so it can be output elsewhere.
 *
 * @since 1.0.0.
 *
 * @return void
 */
function ttf_one_jetpack_remove_sharing() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
endif;

add_action( 'loop_start', 'ttf_one_jetpack_remove_sharing' );