<?php
get_template_part( '/inc/builder/core/templates/overlay', 'header' );

wp_editor(
	'',
	'make',
	array()
);

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
