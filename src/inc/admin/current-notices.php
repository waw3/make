<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Admin_NoticeInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Admin_NoticeInterface ) {
	return;
}

global $wp_version;

// Notice of unsupported WordPress version
if ( version_compare( $wp_version, TTFMAKE_MIN_WP_VERSION, '<' ) ) {
	$this->register_admin_notice(
		'make-wp-lt-min-version-' . TTFMAKE_MIN_WP_VERSION,
		sprintf(
			__( 'Make requires version %1$s of WordPress or higher. Your current version is %2$s. Please <a href="%3$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			TTFMAKE_MIN_WP_VERSION,
			esc_html( $wp_version ),
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

// Notice of upcoming drop of support for 4.2
if ( version_compare( $wp_version, '4.2', '<=' ) ) {
	$this->register_admin_notice(
		'make-wp-lte-42',
		sprintf(
			__( 'Make will soon be dropping support for WordPress version 4.2. Your current version is %1$s. Please <a href="%2$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			esc_html( $wp_version ),
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