/* global */

var ttfmakeFormatBuilder;

( function( $ ) {
	var formatWindow;

	ttfmakeFormatBuilder = {

		open: function(editor) {
			var node = editor.selection.getNode(),
				selection = editor.selection.getSel(),
				content = editor.selection.getContent();

			console.log(node);
			console.log(selection);
			console.log(content);



			/*
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
				},
				buttons: {
					text: 'Insert',
					onclick: function() {

					}
				}
			} );
			*/
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
						options = ttfmakeFormatBuilder.getOptionFields(choice);
					formatWindow.find('#optionsForm').remove();
					formatWindow.find('#formatContainer')[0].append(options).reflow();
					formatWindow.repaint();
				}
			};

			return listbox;
		},


		getOptionFields: function( format, values ) {
			var fields = {
				type: 'form',
				name: 'optionsForm'
			};
			switch(format) {
				case 'button' :
					fields.items = [
						{
							type: 'textbox',
							name: 'buttonLabel',
							label: 'Label',
							value: ''
						},
						{
							type: 'textbox',
							name: 'buttonURL',
							label: 'URL',
							value: ''
						},
						{
							type: 'textbox',
							name: 'buttonColorBG',
							label: 'Background Color'
						},
						{
							type: 'textbox',
							name: 'buttonColorText',
							label: 'Text Color'
						},
						{
							type: 'textbox',
							name: 'buttonPaddingX',
							label: 'Padding (horizontal)'
						},
						{
							type: 'textbox',
							name: 'buttonPaddingY',
							label: 'Padding (vertical)'
						}
					];
					break;
				case 'alert' :
					fields.items = [
						{
							type: 'textbox',
							multiline: true,
							name: 'alertText',
							label: 'Text',
							value: ''
						},
						{
							type: 'textbox',
							name: 'alertColorBG',
							label: 'Background Color'
						},
						{
							type: 'textbox',
							name: 'alertColorText',
							label: 'Text Color'
						},
						{
							type: 'textbox',
							name: 'alertPaddingX',
							label: 'Padding (horizontal)'
						},
						{
							type: 'textbox',
							name: 'alertPaddingY',
							label: 'Padding (vertical)'
						}
					];
					break;
			}

			return fields;
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