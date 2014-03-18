<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
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

/**
 * Returns true if a blog has more than 1 category.
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

/**
 * Flush out the transients used in ttf_one_categorized_blog.
 */
function ttf_one_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'ttf_one_category_transient_flusher' );
add_action( 'save_post',     'ttf_one_category_transient_flusher' );

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