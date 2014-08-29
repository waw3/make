/* global jQuery, _ */
var oneApp = oneApp || {};

(function (window, $, _, oneApp) {
	'use strict';

	oneApp.OverlayView = Backbone.View.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttfmake-overlay-close' : 'close'
			});
		},

		close: function(e) {
			e.preventDefault();

			this.$el.hide();
		}
	});

	// Initialize available gallery items
	oneApp.initOverlayViews = function () {
		var $items = $('.ttfmake-overlay');

		$items.each(function () {
			new oneApp.OverlayView({
				el: $(this)
			});
		});
	};

	// Initialize the views when the app starts up
	oneApp.initOverlayViews();
})(window, jQuery, _, oneApp);