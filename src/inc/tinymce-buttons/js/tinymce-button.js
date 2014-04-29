(function(tinymce) {
	tinymce.PluginManager.add('ttfmake_mce_button_button', function( editor, url ) {
		editor.addButton('ttfmake_mce_button_button', {
			text: 'Button',
			icon: false,
			tooltip: 'Add button',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Button',
					body: [
						{
							type: 'textbox',
							name: 'text',
							label: 'Button text'
						},
						{
							type: 'textbox',
							name: 'url',
							label: 'Button URL',
							value: 'http://'
						},
						{
							type: 'listbox',
							name: 'style',
							label: 'Style',
							values: [
								{
									text: 'Normal',
									value: 'ttfmake-normal'
								},
								{
									text: 'Alert',
									value: 'ttfmake-alert'
								},
								{
									text: 'Download',
									value: 'ttfmake-download'
								}
							]
						},
						{
							type: 'listbox',
							name: 'color',
							label: 'Color',
							values: [
								{
									text: 'Primary',
									value: 'color-primary-background'
								},
								{
									text: 'Secondary',
									value: 'color-secondary-background'
								},
								{
									text: 'Success',
									value: 'ttfmake-success'
								},
								{
									text: 'Error',
									value: 'ttfmake-error'
								},
								{
									text: 'Important',
									value: 'ttfmake-important'
								}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '<a href="' + e.data.url + '" class="' + e.data.style + ' ' + e.data.color + ' ttfmake-button">' + e.data.text + '</a>');
					}
				});
			}
		});
	});
})(tinymce);