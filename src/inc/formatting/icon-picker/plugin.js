( function( tinymce ) {
	tinymce.PluginManager.add( 'ttfmake_icon_picker', function( editor, url ) {
		editor.addCommand( 'Make_Icon_Picker', function() {
			if ( 'undefined' !== typeof window.ttfmakeIconPicker ) {
				window.ttfmakeIconPicker.open( editor );
			}
		} );

		editor.addButton( 'ttfmake_icon_picker', {
			icon: 'ttfmake-icon-picker',
			tooltip: 'Icon Picker',
			cmd: 'Make_Icon_Picker'
		} );
	} );
} )( tinymce );