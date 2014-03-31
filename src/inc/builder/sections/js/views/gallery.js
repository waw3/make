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
				model: new oneApp.GalleryItemModel({
					id: new Date().getTime(),
					parentID: this.getParentID()
				})
			});

			// Append view
			var html = view.render().el;
			$('.ttf-one-gallery-items').append(html);
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttf-one-section-', '');

			return parseInt(id, 10);
		}
	});

	// Makes gallery items sortable
	oneApp.initializeGalleryItemSortables = function() {
		$('.ttf-one-gallery-items-stage').sortable({
			handle: '.ttf-one-sortable-handle',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-gallery-items-stage');

				$('.sortable-placeholder', $stage).height($item.height());
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-gallery-items-stage'),
					$orderInput = $('.ttf-one-gallery-item-order', $stage);

				oneApp.setOrder($(this).sortable('toArray'), $orderInput);
			}
		});
	}

	// Initialize the
	$oneApp.on('afterSectionViewAdded', function(evt, view) {
		if ('gallery' === view.model.get('sectionType')) {
			oneApp.initializeGalleryItemSortables();
		}
	})
})(window, jQuery, _, oneApp, $oneApp);