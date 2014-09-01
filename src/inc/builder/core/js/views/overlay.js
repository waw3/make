/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp) {
	'use strict';

	oneApp.OverlayView = Backbone.View.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttfmake-overlay-close' : 'closeOnClick'
			});
		},

		open: function() {
			$oneApp.trigger('overlayOpen', this.$el);
			this.$el.show();
		},

		close: function() {
			$oneApp.trigger('overlayClose', this.$el);
			this.$el.hide();

			// Pass the new content to the iframe and textarea
			var content = tinyMCE.get('make').getContent();
			$('#ttfmake-content-1').val(content);

			var iframe = document.getElementById('ttfmake-iframe-1'),
				iframeContent = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document,
				iframeBody = $('body', iframeContent);

			iframeBody.html(content);
		},

		closeOnClick: function(e) {
			e.preventDefault();
			this.close();
		}
	});

	// Initialize available gallery items
	oneApp.initOverlayViews = function () {
		oneApp.tinymceOverlay = new oneApp.OverlayView({
			el: $('#ttfmake-tinymce-overlay')
		});
	};

	// Initialize the views when the app starts up
	oneApp.initOverlayViews();
})(window, jQuery, _, oneApp);