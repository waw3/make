<?php
/**
 * @package Make
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
				'sanitize' => 'sanitize1',
			),
			'test2' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			),
			'test3' => array(
				'default'  => 'default3',
				'sanitize' => 'sanitize3',
				'extra_property' => 'extra_property3'
			),
		);
	}

	/**
	 * @since x.x.x.
	 */
	function test_add_settings() {
		// Add a valid setting
		$stub = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			)
		);
		$this->assertTrue( $stub->add_settings( $new_setting ) );
		$this->assertArrayHasKey( 'test', PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Try to add an invalid setting
		$stub = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
			)
		);
		$this->assertFalse( $stub->add_settings( $new_setting ) );
		$this->assertArrayNotHasKey( 'test', PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Add settings using defaults
		$stub = $this->get_instance();
		$new_setting = array(
			'test1' => array(),
			'test2' => array(),
		);
		$defaults = array(
			'default'  => 'default',
			'sanitize' => 'sanitize',
		);
		$this->assertTrue( $stub->add_settings( $new_setting, $defaults ) );
		$this->assertArraySubset( array(
			'test1' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			),
			'test2' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			),
		), PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Try to add setting that already exists, overwrite disabled
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$new_setting = array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		);
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertFalse( $stub->add_settings( $new_setting ) );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Overwrite a setting
		$stub = $this->get_instance();
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$new_setting = array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		);
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertTrue( $stub->add_settings( $new_setting, null, true ) );
		$this->assertFalse( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertArraySubset( array(
			'test1' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		), PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_remove_settings() {
		// Remove an existing setting
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertArrayHasKey( 'test1', PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertTrue( $stub->remove_settings( 'test1' ) );
		$this->assertArrayNotHasKey( 'test1', PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Try to remove a setting that doesn't exist
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertFalse( $stub->remove_settings( 'test_invalid' ) );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Remove all settings
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertTrue( $this->get_test_settings() === PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
		$this->assertTrue( $stub->remove_settings( 'all' ) );
		$this->assertEmpty( PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
	}

	/**
	 * @since x.x.x.
	 */
	function test_get_settings() {
		// Get full definitions
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertTrue( $this->get_test_settings() === $stub->get_settings() );

		// Get specific property that every setting has
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertTrue( array( 'test1' => 'default1', 'test2' => 'default2', 'test3' => 'default3' ) === $stub->get_settings( 'default' ) );

		// Get specific property that only some settings have
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, $this->get_test_settings() );
		$this->assertTrue( array( 'test3' => 'extra_property3' ) === $stub->get_settings( 'extra_property' ) );
	}


}