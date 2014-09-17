<?php
global $ttfmake_overlay_id, $ttfmake_overaly_title;
$ttfmake_overlay_id    = 'ttfmake-tinymce-overlay';
$ttfmake_overaly_title = __( 'Edit content', 'make' );

get_template_part( '/inc/builder/core/templates/overlay', 'header' );

wp_editor( '', 'make', array(
	'tinymce'       => array(
		'wp_autoresize_on' => false,
	),
	'resize'        => false,
	'editor_height' => 220
) );

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
