/**
 * @package ttf-one
 */

( function( $ ) {
	var api = wp.customize;

	/**
	 * Asynchronous updating
	 */
	// Site Title
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			var $content = $('.site-title a');
			if ( ! $content.length ) {
				$('.site-title').prepend('<a></a>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );
	// Tagline
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			var $content = $('.site-description');
			if ( ! $content.length ) {
				$('.site-branding').append('<span class="site-description"></span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );
	// Sticky Label
	api( 'general-sticky-label', function( value ) {
		value.bind( function( to ) {
			var $content = $('.sticky-post-label');
			if ( ! $content.length ) {
				$('.post .entry-header').append('<span class="sticky-post-label"></span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );
	// Header Text
	api( 'header-text', function( value ) {
		value.bind( function( to ) {
			var $content = $('.sub-header-content');
			if ( ! $content.length ) {
				$('.sub-header .container').prepend('<span class="sub-header-content"></span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );
	// Footer Text
	api( 'footer-text', function( value ) {
		value.bind( function( to ) {
			var $content = $('.footer-text');
			if ( ! $content.length ) {
				$('.site-info').before('<div class="footer-text"></div>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );
} )( jQuery );
