<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Builder_SetupInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Builder_SetupInterface ) {
	return;
}

// Page
$this->register_builder( 'page' );