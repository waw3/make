/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.GalleryView = oneApp.SectionView.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttf-one-gallery-background' : 'addGalleryItem'
			});
		},

		addGalleryItem : function (evt) {
			evt.preventDefault();

		}
	});
})(window, jQuery, _, oneApp, $oneApp);