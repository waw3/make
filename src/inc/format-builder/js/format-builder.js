(function(tinymce) {
	tinymce.PluginManager.add('ttfmake_format_builder', function( editor, url ) {
		var formatBuilder = {
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
		};

		editor.addButton('ttfmake_format_builder', {
			icon: 'ttfmake-format-builder',
			tooltip: 'Format Builder',
			onclick: function() {

			}
		});
	});
})(tinymce);