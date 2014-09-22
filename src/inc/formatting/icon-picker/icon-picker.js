/* global jQuery, ttfmakeIconPicker, ttfmakeIconObj */
var ttfmakeIconPicker;

( function( $ ) {
	var iconWindow, iconInsert, iconValue;

	ttfmakeIconPicker = {
		/**
		 * Stores the callback to use when inserting the icon.
		 *
		 * @since 1.4.0.
		 */
		callback: {},

		/**
		 * Stores the element representing the currently chosen icon in the picker.
		 *
		 * @since 1.4.0.
		 */
		el: {},

		/**
		 * Opens the TinyMCE modal window, and initializes all of the Icon Picker
		 * functionality.
		 *
		 * @since 1.4.0.
		 *
		 * @param editor
		 * @param callback
		 * @param value
		 */
		open: function( editor, callback, value ) {
			// Store the callback for later.
			this.callback = callback;

			// Check for an existing value
			var currentValue = ( 'undefined' !== typeof value ) ? value : '';

			// Open the window.
			iconWindow = editor.windowManager.open( {
				title: 'Choose an icon',
				id: 'ttfmake-icon-picker',
				autoScroll: true,
				width: 420,
				height: 500,
				items: [
					{
						type: 'textbox',
						name: 'chosenIcon',
						hidden: true,
						value: currentValue,
						onPostRender: function() {
							// Store this control for later use.
							iconValue = this;
						}
					},
					{
						type: 'container',
						layout: 'flex',
						align: 'stretch',
						direction: 'column',
						padding: 20,
						items: ttfmakeIconPicker.getIconCategories()
					}
				],
				buttons: [
					ttfmakeIconPicker.getInsertButton()
				],
				onclose: function() {
					// Clear parameters to there are no collisions if the Icon Picker
					// is opened again.
					ttfmakeIconPicker.callback = {};
					ttfmakeIconPicker.el = {};
				}
			} );
		},

		/**
		 * Construct the definitions for each icon category section.
		 *
		 * @since 1.4.0.
		 *
		 * @returns {Array}
		 */
		getIconCategories: function() {
			var items = [],
				category, grid;

			$.each( ttfmakeIconObj['fontawesome'], function( cat, icons ) {
				// Icon category label.
				category = {
					type: 'container',
					html: '<h3>' + cat + '</h3>',
					style: 'padding: 20px 0 10px;'
				};
				items.push( category );

				// Icon grid container.
				grid = {
					type: 'container',
					layout: 'grid',
					columns: 10,
					spacing: 1,
					defaults: {
						type: 'container',
						minWidth: 36,
						minHeight: 36,
						classes: 'icon-choice',
						border: '1 1 1 1',
						style: 'border-color: #e5e5e5; border-style: solid;'
					},
					items: ttfmakeIconPicker.getIconGrid( icons )
				};
				items.push( grid );
			} );

			return items;
		},

		/**
		 * Construct the definitions for each icon control in a grid.
		 *
		 * @since 1.4.0.
		 *
		 * @param icons
		 * @returns {Array}
		 */
		getIconGrid: function( icons ) {
			var grid = [],
				icon;

			$.each( icons, function( index, data ) {
				function highlight( self ) {
					ttfmakeIconPicker.el = self.getEl();
					ttfmakeIconPicker.el.style.borderColor = '#2ea2cc';
					ttfmakeIconPicker.el.style.color = '#2ea2cc';
				}

				function unhighlight() {
					ttfmakeIconPicker.el.style.borderColor = '#e5e5e5';
					ttfmakeIconPicker.el.style.color = 'inherit';
					ttfmakeIconPicker.el = {};
				}

				icon = {
					html: '<div data-icon-value="' + data.id + '" style="padding: 4px 0; text-align: center;"><i title="' + data.name + '" class="fa ' + data.id + '"></i></div>',
					onPostRender: function() {
						var currentValue = ttfmakeIconPicker.getChosenIcon();
						if ( currentValue == data.id ) {
							// Highlight the selected icon.
							highlight( this );
						}
					},
					onclick: function() {
						var value;

						// Un-highlight the previously selected icon.
						if ( 'undefined' !== typeof ttfmakeIconPicker.el.style ) {
							unhighlight();
						}

						// Highlight the selected icon.
						highlight( this );

						// Get the icon ID and store it in the hidden text field.
						value = $( ttfmakeIconPicker.el ).find( '[data-icon-value]' ).data( 'icon-value' );
						iconWindow.find( '#chosenIcon' ).value( value );

						// Enable the insert button
						iconInsert.disabled( false );
					}
				};

				grid.push( icon );
			} );

			return grid;
		},

		/**
		 * Get the "Choose" button for the modal window.
		 *
		 * @since 1.4.0.
		 *
		 * @returns object
		 */
		getInsertButton: function() {
			var button = {
				text: 'Choose',
				id: 'ttfmake-icon-picker-insert',
				name: 'iconInsert',
				classes: 'button-primary',
				disabled: true,
				onPostRender: function() {
					// Store this control so it can be accessed later.
					iconInsert = this;
				},
				onclick: function() {
					// Get the currently selected icon.
					var value = ttfmakeIconPicker.getChosenIcon();

					if ( 'function' === typeof ttfmakeIconPicker.callback ) {
						// Fire the callback.
						ttfmakeIconPicker.callback( value );

						// Close the modal.
						iconWindow.fire( 'submit' );
					}
				}
			};

			return button;
		},

		/**
		 * Grabs the selected icon ID from the hidden text field.
		 *
		 * @since 1.4.0.
		 *
		 * @returns string
		 */
		getChosenIcon: function() {
			return iconValue.value();
		}
	};
})( jQuery );