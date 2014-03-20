<?php
/**
 * @package ttf-one
 */
?><!DOCTYPE html>
<!--[if lte IE 9]><html class="no-js IE9 IE" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="site-wrapper" class="site-wrapper">

			<?php // Header partial
			get_template_part(
				'partials/header-layout',
				get_theme_mod( 'header-layout', ttf_one_get_default( 'header-layout' ) )
			);
			?>

			<div id="site-content" class="site-content">
				<div class="container">