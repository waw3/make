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
			$('.ttf-one-gallery-items-stage').append(html);

			// Add the section value to the sortable order
			oneApp.addOrderValue(view.model.get('id'), $('.ttf-one-gallery-item-order', $(view.$el).parents('.ttf-one-gallery-items')));
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttf-one-section-', '');

			return parseInt(id, 10);
		}
	});

	// Makes gallery items sortable
	oneApp.initializeGalleryItemSortables = function(view) {
		$('.ttf-one-gallery-items-stage', view).sortable({
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
					$stage = $item.parents('.ttf-one-gallery-items'),
					$orderInput = $('.ttf-one-gallery-item-order', $stage);

				oneApp.setOrder($(this).sortable('toArray', {attribute: 'data-id'}), $orderInput);
			}
		});
	};

	// Initialize the color picker
	oneApp.initializeGalleryItemColorPicker = function (view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttf-one-gallery-background-color', view.$el);
		} else {
			$selector = $('.ttf-one-gallery-background-color');
		}

		$selector.wpColorPicker({
			defaultColor: '#ffffff'
		});
	};

	// Initialize the sortables
	$oneApp.on('afterSectionViewAdded', function(evt, view) {
		if ('gallery' === view.model.get('sectionType')) {
			// Add an initial gallery item
			$('.ttf-one-gallery-add-item', view.$el).click();

			// Initialize the sortables and picker
			oneApp.initializeGalleryItemSortables();
			oneApp.initializeGalleryItemColorPicker(view);
		}
	});

	// Initialize available gallery items
	oneApp.initGalleryItemViews = function () {
		$('.ttf-one-gallery-item').each(function () {
			var $item = $(this),
				idAttr = $item.attr('id'),
				id = $item.attr('data-id'),
				$section = $item.parents('.ttf-one-section'),
				parentID = $section.attr('data-id');

			// Build the model
			var model = new oneApp.GalleryItemModel({
				id: id,
				parentID: parentID
			});

			// Build the view
			new oneApp.GalleryItemView({
				model: model,
				el: $('#' + idAttr),
				serverRendered: true
			});
		});

		oneApp.initializeGalleryItemSortables();
		oneApp.initializeGalleryItemColorPicker();
	};

	// Initialize the views when the app starts up
	oneApp.initGalleryItemViews();
})(window, jQuery, _, oneApp, $oneApp);