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
			$( '.site-title a' ).text( to );
		} );
	} );
	// Hide Site Title
	api( 'hide-site-title', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.site-title' ).hide();
			} else {
				$( '.site-title' ).show();
			}
		} );
	} );
	// Tagline
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
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
} )( jQuery );
