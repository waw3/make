/*global jQuery */
var oneApp = oneApp || {};

(function ($) {
	'use strict';

	// Kickoff Backbone App
	new oneApp.MenuView();

	oneApp.options = {
		openSpeed : 400,
		closeSpeed: 250
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
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttf-one-stage'),
					data = $(this).sortable('toArray');

				oneApp.setSectionOrder();

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

	oneApp.setSectionOrder = function () {};

	oneApp.removeTinyMCE = function (id) {};

	oneApp.addTinyMCE = function (id) {};

	oneApp.initSortables();
})(jQuery);