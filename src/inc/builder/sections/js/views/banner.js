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

			// Add the section value to the sortable order
			oneApp.addOrderValue(view.model.get('id'), $('.ttf-one-banner-slide-order', $(view.$el).parents('.ttf-one-banner-slides')));
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttf-one-section-', '');

			return parseInt(id, 10);
		}
	});

	// Initialize the color picker
	oneApp.initializeBannerItemColorPicker = function (view) {
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
			oneApp.initializeBannerItemColorPicker(view);
		}
	});
})(window, jQuery, _, oneApp, $oneApp);