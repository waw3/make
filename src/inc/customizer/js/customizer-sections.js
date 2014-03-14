/**
 * @package ttf-one
 */

( function( $ ) {
	var api = wp.customize;

	/**
	 * Visibility toggling for some controls
	 */
	$.each({
		'background_image': {
			controls: [ 'ttf-one_background_size' ],
			callback: function( to ) { return !! to; }
		},
		'main-background-image': {
			controls: [ 'ttf-one_main-background-repeat', 'ttf-one_main-background-position', 'ttf-one_main-background-attachment', 'ttf-one_main-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'footer-background-image': {
			controls: [ 'ttf-one_footer-background-repeat', 'ttf-one_footer-background-position', 'ttf-one_footer-background-attachment', 'ttf-one_footer-background-size' ],
			callback: function( to ) { return !! to; }
		}
	}, function( settingId, o ) {
		api( settingId, function( setting ) {
			$.each( o.controls, function( i, controlId ) {
				api.control( controlId, function( control ) {
					var visibility = function( to ) {
						control.container.toggle( o.callback( to ) );
					};

					visibility( setting.get() );
					setting.bind( visibility );
				});
			});

		});
	});
} )( jQuery );
