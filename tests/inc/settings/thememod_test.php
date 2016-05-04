<?php
/**
 * @package Make
 */

/**
 * Class TEST_Settings_ThemeMod
 *
 * @since x.x.x.
 */
class TEST_Settings_ThemeMod extends WP_UnitTestCase {
	/**
	 * Get an instance of the subject class with mocked dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed
	 */
	function get_instance() {
		// Because the subject class is abstract, this returns a mock instead of an actual instance.
		return $this->getMockBuilder( 'MAKE_Settings_ThemeMod' )
		            ->setConstructorArgs( array(
			            $this->getMock( 'MAKE_APIInterface' ),
			            array(
				            'error'         => $this->getMock( 'MAKE_Error_CollectorInterface' ),
				            'compatibility' => $this->getMock( 'MAKE_Compatibility_MethodsInterface' ),
				            'choices'       => $this->getMock( 'MAKE_Choices_ManagerInterface' ),
				            'font'          => $this->getMock( 'MAKE_Font_ManagerInterface' ),
			            )
		            ) )
		            ->getMock();
	}

	/**
	 * Populate an instance of the subject class with test settings definitions.
	 *
	 * @since x.x.x.
	 *
	 * @param $instance
	 */
	function populate_settings( MAKE_Settings_ThemeMod &$instance ) {
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
}