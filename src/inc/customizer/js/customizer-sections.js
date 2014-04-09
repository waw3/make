/**
 * @package ttf-one
 */

( function( $ ) {
	var api = wp.customize;

	/**
	 * Visibility toggling for some controls
	 */
	$.each({
		'general-layout': {
			controls: [ 'ttf-one_background-info' ],
			callback: function( to ) { return 'full-width' === to; }
		},
		'background_image': {
			controls: [ 'ttf-one_background_size' ],
			callback: function( to ) { return !! to; }
		},
		'header-background-image': {
			controls: [ 'ttf-one_header-background-repeat', 'ttf-one_header-background-position', 'ttf-one_header-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'header-layout': {
			controls: [ 'ttf-one_header-branding-position' ],
			callback: function( to ) { return ( '1' == to || '3' == to ); }
		},
		'main-background-image': {
			controls: [ 'ttf-one_main-background-repeat', 'ttf-one_main-background-position', 'ttf-one_main-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'footer-background-image': {
			controls: [ 'ttf-one_footer-background-repeat', 'ttf-one_footer-background-position', 'ttf-one_footer-background-size' ],
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

	/**
	 * Custom control for toggling visibility of whole groups of controls
	 */
	api.MiscControlGroup = api.Control.extend({
		toggleGroup: function(group, controls, open) {
			if (true === open) {
				group.addClass('open');
			} else {
				group.removeClass('open');
			}

			$.each(controls, function(i, control) {
				var cid = control.id.replace('customize-control-', '');
				api.control( cid, function( control ) {
					var visibility = function( to ) {
						control.container.toggle( to );
					};

					visibility( open );
				});
			});
		},

		ready: function() {
			var control = this,
				state = control.state || 'closed',
				group = control.container.find('.ttf-one-control-group'),
				prefix = 'customize-control-' + group.attr('data-control-group'),
				groupControls = $('[id^="'+prefix+'"]');

			group.on('click', function(e) {
				e.preventDefault();

				state = control.state || 'closed';

				if ('open' === state) {
					control.state = 'closed';
				} else if ('closed' === state) {
					control.state = 'open';
				}

				control.toggleGroup(group, groupControls, 'open' === control.state);
			});

			control.toggleGroup(group, groupControls, 'open' === state);
		}
	});

	api.controlConstructor.group = api.MiscControlGroup;
} )( jQuery );
