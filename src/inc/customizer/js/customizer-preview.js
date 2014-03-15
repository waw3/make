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
	// Hide Site Title
	api( 'hide-site-title', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.site-title a' ).hide();
			} else {
				$( '.site-title a' ).show();
			}
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
	// Hide Tagline
	api( 'hide-tagline', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.site-description' ).hide();
			} else {
				$( '.site-description' ).show();
			}
		} );
	} );
	// Sub Header Text
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
} )( jQuery );
