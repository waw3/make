<?php
/**
 * @package ttf-one
 */

$author_key = 'layout-' . ttf_one_get_view() . '-post-author';
$author_option = ttf_one_sanitize_choice( get_theme_mod( $author_key, ttf_one_get_default( $author_key ) ), $author_key );
?>

<?php if ( 'none' !== $author_option ) : ?>
<div class="entry-author">
	<?php if ( 'avatar' === $author_option ) : ?>
	<div class="entry-author-avatar">
		<?php
		printf(
			'<a class="vcard" href="%1$s">%2$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_avatar( get_the_author_meta( 'ID' ) )
		);
		?>
	</div>
	<?php endif; ?>
	<div class="entry-author-byline bypostauthor">
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
	<?php if ( is_singular() && $author_bio = get_the_author_meta( 'description' ) ) : ?>
	<div class="entry-author-bio">
		<?php echo wpautop( ttf_one_sanitize_text( $author_bio ) ); ?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>