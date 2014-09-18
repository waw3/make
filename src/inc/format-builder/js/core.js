/* global jQuery, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function( $ ) {
	var formatWindow;

	ttfmakeFormatBuilder = {
		formats: {},
		currentFormat: {},
		currentSelection: {},

		open: function( editor ) {
			this.currentSelection.node = editor.selection.getNode();
			this.currentSelection.selection = editor.selection.getSel();
			this.currentSelection.content = editor.selection.getContent();

			//console.log(node);
			//console.log(selection);
			//console.log(content);

			formatWindow = editor.windowManager.open( {
				title: 'Format Builder',
				autoScroll: true,
				width: 400,
				height: 400,
				items: {
					type: 'container',
					name: 'formatContainer',
					layout: 'flow',
					align: 'stretch',
					padding: 5,
					spacing: 10,
					items: [
						{
							type: 'form',
							name: 'listboxForm',
							items: [ ttfmakeFormatBuilder.getFormatListBox() ]
						}
					]
				},
				buttons: {
					text: 'Insert',
					onclick: function() {
						var data = formatWindow.find('#optionsForm')[0].toJSON(),
							html;

						ttfmakeFormatBuilder.currentFormat.sanitizeOptions(data);
						html = ttfmakeFormatBuilder.currentFormat.getHTML(data);

						editor.insertContent(html);
						formatWindow.fire('submit');
					}
				},
				onclose: function() {
					ttfmakeFormatBuilder.currentFormat = {};
					ttfmakeFormatBuilder.currentSelection = {};
				}
			} );

		},


		parseNode: function( node ) {

		},


		getFormatListBox: function() {
			var listbox = {
				type: 'listbox',
				name: 'format',
				label: 'Choose a format',
				id: 'ttfmake-format-builder-picker',
				values: ttfmakeFormatBuilder.getFormatChoices(),
				onselect: function() {
					var choice = this.value(),
						fields = {
							type: 'form',
							name: 'optionsForm'
						};

					if ('undefined' !== typeof ttfmakeFormatBuilder.formats[choice]) {
						ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[choice];

						fields.items = ttfmakeFormatBuilder.currentFormat.getOptionFields();
						formatWindow.find('#optionsForm').remove();
						formatWindow.find('#formatContainer')[0].append(fields).reflow();
						formatWindow.repaint();
					}
				}
			};

			return listbox;
		},


		getFormatChoices: function() {
			var choices = [
				{ value: '', text: '--- Formats ---', selected: 'selected', disabled: 'disabled' },
				{ value: 'button', text: 'Button' }
			];

			return choices;
		}
	};
})( jQuery );