/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.BannerView = oneApp.SectionView.extend({
		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttf-one-add-slide': 'addSlide'
			});
		},

		addSlide: function (evt) {
			evt.preventDefault();

			// Create view
			var view = new oneApp.BannerSlideView({
				model: new oneApp.BannerSlideModel({
					id: new Date().getTime(),
					parentID: this.getParentID()
				})
			});

			// Append view
			var html = view.render().el;
			$('.ttf-one-banner-slides-stage').append(html);

			// Initiate the color picker
			oneApp.initializeBannerSlidesColorPicker(view);

			// Initiate the text editor
			oneApp.initAllEditors(view.idAttr, view.model);

			// Add the section value to the sortable order
			oneApp.addOrderValue(view.model.get('id'), $('.ttf-one-banner-slide-order', $(view.$el).parents('.ttf-one-banner-slides')));
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttf-one-section-', '');

			return parseInt(id, 10);
		}
	});

	// Makes banner slides sortable
	oneApp.initializeBannerSlidesSortables = function(view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttf-one-banner-slides-stage', view.$el);
		} else {
			$selector = $('.ttf-one-banner-slides-stage');
		}

		$selector.sortable({
			handle: '.ttf-one-banner-slide-header',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-banner-slides-stage');

				$('.sortable-placeholder', $stage).height($item.height());
				oneApp.disableEditors($item);
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-banner-slides'),
					$orderInput = $('.ttf-one-banner-slide-order', $stage);

				oneApp.setOrder($(this).sortable('toArray', {attribute: 'data-id'}), $orderInput);
				oneApp.enableEditors($item);
			}
		});
	};

	// Initialize the color picker
	oneApp.initializeBannerSlidesColorPicker = function (view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttf-one-banner-slide-background-color', view.$el);
		} else {
			$selector = $('.ttf-one-banner-slide-background-color');
		}

		$selector.wpColorPicker({
			defaultColor: '#ffffff'
		});
	};

	// Initialize the sortables
	$oneApp.on('afterSectionViewAdded', function(evt, view) {
		if ('banner' === view.model.get('sectionType')) {
			// Add an initial slide item
			$('.ttf-one-add-slide', view.$el).click();

			// Initialize the sortables
			oneApp.initializeBannerSlidesSortables(view);
		}
	});

	// Initialize available slides
	oneApp.initBannerSlideViews = function () {
		$('.ttf-one-banner-slide').each(function () {
			var $item = $(this),
				idAttr = $item.attr('id'),
				id = $item.attr('data-id'),
				$section = $item.parents('.ttf-one-section'),
				parentID = $section.attr('data-id');

			// Build the model
			var model = new oneApp.BannerSlideModel({
				id: id,
				parentID: parentID
			});

			// Build the view
			var view = new oneApp.BannerSlideView({
				model: model,
				el: $('#' + idAttr),
				serverRendered: true
			});

			oneApp.initializeBannerSlidesColorPicker(view);
		});

		oneApp.initializeBannerSlidesSortables();
	};

	// Initialize the views when the app starts up
	oneApp.initBannerSlideViews();
})(window, jQuery, _, oneApp, $oneApp);