/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.GalleryView = oneApp.SectionView.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttf-one-gallery-add-item' : 'addGalleryItem'
			});
		},

		addGalleryItem : function (evt) {
			evt.preventDefault();

			// Create view
			var view = new oneApp.GalleryItemView({
				model: new oneApp.GalleryItemModel({ id: new Date().getTime() })
			});

			// Append view
			var html = view.render().el;
			$('.ttf-one-gallery-items').append(html);
		}
	});
})(window, jQuery, _, oneApp, $oneApp);