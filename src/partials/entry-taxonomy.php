<?php
/**
 * @package ttf-one
 */

$taxonomy_view = ttf_one_get_view();
$category_key = 'layout-' . $taxonomy_view . '-show-categories';
$tag_key = 'layout-' . $taxonomy_view . '-show-tags';
$category_option = (bool) get_theme_mod( $category_key, ttf_one_get_default( $category_key ) );
$tag_option = (bool) get_theme_mod( $tag_key, ttf_one_get_default( $tag_key ) );
?>

<?php if ( ( $category_option || $tag_option ) && ( ( has_category() && ttf_one_categorized_blog() ) || has_tag() ) ) : ?>
	<?php
	$category_list = get_the_category_list();
	$tag_list = get_the_tag_list( '<ul class="post-tags"><li>', "</li>\n<li>", '</li></ul>' ); // Replicates category output
	$taxonomy_output = '';

	// Categories
	if ( $category_option && $category_list ) :
		$taxonomy_output .= __( '<i class="fa fa-file"></i> ', 'ttf-one' ) . '%1$s';
	endif;

	// Tags
	if ( $tag_option && $tag_list ) :
		$taxonomy_output .= __( '<i class="fa fa-tag"></i> ', 'ttf-one' ) . '%2$s';
	endif;

	// Output
	printf(
		$taxonomy_output,
		$category_list,
		$tag_list
	);
	?>
<?php endif; ?>