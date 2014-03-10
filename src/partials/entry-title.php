<?php
/**
 * @package ttf-one
 */
?>

<h1 class="entry-title">
	<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
		<?php the_title(); ?>
	<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
</h1>