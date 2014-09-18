/* global jQuery, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function( $ ) {
	var formatWindow;

	ttfmakeFormatBuilder = {
		currentFormat: {},

		open: function( editor ) {
			var node = editor.selection.getNode(),
				selection = editor.selection.getSel(),
				content = editor.selection.getContent();

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

					}
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
				values: [
					{ value: '', text: '--- Formats ---', selected: 'selected', disabled: 'disabled' },
					{ value: 'button', text: 'Button' }
				],
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


		escAttr: function(s, preserveCR) {
			preserveCR = preserveCR ? '&#13;' : '\n';
			return ('' + s) /* Forces the conversion to string. */
				.replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
				.replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
				.replace(/"/g, '&quot;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
				.replace(/\r\n/g, preserveCR) /* Must be before the next replacement. */
				.replace(/[\r\n]/g, preserveCR);
		}
	};
})( jQuery );