/* global jQuery, ttfmakeIconPicker, ttfmakeIconObj */
var ttfmakeIconPicker;

( function( $ ) {
	var iconWindow, iconInsert;

	ttfmakeIconPicker = {
		open: function( editor ) {
			iconWindow = editor.windowManager.open( {
				title: 'Choose an icon',
				id: 'ttfmake-icon-picker',
				autoScroll: true,
				width: 420,
				height: 500,
				items: {
					type: 'container',
					layout: 'flex',
					align: 'stretch',
					direction: 'column',
					padding: 20,
					items: ttfmakeIconPicker.getIconCategories()
				},
				buttons: [
					ttfmakeIconPicker.getInsertButton()
				]
			} );
		},

		getIconCategories: function() {
			var items = [],
				category, grid;

			$.each( ttfmakeIconObj['fontawesome'], function( cat, icons ) {
				category = {
					type: 'container',
					html: '<h3>' + cat + '</h3>',
					style: 'padding: 20px 0 10px;'
				};
				items.push( category );

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

		getIconGrid: function( icons ) {
			var grid = [],
				icon;

			$.each( icons, function( index, data ) {
				icon = {
					html: '<div style="padding: 4px 0; text-align: center;"><i class="fa ' + data.id + '"></i></div>'
					//onclick: {

					//}
				};

				grid.push( icon );
			} );

			return grid;
		},

		getInsertButton: function() {
			var button = {
				text: 'Choose',
				id: 'ttfmake-icon-picker-insert',
				name: 'iconInsert',
				classes: 'button-primary',
				onPostRender: function() {
					// Store this control so it can be accessed later.
					iconInsert = this;
				},
				onclick: function() {

				}
			};

			return button;
		}
	};
})( jQuery );