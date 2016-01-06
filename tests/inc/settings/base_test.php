<?php
/**
 * @package Make
 */

/**
 * Class TEST_Settings_Base
 *
 * @since x.x.x.
 */
class TEST_Settings_Base extends WP_UnitTestCase {
	/**
	 * Get an object instance with mocked dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed
	 */
	function get_instance() {
		// Because the subject class is abstract, this returns a mock instead of an actual instance.
		return $this->getMockBuilder( 'MAKE_Settings_Base' )
			        ->setConstructorArgs( array(
				        $this->getMock( 'MAKE_Error_CollectorInterface' )
			        ) )
			        ->getMockForAbstractClass();
	}

	/**
	 * Populate an instance of the subject class with test settings definitions.
	 *
	 * @since x.x.x.
	 *
	 * @param $instance
	 */
	function populate_settings( MAKE_Settings_Base &$instance ) {
		$reflection = new ReflectionClass( $instance );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $instance, $this->get_test_settings() );
	}

	/**
	 * Get an array of setting definitions for testing.
	 *
	 * @since x.x.x.
	 *
	 * @return array
	 */
	function get_test_settings() {
		return array(
			'test1' => array(
				'default'  => 'default1',
				'sanitize' => 'strtolower',
			),
			'test2' => array(
				'default'            => 'default2',
				'sanitize'           => 'strtolower',
				'sanitize_alternate' => 'absint',
			),
			'test3' => array(
				'default'        => 'default3',
				'sanitize'       => 'invalid_callback',
				'extra_property' => 'extra_property3'
			),
		);
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings_valid() {
		// Add a valid setting
		$instance = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			)
		);
		$this->assertTrue( $instance->add_settings( $new_setting ) );
		$this->assertArrayHasKey( 'test', PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings_invalid() {
		// Try to add an invalid setting
		$instance = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
			)
		);
		$this->assertFalse( $instance->add_settings( $new_setting ) );
		$this->assertArrayNotHasKey( 'test', PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings_use_defaults() {
		// Add settings using defaults
		$instance = $this->get_instance();
		$new_setting = array(
			'test1' => array(),
			'test2' => array(),
		);
		$defaults = array(
			'default'  => 'default',
			'sanitize' => 'sanitize',
		);
		$this->assertTrue( $instance->add_settings( $new_setting, $defaults ) );
		$this->assertArraySubset( array(
			'test1' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			),
			'test2' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			),
		), PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings_exists_no_overwrite() {
		// Try to add setting that already exists, overwrite disabled
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$new_setting = array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		);
		$this->assertFalse( $instance->add_settings( $new_setting ) );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings_exists_overwrite() {
		// Overwrite a setting
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$new_setting = array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		);
		$this->assertTrue( $instance->add_settings( $new_setting, null, true ) );
		$this->assertArraySubset( array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		), PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_remove_settings_valid() {
		// Remove an existing setting
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertArrayHasKey( 'test1', PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
		$this->assertTrue( $instance->remove_settings( 'test1' ) );
		$this->assertArrayNotHasKey( 'test1', PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_remove_settings_invalid() {
		// Try to remove a setting that doesn't exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertFalse( $instance->remove_settings( 'test_invalid' ) );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_remove_settings_all() {
		// Remove all settings
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( $instance->remove_settings( 'all' ) );
		$this->assertEmpty( PHPUnit_Framework_Assert::readAttribute( $instance, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_settings_full() {
		// Get full definitions
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( $this->get_test_settings() === $instance->get_settings() );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_settings_one_every() {
		// Get specific property that every setting has
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( array( 'test1' => 'default1', 'test2' => 'default2', 'test3' => 'default3' ) === $instance->get_settings( 'default' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_settings_one_some() {
		// Get specific property that only some settings have
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( array( 'test3' => 'extra_property3' ) === $instance->get_settings( 'extra_property' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_setting_exists_yes() {
		// Setting does exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( $instance->setting_exists( 'test1' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_setting_exists_yes_property() {
		// Setting does exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( $instance->setting_exists( 'test3', 'extra_property' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_setting_exists_no() {
		// Setting does exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertFalse( $instance->setting_exists( 'test_invalid' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_setting_exists_no_property() {
		// Setting does exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertFalse( $instance->setting_exists( 'test1', 'extra_property' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_value_has_value() {
		// Setting has a value
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$instance->method( 'get_raw_value' )
		         ->will( $this->returnValue( 'a_real_value' ) );
		$this->assertEquals( 'a_real_value', $instance->get_value( 'test1' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_value_no_value() {
		// Setting doesn't have a value, returns default
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$instance->method( 'get_raw_value' )
		         ->will( $this->returnValue( null ) );
		$this->assertEquals( 'default1', $instance->get_value( 'test1' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_value_invalid() {
		// Setting does not exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$instance->expects( $this->never() )
		         ->method( 'get_raw_value' )
			     ->will( $this->returnValue( 'a_real_value' ) );
		$this->assertNull( $instance->get_value( 'test_invalid' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_default_valid() {
		// Setting exists
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertEquals( 'default1', $instance->get_default( 'test1' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_default_invalid() {
		// Setting does not exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertNull( $instance->get_default( 'test_invalid' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_is_default_true() {
		// Value is default
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertTrue( $instance->is_default( 'test1', 'default1' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_is_default_false() {
		// Value is not default
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertFalse( $instance->is_default( 'test1', 42 ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_is_default_invalid() {
		// Setting does not exist
		$instance = $this->get_instance();
		$this->populate_settings( $instance );
		$this->assertNull( $instance->is_default( 'test_invalid', 'default1' ) );
	}
}