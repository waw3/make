/* global jQuery, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function( $ ) {
	var formatWindow;

	/**
	 * The Format Builder object
	 *
	 * This holds all the functionality of the format builder except the bits that
	 * explicitly hook into TinyMCE. Those are found in plugin.js.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder = {
		/**
		 * Stores the models for each available format.
		 *
		 * @since 1.4.0.
		 */
		formats: {},

		/**
		 * Stores the selectors that identify the HTML wrappers for each format
		 * and associates them with format models.
		 *
		 * @since 1.4.0.
		 */
		nodes: {},

		/**
		 * The current format model when the Format Builder window is open.
		 *
		 * @since 1.4.0.
		 */
		currentFormat: {},

		/**
		 * Data associated with the current position/selection of the cursor
		 * in the TinyMCE editor.
		 *
		 * @since 1.4.0.
		 */
		currentSelection: {},

		/**
		 * Opens the TinyMCE modal window, and initializes all of the Format Builder
		 * functionality.
		 *
		 * @since 1.4.0.
		 *
		 * @param editor
		 */
		open: function( editor ) {
			this.currentSelection.node = editor.selection.getNode();
			this.currentSelection.selection = editor.selection.getSel();
			this.currentSelection.content = editor.selection.getContent();

			var format = this.parseNode( editor, this.currentSelection.node),
				items, width, height;

			if ('' == format) {
				// No existing format. Show listbox to choose a new format.
				items = [
					{
						type: 'form',
						name: 'listboxForm',
						items: ttfmakeFormatBuilder.getFormatListBox()
					}
				];
				width = 400;
				height = 100;
			} else if ('undefined' !== typeof ttfmakeFormatBuilder.formats[format]) {
				// Cursor is on an existing format. Only show the option form for that particular format.
				ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[format]({ update: true });
				items = [
					{
						type: 'form',
						name: 'optionsForm',
						items: ttfmakeFormatBuilder.currentFormat.getOptionFields()
					}
				];
				width = 600;
				height = 500;
			}

			// Open the window.
			formatWindow = editor.windowManager.open( {
				title: 'Format Builder',
				id: 'ttfmake-format-builder',
				autoScroll: true,
				width: width,
				height: height,
				items: {
					type: 'container',
					name: 'formatContainer',
					layout: 'stack',
					align: 'stretch',
					padding: 5,
					spacing: 10,
					items: items
				},
				buttons: {
					text: 'Insert',
					name: 'formatSubmit',
					onclick: function() {
						// Bail if no format has been chosen from the dropdown yet.
						if ('undefined' === typeof formatWindow.find('#optionsForm')[0]) {
							return;
						}

						// Get the current data from the options form.
						var data = formatWindow.find('#optionsForm')[0].toJSON(),
							html;

						// Feed the current data into the model and sanitize it.
						ttfmakeFormatBuilder.currentFormat.sanitizeOptions(data);

						// Generate the HTML markup for the format based on the current data.
						html = ttfmakeFormatBuilder.currentFormat.getHTML(data);

						// Insert the HTML into the editor and close the modal.
						editor.insertContent(html);
						formatWindow.fire('submit');
					}
				},
				onclose: function() {
					// Clear the current* objects so there are no collisions when the Format Builder
					// is opened again.
					ttfmakeFormatBuilder.currentFormat = {};
					ttfmakeFormatBuilder.currentSelection = {};
				}
			} );

		},

		/**
		 * Check to see if the cursor is currently on an existing format.
		 *
		 * @since 1.4.0.
		 *
		 * @param editor
		 * @param node
		 * @returns string
		 */
		parseNode: function( editor, node ) {
			var format = '';

			$.each(this.nodes, function( fmt, selector ) {
				var match = editor.dom.getParents( node, selector );
				if ( match.length > 0 ) {
					format = fmt;
					return false;
				}
			});

			return format;
		},

		/**
		 * Get the JSON definition for the format chooser listbox.
		 *
		 * @since 1.4.0.
		 *
		 * @returns object
		 */
		getFormatListBox: function() {
			var listbox = {
				type: 'listbox',
				name: 'format',
				label: 'Choose a format',
				id: 'ttfmake-format-builder-picker',
				values: this.getFormatChoices(),
				onselect: function() {
					var choice = this.value(),
						fields = {
							type: 'form',
							name: 'optionsForm',
							layout: 'stack'
						};

					// Only proceed if the chosen format has a model.
					if ('undefined' !== typeof ttfmakeFormatBuilder.formats[choice]) {
						ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[choice];

						fields.items = ttfmakeFormatBuilder.currentFormat.getOptionFields();

						// Remove previous option forms.
						formatWindow.find('#optionsForm').remove();

						// Resize the window
						formatWindow.resizeTo(600, 500);

						// Add the new option form and repaint the window.
						formatWindow.find('#formatContainer')[0].append(fields).reflow();
						formatWindow.repaint();
					}
				}
			};

			return listbox;
		},

		/**
		 * Get the list of available formats for use in the format chooser listbox.
		 *
		 * @since 1.4.0.
		 *
		 * @returns array
		 */
		getFormatChoices: function() {
			var choices = [
				{ value: '', text: '--- Formats ---', selected: 'selected', disabled: 'disabled' },
				{ value: 'button', text: 'Button' }
			];

			return choices;
		}
	};
})( jQuery );