<?php
/**
 * @package ttf-start
 */

// Get current URL
$current_url = '';
if ( isset( $_SERVER['SERVER_NAME'] ) && isset( $_SERVER['REQUEST_URI'] ) ) :
	$protocol = ( is_ssl() ) ? 'https://' : 'http://';
	$current_url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
endif;

get_header();
?>

<main id="site-main" class="site-main" role="main">
	<article class="error-404 not-found">
		<header class="entry-header">
			<h1 class="entry-title">
				<?php _e( 'Oops! That page can&rsquo;t be found.', 'ttf-start' ); ?>
			</h1>
		</header>

		<div class="entry-content">
			<p>
				<?php
				printf(
					__( 'Nothing was found at this location: %s', 'ttf-start' ),
					'<br /><span class="current-url">' . esc_url( $current_url ) . '</span>'
				);
				?>
			</p>
			<p>
				<?php _e( 'Maybe try one of the links below or a search?', 'ttf-start' ); ?>
			</p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

			<?php the_widget( 'WP_Widget_Archives', 'dropdown=1' ); ?>

			<?php if ( ttf_categorized_blog() ) : ?>
			<div class="widget widget_categories">
				<h4 class="widgettitle"><?php _e( 'Most Used Categories', 'ttf-start' ); ?></h4>
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
			</div>
			<?php endif; ?>

			<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
		</div>
	</article>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>