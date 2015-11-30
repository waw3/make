/**
 * @package Make
 */

(function($, wp, MakePreview) {
	var api = wp.customize,
		Make;

	// Cache
	Make = $.extend(MakePreview, {

	});

	// Style previews
	Make = $.extend(Make, {
		cache: {
			preview: {}
		},

		initStyles: function() {
			var self = this;

			self.styleSettings = self.styleSettings || {};
			$.each(self.styleSettings, function(i, settingId) {
				api(settingId, function(setting) {
					setting.bind(function() {
						self.getStylesValues(self.styleSettings);
						self.sendStylesRequest();
					});
				});
			});
		},

		getStylesValues: function(settings) {
			var self = this;

			$.each(settings, function(i, settingId) {
				api(settingId, function(setting) {
					self.cache.preview[settingId] = setting();
				});
			});
		},

		sendStylesRequest: function() {
			var self = this,
				data = {
					action: 'make-css-inline',
					preview: self.cache.preview
				};

			$.post(self.ajaxurl, data, function(response) {
				self.updateStyles(response);
			});
		},

		/**
		 * @link https://css-tricks.com/snippets/javascript/inject-new-css-rules/
		 *
		 * @param content
		 */
		updateStyles: function(content) {
			var styleId = 'make-preview-style',
				$newStyles = $('<div>', {
					id: styleId,
					html: '&shy;' + content
				});

			// Remove old preview stylesheet
			$('#'+styleId).remove();

			// Add new preview stylesheet
			if (content) {
				$newStyles.appendTo('body');
			}
		}
	});

	// Google URL
	Make = $.extend(Make, {
		initGoogleURL: function() {
			var self = this;


		},

		sendGoogleURLRequest: function() {
			var self = this,
				data = {
					action: 'make-google-url',
					fonts: self.cache.fonts
				};

			$.post(self.ajaxurl, data, function(response) {
				self.updateStyles(response);
			});
		},

		updateGoogleURL: function() {

		}
	});

	Make.initStyles();
	Make.initGoogleURL();

	/**
	 * Asynchronous updating
	 */
	// Site Title
	api('blogname', function(value) {
		value.bind(function(to) {
			var $content = $('.site-title'),
				$logo = $('.custom-logo'),
				$branding = $('.site-branding'),
				$title, $to;
			if (! $content.length) {
				$title = ('<h1 class="site-title">');
				if ($logo.length > 0) {
					$logo.after($title);
				} else {
					$branding.prepend($title);
				}
				$content = $('.site-title');
			}
			if (! to) {
				$content.remove();
			}
			$to = $('<a>').text(to);
			$content.html($to);
		});
	});
	api('hide-site-title', function(value) {
		value.bind(function(to) {
			var $title = $('.site-title');
			if (true == to) {
				$title.addClass('screen-reader-text');
			} else {
				$title.removeClass('screen-reader-text');
			}
		});
	});

	// Tagline
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			var $content = $('.site-description');
			if ( ! $content.length ) {
				$('.site-branding').append('<span class="site-description">' + to + '</span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		});
	});
	api('hide-tagline', function(value) {
		value.bind(function(to) {
			var $tagline = $('.site-description');
			if (true == to) {
				$tagline.addClass('screen-reader-text');
			} else {
				$tagline.removeClass('screen-reader-text');
			}
		});
	});

	// Mobile Menu Label
	api( 'navigation-mobile-label', function( value ) {
		value.bind( function( to ) {
			var $content = $('.menu-toggle');
			$content.text( to );
		} );
	} );

	// Sticky Label
	api( 'general-sticky-label', function( value ) {
		value.bind( function( to ) {
			var $content = $('.sticky-post-label');
			if ( ! $content.length ) {
				$('.post .entry-header').append('<span class="sticky-post-label">' + to + '</span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.text( to );
		} );
	} );

	// Read More Label
	api( 'label-read-more', function( value ) {
		value.bind( function( to ) {
			var $content = $('.read-more');
			$content.text( to );
		} );
	} );

	// Header Text
	api( 'header-text', function( value ) {
		value.bind( function( to ) {
			var $content = $('.header-text'),
				$headerBarMenu = $('.menu-header-bar-container');

			// Don't add text if the header bar menu exists
			if ( $headerBarMenu.length > 0 ) {
				return;
			}

			if ( ! $content.length ) {
				// Check for sub header
				var $container = $('.header-bar');
				if ( ! $container.length ) {
					$('#site-header').prepend('<div class="header-bar"><div class="container"></div></div>');
				}

				$('.header-bar .container').append('<span class="header-text">' + to + '</span>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.html( to );
		} );
	} );

	// Footer Text
	api( 'footer-text', function( value ) {
		value.bind( function( to ) {
			var $content = $('.footer-text');
			if ( ! $content.length ) {
				$('.site-info').before('<div class="footer-text">' + to + '</div>');
			}
			if ( ! to ) {
				$content.remove();
			}
			$content.html( to );
		} );
	} );
})(jQuery, wp, MakePreview);
