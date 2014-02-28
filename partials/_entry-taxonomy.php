<?php
/**
 * @package ttf-start
 */
?>

<?php if ( ( has_category() && ttf_categorized_blog() ) || has_tag() ) : ?>
	<?php
	$category_list = get_the_category_list();
	$tag_list = get_the_tag_list();
	$taxonomy_output = '';

	// Categories
	if ( $category_list ) :
		$taxonomy_output .= __( 'Posted in: ', 'ttf-start' ) . '%1$s';
	endif;

	// Category / Tag divider
	if ( '' !== $taxonomy_output && $tag_list ) :
		$taxonomy_output .= '<br />';
	endif;

	// Tags
	if ( $tag_list ) :
		$taxonomy_output .= __( 'Tagged: ', 'ttf-start' ) . '%2$s';
	endif;

	// Output
	printf(
		$taxonomy_output,
		$category_list,
		$tag_list
	);
	?>
<?php endif; ?>