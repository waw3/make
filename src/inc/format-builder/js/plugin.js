(function(tinymce) {
	tinymce.PluginManager.add('ttfmake_format_builder', function( editor, url ) {
		var formatFunctions = {
				// @link http://stackoverflow.com/a/9756789/719811
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
			},
			formatOptions = {
				button: {
					type: 'form',
					name: 'optionsForm',
					items: [
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
						},
						{
							type: 'textbox',
							name: 'buttonLabel1',
							label: 'Label',
							value: ''
						},
						{
							type: 'textbox',
							name: 'buttonURL1',
							label: 'URL',
							value: ''
						},
						{
							type: 'textbox',
							name: 'buttonColorBG1',
							label: 'Background Color'
						},
						{
							type: 'textbox',
							name: 'buttonColorText1',
							label: 'Text Color'
						},
						{
							type: 'textbox',
							name: 'buttonPaddingX1',
							label: 'Padding (horizontal)'
						},
						{
							type: 'textbox',
							name: 'buttonPaddingY1',
							label: 'Padding (vertical)'
						}
					]
				},
				alert: {
					type: 'form',
					name: 'optionsForm',
					items: [
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
					]
				}
			},
			formatWindow;

		function openWindow() {
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
							items: [
								{
									type: 'listbox',
									name: 'format',
									label: 'Choose a format',
									id: 'ttfmake-format-builder-picker',
									values: [
										{ value: '', text: '--- Formats ---', selected: 'selected', disabled: 'disabled' },
										{ value: 'button', text: 'Button' },
										{ value: 'alert', text: 'Alert Box' }
									],
									onselect: function() {
										var choice = this.value();
										formatWindow.find('#optionsForm').remove();
										formatWindow.find('#formatContainer')[0].append(formatOptions[choice]).reflow();
										formatWindow.repaint();
									}
								}
							]
						},
						formatOptions['button']
					]
				},
				buttons: {
					text: 'Insert',
					onclick: function() {

					}
				}
			} );
		}

		editor.addButton('ttfmake_format_builder', {
			icon: 'ttfmake-format-builder',
			tooltip: 'Format Builder',
			onclick: openWindow
		});
	});
})(tinymce);