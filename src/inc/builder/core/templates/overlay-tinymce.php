<?php
global $ttfmake_overlay_id;
$ttfmake_overlay_id = 'ttfmake-tinymce-overlay';

get_template_part( '/inc/builder/core/templates/overlay', 'header' );

wp_editor(
	'',
	'make',
	array()
);

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
