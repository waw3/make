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
		$this->assertArraySubset( $new_setting, PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

		// Try to add an invalid setting
		$stub = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
			)
		);
		$this->assertFalse( $stub->add_settings( $new_setting ) );
		$this->assertEmpty( PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );

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
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			)
		);
		$stub->add_settings( $new_setting );
		$this->assertFalse( $stub->add_settings( $new_setting ) );

		// Overwrite a setting
		$stub = $this->get_instance();
		$new_setting = array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			)
		);
		$stub->add_settings( $new_setting );
		$new_setting = array(
			'test' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		);
		$this->assertTrue( $stub->add_settings( $new_setting, null, true ) );
		$this->assertArraySubset( $new_setting, PHPUnit_Framework_Assert::readAttribute( $stub, 'settings' ) );
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
		$reflection_settings->setValue( $stub, array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			)
		) );
		$this->assertNotEmpty( $reflection_settings->getValue( $stub ) );
		$this->assertTrue( $stub->remove_settings( 'test' ) );
		$this->assertEmpty( $reflection_settings->getValue( $stub ) );

		// Try to remove a setting that doesn't exist
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, array(
			'test2' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			)
		) );
		$this->assertNotEmpty( $reflection_settings->getValue( $stub ) );
		$this->assertFalse( $stub->remove_settings( 'test' ) );
		$this->assertNotEmpty( $reflection_settings->getValue( $stub ) );

		// Remove all settings
		$stub = $this->get_instance();
		$reflection = new ReflectionClass( $stub );
		$reflection_settings = $reflection->getProperty( 'settings' );
		$reflection_settings->setAccessible( true );
		$reflection_settings->setValue( $stub, array(
			'test' => array(
				'default'  => 'default',
				'sanitize' => 'sanitize',
			),
			'test2' => array(
				'default'  => 'default2',
				'sanitize' => 'sanitize2',
			),
		) );
		$this->assertNotEmpty( $reflection_settings->getValue( $stub ) );
		$this->assertTrue( $stub->remove_settings( 'all' ) );
		$this->assertEmpty( $reflection_settings->getValue( $stub ) );
	}
}