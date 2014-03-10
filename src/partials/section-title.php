<?php
/**
 * @package ttf-start
 */
?>

<h1 class="section-title">
	<?php
	if ( is_archive() ) :
		if ( is_category() ) :
			printf(
				__( 'From %s', 'ttf-start' ),
				'<strong>' . single_cat_title( '', false ) . '</strong>'
			);

		elseif ( is_tag() ) :
			printf(
				__( 'Tagged %s', 'ttf-start' ),
				'<strong>' . single_tag_title( '', false ) . '</strong>'
			);

		elseif ( is_day() ) :
			printf(
				__( 'From %s', 'ttf-start' ),
				'<strong>' . get_the_date() . '</strong>'
			);

		elseif ( is_month() ) :
			printf(
				__( 'From %s', 'ttf-start' ),
				'<strong>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ttf-start' ) ) . '</strong>'
			);

		elseif ( is_year() ) :
			printf(
				__( 'From %s', 'ttf-start' ),
				'<strong>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ttf-start' ) ) . '</strong>'
			);

		elseif ( is_author() ) :
			if ( ! in_the_loop() ) :
				the_post();
			endif;
			printf(
				__( 'By %s', 'ttf-start' ),
				'<strong class="vcard">' . get_the_author() . '</strong>'
			);
			if ( ! in_the_loop() ) :
				rewind_posts();
			endif;

		else :
			_e( 'Archive', 'ttf-start' );

		endif;

	elseif ( is_search() ) :
		printf(
			__( 'Search for %s', 'ttf-start' ),
			'<strong class="search-keyword">' . get_search_query() . '</strong>'
		);
		printf(
			' &#45; <span class="search-result">%s</span>',
			sprintf(
				_n( '%s result found', '%s results found', $wp_query->found_posts, 'ttf-start' ),
				$wp_query->found_posts
			)
		);

	endif;
	?>
</h1>