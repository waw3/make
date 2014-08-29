/* global jQuery, _ */
var oneApp = oneApp || {};

(function (window, $, _, oneApp) {
	'use strict';

	oneApp.OverlayView = Backbone.View.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttfmake-overlay-close' : 'closeOnClick'
			});
		},

		open: function() {
			this.$el.show();
		},

		close: function() {
			this.$el.hide();
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