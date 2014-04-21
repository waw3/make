<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function ttf_one_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'ttf-one' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'ttf-one' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'comment-parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<header class="comment-header">
				<div class="comment-author vcard">
					<?php
					if ( 0 != $args['avatar_size'] ) :
						echo get_avatar( $comment, $args['avatar_size'] );
					endif;
					?>
					<?php
					printf(
						__( '%s <span class="says">says:</span>', 'ttf-one' ),
						sprintf(
							'<cite class="fn">%s</cite>',
							get_comment_author_link()
						)
					);
					?>
				</div>

				<div class="comment-date">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
							printf(
								_x( '%1$s at %2$s', '1: date, 2: time', 'ttf-one' ),
								get_comment_date(),
								get_comment_time()
							);
							?>
						</time>
					</a>
				</div>

				<?php edit_comment_link( __( 'Edit', 'ttf-one' ), '<span class="edit-link">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ttf-one' ); ?></p>
				<?php endif; ?>
			</header>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<?php
			comment_reply_link( array_merge( $args, array(
				'add_below' => 'div-comment',
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<footer class="comment-reply">',
				'after'     => '</footer>',
			) ) );
			?>
		</article>

	<?php endif;
}
endif;

if ( ! function_exists( 'ttf_one_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function ttf_one_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats, DAY_IN_SECONDS );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so ttf_one_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ttf_one_categorized_blog should return false.
		return false;
	}
}
endif;

if ( ! function_exists( 'ttf_one_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in ttf_one_categorized_blog.
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_category_transient_flusher() {
	delete_transient( 'all_the_cool_cats' );
}
endif;

add_action( 'edit_category', 'ttf_one_category_transient_flusher' );
add_action( 'save_post',     'ttf_one_category_transient_flusher' );

if ( ! function_exists( 'ttf_one_get_read_more' ) ) :
/**
 * Return a read more link
 *
 * Use '%s' as a placeholder for the post URL.
 *
 * @since 1.0.0
 *
 * @param string $before
 * @param string $after
 *
 * @return string
 */
function ttf_one_get_read_more( $before = '<a class="read-more" href="%s">', $after = '</a>' ) {
	if ( strpos( $before, '%s' ) ) {
		$before = sprintf(
			$before,
			get_permalink()
		);
	}

	$more = apply_filters( 'ttf_one_read_more_text', __( 'Read more', 'ttf-one' ) );

	return $before . $more . $after;
}
endif;

if ( ! function_exists( 'ttf_one_maybe_show_site_region' ) ) :
/**
 * Output the site region (header or footer) markup if the current view calls for it
 *
 * @since 1.0.0
 *
 * @param string $region
 *
 * @return void
 */
function ttf_one_maybe_show_site_region( $region ) {
	if ( ! in_array( $region, array( 'header', 'footer' ) ) ) {
		return;
	}

	// Get the view
	$view = ttf_one_get_view();

	// Get the relevant option
	$hide_region = (bool) get_theme_mod( 'layout-' . $view . '-hide-' . $region, ttf_one_get_default( 'layout-' . $view . '-hide-' . $region ) );

	if ( true !== $hide_region ) {
		get_template_part(
			'partials/' . $region . '-layout',
			get_theme_mod( $region . '-layout', ttf_one_get_default( $region . '-layout' ) )
		);
	}
}
endif;

if ( ! function_exists( 'ttf_one_maybe_show_sidebar' ) ) :
/**
 * Output the sidebar markup if the current view calls for it.
 *
 * @since 1.0.0
 *
 * @param $location
 */
function ttf_one_maybe_show_sidebar( $location ) {
	// Get sidebar status
	$show_sidebar = ttf_one_has_sidebar( $location );

	// Output the sidebar
	if ( true === $show_sidebar ) {
		// Filter sidebar id
		$sidebar_id = apply_filters( 'ttf_one_sidebar_id', 'sidebar-' . $location, $location );

		// First look for a template file
		if ( '' !== $template_path = locate_template( $sidebar_id . '.php' ) ) {
			require_once( $template_path );
		}
		// Then fall back to the default markup
		else { ?>
		<section id="<?php echo $sidebar_id; ?>" class="widget-area <?php echo ( is_active_sidebar( $sidebar_id ) ) ? 'active' : 'inactive'; ?>" role="complementary">
			<?php if ( ! dynamic_sidebar( $sidebar_id ) ) : ?>
				&nbsp;
			<?php endif; ?>
		</section>
		<?php }
	}
}
endif;

if ( ! function_exists( 'ttf_one_maybe_show_social_links' ) ) :
/**
 * Show the social links markup if the theme options and/or menus are configured for it.
 *
 * @since 1.0.0.
 *
 * @param  string $region The site region (header or footer)
 * @return void
 */
function ttf_one_maybe_show_social_links( $region ) {
	if ( ! in_array( $region, array( 'header', 'footer' ) ) ) {
		return;
	}

	$show_social = (bool) get_theme_mod( $region . '-show-social', ttf_one_get_default( $region . '-show-social' ) );

	if ( true === $show_social ) {
		// First look for the alternate custom menu method
		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'social',
					'container'      => false,
					'menu_id'        => '',
					'menu_class'     => 'social-links ' . $region . '-social-links',
					'depth'          => 1,
					'fallback_cb'    => '',
				)
			);
		}
		// Then look for the Customizer theme option method
		else {
			$social_links = ttf_one_get_social_links();
			if ( ! empty( $social_links ) ) { ?>
				<ul class="social-links <?php echo $region; ?>-social-links">
				<?php foreach ( $social_links as $key => $link ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>">
						<a href="<?php echo esc_url( $link['url'] ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>">
							<i class="fa fa-fw <?php echo esc_attr( $link['class'] ); ?>"></i>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php }
		}
	}
}
endif;

