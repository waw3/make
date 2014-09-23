( function( tinymce ) {
	tinymce.PluginManager.add( 'ttfmake_icon_picker', function( editor, url ) {
		editor.addCommand( 'Make_Icon_Picker', function() {
			if ( 'undefined' !== typeof window.ttfmakeIconPicker ) {
				window.ttfmakeIconPicker.open( editor, function( value ) {
					var icon = '<i class="fa ' + value + '">&nbsp;</i>';
					editor.insertContent( icon );
				} );
			}
		} );

		editor.addButton( 'ttfmake_icon_picker', {
			icon: 'ttfmake-icon-picker',
			tooltip: 'Insert Icon',
			cmd: 'Make_Icon_Picker'
		} );
	} );
} )( tinymce );