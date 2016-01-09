/**
 * @package Make
 */

/* global jQuery, MakeControls */
(function($, MakeControls) {
	var api = wp.customize,
		Make;

	// Font choice loader
	Make = $.extend(MakeControls, {
		cache: {
			$document: $(document)
		},

		rtl: $('body').hasClass('rtl'),

		fontElements: {},

		initFont: function() {
			var self = this;

			self.cache.$document.one('ready', function() {
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
					self.insertChoices(response);
				}
			});
		},

		insertChoices: function(content) {
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

	// Make controls
	Make = $.extend(Make, {
		initControls: function() {
			var self = this;

			self.cache.$document.one('ready', function() {
				// Populate cache
				self.cache.$buttonset  = $('.ttfmake-control-buttonset, .ttfmake-control-image');
				self.cache.$bgposition = $('.ttfmake-control-background-position');
				self.cache.$range      = $('.ttfmake-control-range');

				// Initialize Button sets
				if (self.cache.$buttonset.length > 0) {
					self.buttonset();
				}

				// Initialize Background Position
				if (self.cache.$bgposition.length > 0) {
					self.bgposition();
				}

				// Initialize ranges
				if (self.cache.$range.length > 0) {
					self.range();
				}
			});
		},

		buttonset: function() {
			this.cache.$buttonset.buttonset();
		},

		bgposition: function() {
			// Initialize button sets
			this.cache.$bgposition.buttonset({
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
		},

		range: function() {
			this.cache.$range.each(function() {
				var $input = $(this),
					$slider = $input.parent().find('.ttfmake-range-slider'),
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
			});
		}
	});

	Make.initFont();
	Make.initControls();

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