if ( ! function_exists( 'ttf_one_pre_wp_nav_menu_social' ) ) :
/**
 * Alternative output for wp_nav_menu for the 'social' menu location.
 *
 * @since 1.0.0.
 *
 * @param  string    $output    Null
 * @param  object    $args      wp_nav_menu arguments
 *
 * @return string
 */
function ttf_one_pre_wp_nav_menu_social( $output, $args ) {
	if ( ! $args->theme_location || 'social' !== $args->theme_location ) {
		return;
	}

	// Get the menu object
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );
	if ( ! $menu || is_wp_error( $menu ) ) {
		return;
	}

	$output = '';

	// Get the menu items
	$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

	// Set up the $menu_item variables
	_wp_menu_item_classes_by_context( $menu_items );

	// Sort the menu items
	$sorted_menu_items = array();
	foreach ( (array) $menu_items as $menu_item ) {
		$sorted_menu_items[ $menu_item->menu_order ] = $menu_item;
	}

	unset( $menu_items, $menu_item );

	// Supported social icons (filterable)
	$supported_icons = apply_filters( 'ttf_one_supported_social_icons', array(
		'fa-adn' => 'app.net',
		'fa-bitbucket' => 'bitbucket.org',
		'fa-dribbble' => 'dribbble.com',
		'fa-facebook' => 'facebook.com',
		'fa-flickr' => 'flickr.com',
		'fa-foursquare' => 'foursquare.com',
		'fa-github' => 'github.com',
		'fa-gittip' => 'gittip.com',
		'fa-google-plus-square' => 'plus.google.com',
		'fa-instagram' => 'instagram.com',
		'fa-linkedin' => 'linkedin.com',
		'fa-pinterest' => 'pinterest.com',
		'fa-renren' => 'renren.com',
		'fa-stack-exchange' => 'stackexchange.com',
		'fa-stack-overflow' => 'stackoverflow.com',
		'fa-trello' => 'trello.com',
		'fa-tumblr' => 'tumblr.com',
		'fa-twitter' => 'twitter.com',
		'fa-vimeo-square' => 'vimeo.com',
		'fa-vk' => 'vk.com',
		'fa-weibo' => 'weibo.com',
		'fa-xing' => 'xing.com',
		'fa-youtube' => 'youtube.com',
	) );

	//
	foreach ( $sorted_menu_items as $item ) {
		$item_output = '';

		// Look for matching icons
		foreach ( $supported_icons as $class => $pattern ) {
			if ( false !== strpos( $item->url, $pattern ) ) {
				$output .= '<li class="' . esc_attr( $class ) . '">';
				$output .= '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '">';
				$output .= '<i class="fa fa-fw ' . esc_attr( $class ) . '"></i>';
				$output .= '</a></li>';

				break;
			}
		}

		// No matching icons
		if ( '' === $item_output ) {
			$output .= '<li class="fa-user">';
			$output .= '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '">';
			$output .= '<i class="fa fa-fw fa-user"></i>';
			$output .= '</a></li>';
		}
	}

	// If there are menu items, add a wrapper
	if ( '' !== $output ) {
		$output = '<ul class="' . esc_attr( $args->menu_class ) . '">' . $output . '</ul>';
	}

	return $output;
}
endif;

add_filter( 'pre_wp_nav_menu', 'ttf_one_pre_wp_nav_menu_social', 10, 2 );

if ( ! function_exists( 'ttf_one_get_exif_data' ) ) :
/**
 * @param int $attachment_id
 *
 * @return string
 */
