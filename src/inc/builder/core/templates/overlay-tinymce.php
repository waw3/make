<?php
global $ttfmake_overlay_id;
$ttfmake_overlay_id = 'ttfmake-tinymce-overlay';

get_template_part( '/inc/builder/core/templates/overlay', 'header' );

wp_editor( '', 'make', array(
	'tinymce'       => array(
		'wp_autoresize_on' => false,
	),
	'resize'        => false,
	'editor_height' => 150
) );

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
