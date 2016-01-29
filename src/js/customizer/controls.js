/**
 * @package Make
 */

/* global jQuery, MakeControls */
(function($, MakeControls) {
	var api = wp.customize,
		Make;

	// Setup
	Make = $.extend(MakeControls, {
		cache: {
			$document: $(document)
		},

		rtl: $('body').hasClass('rtl')
	});

	// Font choice loader
	Make = $.extend(Make, {
		fontElements: {},

		initFont: function() {
			var self = this;

			self.cache.$document.ready(function() {
				self.getFontElements();

				$.each(self.fontElements, function(settingId, $element) {
					$element.on('chosen:showing_dropdown', self.sendFontRequest);

					$element.chosen({
						no_results_text: self.l10n.chosen_no_results_fonts,
						search_contains: true,
						width          : '100%'
					});
				});
			});
		},

		getFontElements: function() {
			var self = this;

			self.fontSettings = self.fontSettings || {};
			$.each(self.fontSettings, function(i, settingId) {
				var $element = $('select', '#customize-control-make_' + settingId);
				if ( $element.length > 0 ) {
					if (self.rtl) {
						$element.addClass('chosen-rtl');
					}

					self.fontElements[ settingId ] = $element;
				}
			});
		},

		sendFontRequest: function() {
			var self = Make,
				data = {
					action: 'make-font-choices'
				};

			$(this)
				.html('<option>' + self.l10n.chosen_loading + '</option>')
				.trigger('chosen:updated');

			$.post(self.ajaxurl, data, function(response) {
				if (response) {
					self.insertFontChoices(response);
				}
			});
		},

		insertFontChoices: function(content) {
			var self = this;

			$.each(self.fontElements, function(settingId, $element) {
				$element.html(content);

				api(settingId, function(setting) {
					var v = setting();
					$element
						.val(v)
						.off('chosen:showing_dropdown', self.sendFontRequest)
						.trigger('chosen:updated');
				});
			});
		}
	});

	Make.initFont();

	/**
	 * Initialize instances of MAKE_Customizer_Control_BackgroundPosition
	 *
	 * @since x.x.x.
	 */
	api.controlConstructor.make_backgroundposition = api.Control.extend({
		ready: function() {
			var control = this,
				$container = control.container.find('.make-backgroundposition-container');

			// Initialize the buttonset.
			$container.buttonset({
				create : function(event) {
					var $control = $(event.target),
						$positionButton = $control.find('label'),
						$caption = $control.parent().find('.background-position-caption');

					$positionButton.on('click', function() {
						var label = $(this).data('label');
						$caption.text(label);
					});
				}
			});

			// Listen for changes to the buttonset.
			$container.on('change', 'input:radio', function() {
				var value = $(this).parent().find('input:radio:checked').val();
				control.setting.set(value);
			});

			// Update the buttonset if the setting changes.
			control.setting.bind(function(value) {
				$container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
			});
		}
	});

	/**
	 * Initialize instances of MAKE_Customizer_Control_Radio
	 *
	 * @since x.x.x.
	 */
	api.controlConstructor.make_radio = api.Control.extend({
		ready: function() {
			var control = this,
				$container = control.container.find('.make-radio-container');

			$container.each(function() {
				if ($(this).hasClass('make-radio-buttonset-container') || $(this).hasClass('make-radio-image-container')) {
					$(this).buttonset();
				}
			});

			// Listen for changes to the radio group.
			$container.on('change', 'input:radio', function() {
				var value = $(this).parent().find('input:radio:checked').val();
				control.setting.set(value);
			});

			// Update the radio group if the setting changes.
			control.setting.bind(function(value) {
				$container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
			});
		}
	});

	/**
	 * Initialize instances of MAKE_Customizer_Control_Range
	 *
	 * @since x.x.x.
	 */
	api.controlConstructor.make_range = api.Control.extend({
		ready: function() {
			var control = this,
				$container = control.container.find('.make-range-container');

			$container.each(function() {
				var $input = $(this).find('.make-range-input'),
					$slider = $(this).find('.make-range-slider'),
					value = parseFloat( $input.val() ),
					min = parseFloat( $input.attr('min') ),
					max = parseFloat( $input.attr('max') ),
					step = parseFloat( $input.attr('step') );

				// Configure the slider
				$slider.slider({
					value : value,
					min   : min,
					max   : max,
					step  : step,
					slide : function(e, ui) { $input.val(ui.value) }
				});

				// Debounce the slide event so the preview pane doesn't update too often
				$slider.on('slide', _.debounce(function(e, ui) {
					$input.keyup().trigger('change');
				}, 300));

				// Sync values of number input and slider
				$input.val( $slider.slider('value')).on('change', function() {
					$slider.slider('value', $(this).val());
				});

				// Listen for changes to the range.
				$input.on('change', function() {
					var value = $(this).val();
					control.setting.set(value);
				});

				// Update the range if the setting changes.
				control.setting.bind(function(value) {
					$input.val(value);
				});
			});
		}
	});

	/**
	 * Initialize instances of MAKE_Customizer_Control_SocialIcons
	 *
	 * @since x.x.x.
	 */
	api.controlConstructor.make_socialicons = api.Control.extend({
		/**
		 * Additions to the default initialize routine.
		 *
		 * @since x.x.x.
		 *
		 * @param id
		 * @param options
		 */
		initialize: function(id, options) {
			var control = this;

			// Add template function
			options.params.itemTemplate = control.getItemTemplate();

			// Do parent stuff
			api.Control.prototype.initialize.apply(control, arguments);
		},

		/**
		 * Generate a templating function for the item sub-template.
		 *
		 * @since x.x.x.
		 */
		getItemTemplate: function() {
			var control = this,
				templateID = 'customize-control-make_socialicons-item';

			// Replace the container element's content with the control.
			if ( 0 !== $( '#tmpl-' + templateID ).length ) {
				return wp.template( templateID );
			}
		},

		/**
		 * Kick things off when the template has been embedded.
		 *
		 * @since x.x.x.
		 */
		ready: function() {
			var control = this,
				$container = control.container.find('.make-socialicons-container'),
				$stage = $container.find('.make-socialicons-stage'),
				$addbutton = $container.find('#add-icon_' + control.id),
				$emailtoggle = $container.find('#email-toggle_' + control.id),
				$emailaddress = $container.find('#email-address_' + control.id),
				$rsstoggle = $container.find('#rss-toggle_' + control.id),
				$rssurl = $container.find('#rss-url_' + control.id),
				$newwindow = $container.find('#new-window_' + control.id);

			// Set up sortable items
			$stage.sortable({
				handle: '.make-socialicons-item-handle',
				placeholder: 'make-socialicons-item-placeholder',
				update: function() {
					control.updateValue();
				}
			});

			// Add icon button
			$addbutton.on('click', function(evt) {
				evt.preventDefault();
				$stage.append( control.params.itemTemplate({type:'link'}) );
			});

			// Remove button
			$stage.on('click', '.make-socialicons-item-remove', function(evt) {
				evt.preventDefault();
				$(this).parent().remove();
				control.updateValue();
			});

			// Item inputs
			$stage.on('change', 'input', function() {
				control.updateValue();

				console.log('Look up icon...');
			});

			// Email toggle
			$emailtoggle.on('change', function(evt) {
				var checked = $(evt.target).prop('checked');

				if (checked) {
					$stage.append( control.params.itemTemplate({type:'email'}) );
					$emailaddress.parent().show();
				} else {
					$stage.find('.make-socialicons-item-email').remove();
					$emailaddress.parent().hide();
				}

				control.updateValue();
			});

			// RSS toggle
			$rsstoggle.on('change', function(evt) {
				var checked = $(evt.target).prop('checked');

				if (checked) {
					$stage.append( control.params.itemTemplate({type:'rss'}) );
					$rssurl.parent().show();
				} else {
					$stage.find('.make-socialicons-item-rss').remove();
					$rssurl.parent().hide();
				}

				control.updateValue();
			});

			// Additional options
			$emailaddress.add($rssurl).add($newwindow).on('change', function() {
				control.updateValue();
			});
		},

		/**
		 * Update the value field with data from all the inputs.
		 *
		 * @since x.x.x.
		 */
		updateValue: function() {
			var control = this,
				$items = control.container.find('.make-socialicons-item'),
				$options = control.container.find('.make-socialicons-options input'),
				$value = control.container.find('.make-socialicons-value'),
				newValue = { items: [] };

			$items.each(function() {
				var type = $(this).data('type');
				if ('link' === type) {
					newValue.items.push($(this).find('input').val());
				} else {
					newValue.items.push(type);
				}
			});

			$options.each(function() {
				var name = $(this).data('name');
				switch (name) {
					case 'email-toggle' :
					case 'rss-toggle' :
					case 'new-window' :
						newValue[name] = $(this).prop('checked');
						break;
					case 'email-address' :
					case 'rss-url' :
						newValue[name] = $(this).val();
						break;
				}
			});

			newValue = JSON.stringify(newValue);

			$value.val(newValue);
			control.setting.set(newValue);
		}
	});

	/**
	 * Visibility toggling for some controls
	 */
	$.each({
		'general-layout': {
			controls: [ 'make_background-info' ],
			callback: function( to ) { return 'full-width' === to; }
		},
		'main-background-color-transparent': {
			controls: [ 'make_main-background-color' ],
			callback: function( to ) { return ! to; }
		},
		'header-background-transparent': {
			controls: [ 'make_header-background-color' ],
			callback: function( to ) { return ! to; }
		},
		'header-bar-background-transparent': {
			controls: [ 'make_header-bar-background-color' ],
			callback: function( to ) { return ! to; }
		},
		'footer-background-transparent': {
			controls: [ 'make_footer-background-color' ],
			callback: function( to ) { return ! to; }
		},
		'background_image': {
			controls: [ 'make_background_position_x', 'make_background_attachment', 'make_background_size' ],
			callback: function( to ) { return !! to; }
		},
		'header-background-image': {
			controls: [ 'make_header-background-repeat', 'make_header-background-position', 'make_header-background-attachment', 'make_header-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'main-background-image': {
			controls: [ 'make_main-background-repeat', 'make_main-background-position', 'make_main-background-attachment', 'make_main-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'footer-background-image': {
			controls: [ 'make_footer-background-repeat', 'make_footer-background-position', 'make_footer-background-attachment', 'make_footer-background-size' ],
			callback: function( to ) { return !! to; }
		},
		'header-layout': {
			controls: [ 'make_header-branding-position' ],
			callback: function( to ) { return ( '1' == to || '3' == to ); }
		},
		'header-show-social': {
			controls: [ 'make_font-size-header-bar-icon' ],
			callback: function( to ) { return !! to; }
		},
		'footer-show-social': {
			controls: [ 'make_font-size-footer-icon' ],
			callback: function( to ) { return !! to; }
		},
		'layout-blog-featured-images': {
			controls: [ 'make_layout-blog-featured-images-alignment' ],
			callback: function( to ) { return ( 'post-header' === to ); }
		},
		'layout-archive-featured-images': {
			controls: [ 'make_layout-archive-featured-images-alignment' ],
			callback: function( to ) { return ( 'post-header' === to ); }
		},
		'layout-search-featured-images': {
			controls: [ 'make_layout-search-featured-images-alignment' ],
			callback: function( to ) { return ( 'post-header' === to ); }
		},
		'layout-post-featured-images': {
			controls: [ 'make_layout-post-featured-images-alignment' ],
			callback: function( to ) { return ( 'post-header' === to ); }
		},
		'layout-page-featured-images': {
			controls: [ 'make_layout-page-featured-images-alignment' ],
			callback: function( to ) { return ( 'post-header' === to ); }
		},
		'layout-blog-post-date': {
			controls: [ 'make_layout-blog-post-date-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-archive-post-date': {
			controls: [ 'make_layout-archive-post-date-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-search-post-date': {
			controls: [ 'make_layout-search-post-date-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-post-post-date': {
			controls: [ 'make_layout-post-post-date-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-page-post-date': {
			controls: [ 'make_layout-page-post-date-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-blog-post-author': {
			controls: [ 'make_layout-blog-post-author-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-archive-post-author': {
			controls: [ 'make_layout-archive-post-author-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-search-post-author': {
			controls: [ 'make_layout-search-post-author-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-post-post-author': {
			controls: [ 'make_layout-post-post-author-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-page-post-author': {
			controls: [ 'make_layout-page-post-author-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-blog-comment-count': {
			controls: [ 'make_layout-blog-comment-count-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-archive-comment-count': {
			controls: [ 'make_layout-archive-comment-count-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-search-comment-count': {
			controls: [ 'make_layout-search-comment-count-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-post-comment-count': {
			controls: [ 'make_layout-post-comment-count-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
		},
		'layout-page-comment-count': {
			controls: [ 'make_layout-page-comment-count-location' ],
			callback: function( to ) { return ( 'none' !== to ); }
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
})(jQuery, MakeControls);