function ttf_one_get_exif_data( $attachment_id = 0 ) {
	// Validate attachment id
	if ( 0 === absint( $attachment_id ) ) {
		$attachment_id = get_post()->ID;
	}

	$output = '';

	$attachment_meta = wp_get_attachment_metadata( $attachment_id );
	$image_meta = ( isset( $attachment_meta[ 'image_meta' ] ) ) ? array_filter( $attachment_meta[ 'image_meta' ], 'trim' ) : array();
	if ( ! empty( $image_meta ) ) {
		// Defaults
		$defaults = array(
			'aperture' => 0,
  			'camera' => '',
  			'created_timestamp' => 0,
  			'focal_length' => 0,
  			'iso' => 0,
  			'shutter_speed' => 0,
		);
		$image_meta = wp_parse_args( $image_meta, $defaults );

		// Convert the shutter speed to a fraction and add units
		if ( 0 !== $image_meta[ 'shutter_speed' ] ) {
			$raw_ss = floatval( $image_meta['shutter_speed'] );
			$denominator = 1 / $raw_ss;
			if ( $denominator > 1 ) {
				$decimal_places = 0;
				if ( in_array( number_format( $denominator, 1 ), array( 1.3, 1.5, 1.6, 2.5 ) ) ) {
					$decimal_places = 1;
				}
				$converted_ss = sprintf(
					'1/%1$s %2$s',
					number_format_i18n( $denominator, $decimal_places ),
					_x( 'second', 'time', 'ttf-one' )
				);
			} else {
				$converted_ss = sprintf(
					'%1$s %2$s',
					number_format_i18n( $raw_ss, 1 ),
					_x( 'seconds', 'time', 'ttf-one' )
				);
			}
			$image_meta[ 'shutter_speed' ] = apply_filters( 'ttf_one_exif_shutter_speed', $converted_ss, $image_meta[ 'shutter_speed' ] );
		}

		// Convert the aperture to an F-stop
		if ( 0 !== $image_meta[ 'aperture' ] ) {
			$f_stop = sprintf(
				'%1$s' . '%2$s',
				_x( 'f/', 'camera f-stop', 'ttf-one' ),
				number_format_i18n( pow( sqrt( 2 ), absint( $image_meta[ 'aperture' ] ) ) )
			);
			$image_meta[ 'aperture' ] = apply_filters( 'ttf_one_exif_aperture', $f_stop, $image_meta[ 'aperture' ] );
		}

		$output .= "<ul class=\"entry-exif-list\">\n";

		// Camera
		if ( ! empty( $image_meta[ 'camera' ] ) ) {
			$output .= '<li><span>' . _x( 'Camera:', 'camera setting', 'ttf-one' ) . '</span> ';
			$output .= esc_html( $image_meta[ 'camera' ] ) . "</li>\n";
		}
		// Creation Date
		if ( ! empty( $image_meta[ 'created_timestamp' ] ) ) {
			$output .= '<li><span>' . _x( 'Taken:', 'camera setting', 'ttf-one' ) . '</span> ';
			$date = new DateTime( gmdate( "Y-m-d\TH:i:s\Z", $image_meta[ 'created_timestamp' ] ) );
			$output .= esc_html( $date->format( get_option( 'date_format' ) ) ) . "</li>\n";
		}
		// Focal length
		if ( ! empty( $image_meta[ 'focal_length' ] ) ) {
			$output .= '<li><span>' . _x( 'Focal length:', 'camera setting', 'ttf-one' ) . '</span> ';
			$output .= number_format_i18n( $image_meta[ 'focal_length' ], 0 ) . _x( 'mm', 'millimeters', 'ttf-one' ) . "</li>\n";
		}
		// Aperture
		if ( ! empty( $image_meta[ 'aperture' ] ) ) {
			$output .= '<li><span>' . _x( 'Aperture:', 'camera setting', 'ttf-one' ) . '</span> ';
			$output .= esc_html( $image_meta[ 'aperture' ] ) . "</li>\n";
		}
		// Exposure
		if ( ! empty( $image_meta[ 'shutter_speed' ] ) ) {
			$output .= '<li><span>' . _x( 'Exposure:', 'camera setting', 'ttf-one' ) . '</span> ';
			$output .= esc_html( $image_meta[ 'shutter_speed' ] ) . "</li>\n";
		}
		// ISO
		if ( ! empty( $image_meta[ 'iso' ] ) ) {
			$output .= '<li><span>' . _x( 'ISO:', 'camera setting', 'oxford' ) . '</span> ';
			$output .= absint( $image_meta[ 'iso' ] ) . "</li>\n";
		}

		$output .= "</ul>\n";
	}

	return $output;
}
endif;