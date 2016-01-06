<?php
/**
 * @package Make
 */

class TEST_Make_Tests extends WP_UnitTestCase {
	/**
	 * @since x.x.x.
	 */
	function test_loaded_environment() {
		// Make is the active theme
		$this->assertTrue( 'make' === get_template() );

		// Make Plus is enabled
		$this->assertTrue( is_plugin_active( 'make-plus/make-plus.php' ) );
	}
}