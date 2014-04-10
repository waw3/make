<?php
/**
 * @package ttf-one
 */

$key = 'layout-' . ttf_one_get_view() . '-post-author';
$author_option = ttf_one_sanitize_choice( get_theme_mod( $key, ttf_one_get_default( $key ) ), $key );
?>

<?php if ( 'none' !== $author_option ) : ?>
<div class="entry-author">
	<?php if ( 'avatar' === $author_option || 'both' === $author_option ) : ?>
	<div class="entry-author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
	</div>
	<?php endif; ?>
	<?php if ( 'name' === $author_option || 'both' === $author_option ) : ?>
	<div class="entry-author-byline">
		<?php
		printf(
			_x( 'by %s', 'author byline', 'ttf-one' ),
			sprintf(
				'<a class="vcard" href="%1$s">%2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author_meta( 'display_name' ) )
			)
		);
		?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>