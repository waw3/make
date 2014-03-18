<?php
/**
 * @package ttf-one
 */
?>

<?php if ( get_adjacent_post( false, '', true ) || get_adjacent_post( false, '', false ) ) : ?>
<nav class="navigation post-navigation" role="navigation">
	<span class="screen-reader-text"><?php _e( 'Post navigation', 'ttf-one' ); ?></span>
	<div class="nav-links">
	<?php
	previous_post_link(
		'<div class="nav-previous">%link</div>',
		_x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'ttf-one' )
	);
	next_post_link(
		'<div class="nav-next">%link</div>',
		_x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'ttf-one' )
	);
	?>
	</div>
</nav>
<?php endif; ?>