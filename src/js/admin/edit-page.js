/*!
 * Script for adding functionality to the Edit Page screen.
 *
 * @since 1.0.0
 */
/* global jQuery, TTFOneEditPage */
(function($) {
	'use strict';

	var ttfOneEditPage = {
		cache: {
			$document: $(document)
		},

		init: function() {
			this.cacheElements();
			this.bindEvents();
		},

		cacheElements: function() {
			this.cache.$pageTemplate = $('#page_template');
			this.cache.$mainEditor = $('#postdivrich');
			this.cache.$builder = $('#ttf-one-builder');
			this.cache.$builderHide = $('#ttf-one-builder-hide');
			this.cache.$featuredImage = $('#postimagediv');
		},

		bindEvents: function() {
			var self = this;

			// Setup the event for toggling the Page Builder when the page template input changes
			self.cache.$pageTemplate.on('change', self.templateToggle);

			if ( typeof TTFOneEditPage !== 'undefined' && 'post-new.php' === TTFOneEditPage.pageNow ) {
				self.cache.$pageTemplate.val('template-builder.php');
			}
		},

		templateToggle: function(e) {
			var self = ttfOneEditPage,
				val = $(e.target).val();

			if ('template-builder.php' === val) {
				self.cache.$mainEditor.hide();
				self.cache.$builder.show();
				self.cache.$builderHide.prop('checked', true).parent().show();
				self.featuredImageToggle('hide');
			} else {
				self.cache.$mainEditor.show();
				self.cache.$builder.hide();
				self.cache.$builderHide.prop('checked', false).parent().hide();
				self.featuredImageToggle('show');
			}
		},

		featuredImageToggle: function(state) {
			var self = ttfOneEditPage,
				unavailable;

			self.cache.$featuredImage.find('.ttf-one-message').remove();

			if ('undefined' !== typeof TTFOneEditPage) {
				unavailable = TTFOneEditPage.featuredImage;
			} else {
				unavailable = 'Featured images are not available for this page while using the current page template.';
			}

			unavailable = '<div class="ttf-one-message inside"><p class="hide-if-no-js">'+unavailable+'</p></div>';

			if ('show' === state) {
				self.cache.$featuredImage.find('.inside').show();
			} else {
				self.cache.$featuredImage.find('.inside').before(unavailable).hide();
			}
		}
	};

	ttfOneEditPage.init();
})(jQuery);