<?php
/**
 * @package ttf-one
 */

// Get current URL
$current_url = '';
if ( isset( $_SERVER['SERVER_NAME'] ) && isset( $_SERVER['REQUEST_URI'] ) ) :
	$protocol = ( is_ssl() ) ? 'https://' : 'http://';
	$current_url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
endif;

// Widget args
$widget_args = array(
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h4 class="widget-title">',
	'after_title'   => '</h4>'
);

get_header();
?>

<main id="site-main" class="site-main" role="main">
	<article class="error-404 not-found">
		<header class="entry-header">
			<h1 class="entry-title">
				<?php _e( 'Oops! That page can&rsquo;t be found.', 'ttf-one' ); ?>
			</h1>
		</header>

		<div class="entry-content">
			<p>
				<?php
				printf(
					__( 'Nothing was found at this location: %s', 'ttf-one' ),
					'<br /><span class="current-url">' . esc_url( $current_url ) . '</span>'
				);
				?>
			</p>
			<p>
				<?php _e( 'Maybe try one of the links below or a search?', 'ttf-one' ); ?>
			</p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts', array(), $widget_args ); ?>

			<?php the_widget( 'WP_Widget_Archives', 'dropdown=1', $widget_args ); ?>

			<?php if ( ttf_one_categorized_blog() ) : ?>
			<aside class="widget widget_categories">
				<h4 class="widget-title"><?php _e( 'Most Used Categories', 'ttf-one' ); ?></h4>
				<ul>
					<?php
					wp_list_categories( array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'show_count' => 1,
						'title_li'   => '',
						'number'     => 10,
					) );
					?>
				</ul>
			</aside>
			<?php endif; ?>

			<?php the_widget( 'WP_Widget_Tag_Cloud', array(), $widget_args ); ?>
		</div>
	</article>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>