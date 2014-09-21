/* global jQuery, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function( $ ) {
	var formatWindow, formatInsert;

	/**
	 * The Format Builder object
	 *
	 * This holds all the functionality of the format builder except the bits that
	 * explicitly hook into TinyMCE. Those are found in plugin.js.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder = {
		editor: {},

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
			this.editor = editor;
			this.currentSelection.node = editor.selection.getNode();
			this.currentSelection.selection = editor.selection.getSel();
			this.currentSelection.content = editor.selection.getContent();

			var format = this.parseNode( this.currentSelection.node ),
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
			}

			// Open the window.
			formatWindow = editor.windowManager.open( {
				title: 'Format Builder',
				id: 'ttfmake-format-builder',
				autoScroll: true,
				items: {
					type: 'container',
					name: 'formatContainer',
					layout: 'flex',
					align: 'stretch',
					direction: 'column',
					items: items
				},
				buttons: ttfmakeFormatBuilder.getInsertButton(),
				onclose: function() {
					// Clear the current* objects so there are no collisions when the Format Builder
					// is opened again.
					ttfmakeFormatBuilder.editor = {};
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
		parseNode: function( node ) {
			var format = '';

			$.each(this.nodes, function( fmt, selector ) {
				var match = ttfmakeFormatBuilder.editor.dom.getParents( node, selector );
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
				//label: 'Choose a format',
				id: 'ttfmake-format-builder-picker',
				values: this.getFormatChoices(),
				onselect: function() {
					var choice = this.value(),
						fields = {
							type: 'form',
							name: 'optionsForm',
							layout: 'flex',
							align: 'stretch'
						},
						maxHeight = 500,
						winWidth, winHeight, viewWidth, viewHeight, deltaW, deltaH;

					// Only proceed if the chosen format has a model.
					if ('undefined' !== typeof ttfmakeFormatBuilder.formats[choice]) {
						ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[choice];

						// Generate the options fields
						fields.items = ttfmakeFormatBuilder.currentFormat.getOptionFields();

						// Remove previous option forms.
						formatWindow.find('#optionsForm').remove();

						// Add the new option form.
						formatWindow.find('#formatContainer')[0].append(fields).reflow();

						// Show the insert button.
						formatInsert.visible( true );

						// Resize the window (automatically repaints as well)
						formatWindow.resizeToContent();
						winWidth = formatWindow.layoutRect().w;
						winHeight = formatWindow.layoutRect().h;
						viewWidth = ttfmakeFormatBuilder.editor.dom.getViewPort().w;
						viewHeight = ttfmakeFormatBuilder.editor.dom.getViewPort().h;
						if (winHeight > maxHeight) {
							formatWindow.resizeTo(winWidth, maxHeight);
							winHeight = formatWindow.layoutRect().h;
						}
						deltaW = (viewWidth - winWidth) / 2;
						deltaH = (viewHeight - winHeight) / 2;
						formatWindow.moveTo(deltaW, deltaH);

						// Repaint
						//formatWindow.repaint();
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
				{ value: '', text: 'Choose a format', selected: 'selected', disabled: 'disabled' },
				{ value: 'button', text: 'Button' }
			];

			return choices;
		},

		/**
		 * Get the insert button for the modal window.
		 *
		 * @since 1.4.0.
		 *
		 * @returns object
		 */
		getInsertButton: function() {
			var button = {
				text: 'Insert',
				id: 'ttfmake-format-builder-insert',
				name: 'formatSubmit',
				classes: 'button-primary',
				hidden: ( 'undefined' === typeof ttfmakeFormatBuilder.currentFormat.get ),
				onPostRender: function() {
					// Store this control so it can be accessed later.
					formatInsert = this;
				},
				onclick: function() {
					// Bail if no format has been chosen from the dropdown yet.
					if ( 'undefined' === typeof formatWindow.find( '#optionsForm' )[0] ) {
						return;
					}

					// Get the current data from the options form.
					var data = formatWindow.find( '#optionsForm' )[0].toJSON(),
						html;

					// Feed the current data into the model and sanitize it.
					ttfmakeFormatBuilder.currentFormat.sanitizeOptions( data );

					// Generate the HTML markup for the format based on the current data.
					html = ttfmakeFormatBuilder.currentFormat.getHTML( data );

					// Insert the HTML into the editor and close the modal.
					ttfmakeFormatBuilder.editor.insertContent( html );
					formatWindow.fire( 'submit' );
				}
			};

			return button;
		},

		/**
		 * Generate the definitions for a control group that picks and sets a color.
		 *
		 * @since 1.4.0.
		 *
		 * @param name
		 * @param label
		 * @returns object
		 */
		getColorButton: function( name, label ) {
			var model = ttfmakeFormatBuilder.currentFormat,
				button = {
				type: 'container',
				label: label,
				items: [
					{
						type: 'button',
						name: name + 'Button',
						border: '1 1 1 1',
						style: 'background-color: ' + model.get( name ) + '; border-color: #e5e5e5; box-shadow: none; width: 28px;',
						onclick: function() {
							var self = this, // Store the button for later access.
								ctrl = this.next(); // Get the hidden text field with the hex code.

							// Open the TinyMCE color picker plugin
							ttfmakeFormatBuilder.editor.settings.color_picker_callback( function( value ) {
								self.getEl().style.backgroundColor = value;
								ctrl.value( value );
							}, ctrl.value() );
						}
					},
					{
						type: 'textbox',
						name: name,
						hidden: true,
						value: model.get( name )
					}
				]
			};

			return button;
		}
	};
})( jQuery );