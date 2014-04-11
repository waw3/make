<?php
/**
 * @package ttf-one
 */

// Posts and Pages
if ( is_singular() ) :
	the_content();

// Blog, Archives, Search Results
else :
	$content_key = 'layout-' . ttf_one_get_view() . '-auto-excerpt';
	$content_option = (bool) get_theme_mod( $content_key, ttf_one_get_default( $content_key ) );

	if ( $content_option || has_excerpt() ) :
		echo wpautop( get_the_excerpt() . "\n\n" . ttf_one_get_read_more() );
	else :
		the_content( ttf_one_get_read_more( '', '' ) );
	endif;
endif;