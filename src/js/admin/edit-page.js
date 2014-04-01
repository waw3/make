/*!
 * Script for adding functionality to the Edit Page screen.
 *
 * @since 1.0.0
 */
/* global jQuery */
(function($) {
	'use strict';

	var ttfOneEditPage = {
		/**
		 *
		 */
		cache: {
			$document: $(document)
		},

		/**
		 *
		 */
		init: function() {
			this.cacheElements();
			this.bindEvents();
		},

		/**
		 *
		 */
		cacheElements: function() {
			this.cache.$pageTemplate = $('#page_template');
			this.cache.$mainEditor = $('#postdivrich');
			this.cache.$builder = $('#ttf-one-builder');
			this.cache.$builderHide = $('#ttf-one-builder-hide');
		},

		/**
		 *
		 */
		bindEvents: function() {
			var self = this;

			// Setup the event for toggling the Page Builder when the page template input changes
			self.cache.$pageTemplate.on('change', self.templateToggle);

			self.cache.$document.on('ready', function() {
				self.cache.$pageTemplate.trigger('change');
			});
		},

		/**
		 *
		 * @param e
		 */
		templateToggle: function(e) {
			var val = $(e.target).val(),
				self = ttfOneEditPage;

			if ('template-builder.php' === val) {
				self.cache.$mainEditor.hide();
				self.cache.$builder.show();
				self.cache.$builderHide.prop('checked', true).parent().show();
			} else {
				self.cache.$mainEditor.show();
				self.cache.$builder.hide();
				self.cache.$builderHide.prop('checked', false).parent().hide();
			}
		}
	};

	ttfOneEditPage.init();
})(jQuery);