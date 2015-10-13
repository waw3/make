<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Util_Admin_NoticeInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Util_Admin_NoticeInterface ) {
	return;
}

global $wp_version;

// Notice of unsupported WordPress version
if ( version_compare( $wp_version, TTFMAKE_MIN_WP_VERSION, '<' ) ) {
	$this->register_admin_notice(
		'make-wp-lt-min-version',
		sprintf(
			__( 'Make requires version %1$s of WordPress or higher. Please <a href="%2$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			TTFMAKE_MIN_WP_VERSION,
			admin_url( 'update-core.php' )
		),
		array(
			'cap'     => 'update_core',
			'dismiss' => false,
			'screen'  => array( 'dashboard', 'themes.php', 'update-core.php' ),
			'type'    => 'error',
		)
	);
}

// Notice of upcoming drop of support for 4.0 and 4.1
if ( version_compare( $wp_version, '4.2', '<' ) ) {
	$this->register_admin_notice(
		'make-wp-lt-42',
		sprintf(
			__( 'Make will soon be dropping support for WordPress versions 4.0 and 4.1. Please <a href="%1$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			admin_url( 'update-core.php' )
		),
		array(
			'cap'     => 'update_core',
			'dismiss' => true,
			'screen'  => array( 'dashboard', 'themes.php', 'update-core.php' ),
			'type'    => 'warning',
		)
	);
}

// Notice to help with potential update issues with Make Plus
if ( true === make_is_plus() && version_compare( make_get_utils()->get_module( 'compatibility' )->get_plus_version(), '1.4.7', '<=' ) ) {
	$this->register_admin_notice(
		'make-plus-lte-147',
		sprintf(
			__( 'A new version of Make Plus is available. If you encounter problems updating through <a href="%1$s">the WordPress interface</a>, please <a href="%2$s" target="_blank">follow these steps</a> to update manually.', 'make' ),
			admin_url( 'update-core.php' ),
			'https://thethemefoundry.com/tutorials/updating-your-existing-theme/'
		),
		array(
			'cap'     => 'update_plugins',
			'dismiss' => true,
			'screen'  => array( 'dashboard', 'update-core.php', 'plugins.php' ),
			'type'    => 'warning',
		)
	);
}