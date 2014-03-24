/*global jQuery */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function ($, oneApp, $oneApp) {
	'use strict';

	// Kickoff Backbone App
	new oneApp.MenuView();

	oneApp.options = {
		openSpeed : 400,
		closeSpeed: 250
	};

	oneApp.cache = {
		$sectionOrder: $('#ttf-one-section-order')
	};

	oneApp.initSortables = function () {
		$('.ttf-one-stage').sortable({
			handle: '.ttf-one-section-header',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-stage');

				$('.sortable-placeholder', $stage).height($item.height());

				/**
				 * When moving the section, the TinyMCE instance must be removed. If it is not removed, it will be
				 * unresponsive once placed. It is reinstated when the section is placed
				 */
				$('.wp-editor-area', $item).each(function () {
					var $this = $(this),
						id = $this.attr('id');

					oneApp.removeTinyMCE(id);
					delete tinyMCE.editors.id;
				});
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0));

				oneApp.setSectionOrder( $(this).sortable('toArray') );

				/**
				 * Reinstate the TinyMCE editor now that is it placed. This is a critical step in order to make sure
				 * that the TinyMCE editor is operable after a sort.
				 */
				$('.wp-editor-area', $item).each(function () {
					var $this = $(this),
						id = $this.attr('id'),
						$wrap = $this.parents('.wp-editor-wrap'),
						el = tinyMCE.DOM.get(id);

					// If the text area (i.e., non-tinyMCE) is showing, do not init the editor.
					if ($wrap.hasClass('tmce-active')) {
						// Restore the content, with pee
						el.value = switchEditors.wpautop(el.value);

						// Activate tinyMCE
						oneApp.addTinyMCE(id);
					}
				});
			}
		});
	};

	oneApp.setSectionOrder = function (order) {
		// Use a comma separated list
		order = oneApp.cleanSectionForOrdering(order.join());

		// Set the val of the input
		oneApp.cache.$sectionOrder.val(order);
	};

	oneApp.addSectionOrder = function (id) {
		var currentOrder = oneApp.cache.$sectionOrder.val(),
			currentOrderArray;

		if ('' === currentOrder) {
			currentOrderArray = [id];
		} else {
			currentOrderArray = currentOrder.split(',');
			currentOrderArray.push(id);
		}

		oneApp.setSectionOrder(currentOrderArray);
	};

	oneApp.removeSectionOrder = function (id) {
		var currentOrder = oneApp.cache.$sectionOrder.val(),
			currentOrderArray;

		if ('' === currentOrder) {
			currentOrderArray = [];
		} else {
			currentOrderArray = currentOrder.split(',');
			currentOrderArray = _.reject(currentOrderArray, function (item) {
				return id === parseInt(item, 10);
			});
		}

		oneApp.setSectionOrder(currentOrderArray);
	};

	oneApp.cleanSectionForOrdering = function (value) {
		return value.replace(/ttf-one-section-/g, '');
	}

	oneApp.initViews = function () {
		$('.ttf-one-section').each(function () {
			var $section = $(this),
				idAttr = $section.attr('id'),
				id = $section.attr('data-iterator'),
				sectionType = $section.attr('data-section-type');

			// Build the model
			var model = new oneApp.SectionModel({
				sectionType: sectionType,
				id: id
			});

			// Build the view
			new oneApp.SectionView({
				model: model,
				el: $('#' + idAttr),
				serverRendered: true
			});
		});
	}

	oneApp.initSortables();
	oneApp.initViews();
})(jQuery, oneApp, $oneApp);