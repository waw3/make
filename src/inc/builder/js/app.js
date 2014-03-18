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

	oneApp.initEditor = function (id, type) {
		var mceInit = {},
			qtInit = {},
			tempName = 'basiseditortemp' + type;

		/**
		 * Get the default values for this section type from the pre init object. Store them in a new object with
		 * the id of the section as the key.
		 */
		mceInit[id] = tinyMCEPreInit.mceInit[tempName];
		qtInit[id] = tinyMCEPreInit.qtInit[tempName];

		/**
		 * Append the new object to the pre init object. Doing so will provide the TinyMCE and quicktags code with
		 * the proper configuration information that is needed to init the editor.
		 */
		tinyMCEPreInit.mceInit = $.extend(tinyMCEPreInit.mceInit, mceInit);
		tinyMCEPreInit.qtInit = $.extend(tinyMCEPreInit.qtInit, qtInit);

		// Change the ID within the settings to correspond to the section ID
		console.log(id);
		tinyMCEPreInit.mceInit[id].elements = id;
		tinyMCEPreInit.qtInit[id].id = id;

		// Update the selector as well
		if (parseInt(tinyMCE.majorVersion, 10) >= 4) {
			tinyMCEPreInit.mceInit[id].selector = '#' + id;
		}

		// Only display the tinyMCE instance if in that mode. Else, the buttons will display incorrectly.
		if ('tinymce' === basisMCE) {
			tinyMCE.init(tinyMCEPreInit.mceInit[id]);
		}

		/**
		 * This is a bit of a back. In the quicktags.js script, the buttons are only added when this variable is
		 * set to false. It is unclear exactly why this is the case. By setting this variable, the editors are
		 * properly initialized. Not taking this set will cause the quicktags to be missing.
		 */
		QTags.instances[0] = false;

		// Init the quicktags
		quicktags(tinyMCEPreInit.qtInit[id]);

		/**
		 * When using the different editors, the wpActiveEditor variables needs to be set. If it is not set, the
		 * Add Media buttons, as well as some other buttons will add content to the wrong editors. This strategy
		 * assumes that if you are clicking on the editor, it is the active editor.
		 */
		var $wrapper = $('#wp-' + id + '-wrap');

		$wrapper.on('click', '.add_media', {id: id}, function (evt) {
			wpActiveEditor = evt.data.id;
		});

		$wrapper.on('click', {id: id}, function (evt) {
			wpActiveEditor = evt.data.id;
		});
	}

	oneApp.initAllEditors = function(section_id, sectionType) {
		var $section = $('#' + section_id),
			$tinyMCEWrappers = $('.wp-editor-wrap', $section);

		$tinyMCEWrappers.each(function() {
			var $el = $(this),
				id = $el.attr('id');

			oneApp.initEditor(id, sectionType);
		});
	}

	oneApp.initSortables();
})(jQuery);