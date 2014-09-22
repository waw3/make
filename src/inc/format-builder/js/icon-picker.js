/* global jQuery, ttfmakeIconPicker, ttfmakeIconObj */
var ttfmakeIconPicker;

/**
 * Based on the charmap.js plugin
 */
( function( $ ) {
	var iconWindow, iconInsert;

	ttfmakeIconPicker = {
		open: function( editor ) {
			iconWindow = editor.windowManager.open( {
				title: 'Choose an icon',
				id: 'ttfmake-icon-picker',
				autoScroll: true,
				width: 340,
				height: 500,
				items: {
					type: 'container',
					layout: 'flex',
					align: 'stretch',
					direction: 'column',
					items: ttfmakeIconPicker.getIconCategories()
				},
				buttons: [
					ttfmakeIconPicker.getInsertButton()
				]
				/*
				onopen: function() {
					var maxHeight = 500;

					// Resize the window (automatically repaints as well)
					iconWindow.resizeToContent();
					winWidth = iconWindow.layoutRect().w;
					winHeight = iconWindow.layoutRect().h;
					viewWidth = ttfmakeIconPicker.editor.dom.getViewPort().w;
					viewHeight = ttfmakeIconPicker.editor.dom.getViewPort().h;
					if (winHeight > maxHeight) {
						iconWindow.resizeTo(winWidth, maxHeight);
						winHeight = iconWindow.layoutRect().h;
					}
					deltaW = (viewWidth - winWidth) / 2;
					deltaH = (viewHeight - winHeight) / 2;
					iconWindow.moveTo(deltaW, deltaH);
				}
				*/
			} );
		},

		getIconCategories: function() {
			var items = [],
				category, grid;

			$.each( ttfmakeIconObj['fontawesome'], function( cat, icons ) {
				category = {
					type: 'label',
					text: cat
				};
				items.push( category );

				grid = {
					type: 'container',
					layout: 'grid',
					columns: 10,
					defaults: {
						type: 'container',
						minWidth: 32,
						minHeight: 32,
						classes: 'icon-choice'
					},
					items: ttfmakeIconPicker.getIconGrid( icons )
				};
				items.push( grid );
			} ); console.log(items);

			return items;
		},

		getIconGrid: function( icons ) {
			var grid = [],
				icon;

			$.each( icons, function( index, data ) {
				icon = {
					html: '<i class="fa fa-fw ' + data.id + '"></i>'
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