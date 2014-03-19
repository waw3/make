/*global jQuery */
var oneApp = oneApp || {};

(function ($) {
	'use strict';

	// Initiate a new TinyMCE editor instance
	oneApp.initEditor = function (id, type) {
		var mceInit = {},
			qtInit = {},
			tempName = 'ttfoneeditor' + type + 'temp';

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
		tinyMCEPreInit.mceInit[id].elements = id;
		tinyMCEPreInit.qtInit[id].id = id;
		tinyMCEPreInit.mceInit[id].selector = '#' + id;

		// Only display the tinyMCE instance if in that mode. Else, the buttons will display incorrectly.
		if ('tinymce' === ttfOneMCE) {
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
	};

	oneApp.initAllEditors = function(section_id, sectionType) {
		var $section = $('#' + section_id),
			$tinyMCEWrappers = $('.wp-editor-wrap', $section);

		$tinyMCEWrappers.each(function() {
			var $el = $(this),
				id = $el.attr('id').replace('wp-', '').replace('-wrap', '');

			oneApp.initEditor(id, sectionType);
		});
	};

	oneApp.removeTinyMCE = function (id) {};

	oneApp.addTinyMCE = function (id) {};
})(jQuery);