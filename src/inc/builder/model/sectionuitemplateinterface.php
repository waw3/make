<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Builder_Model_SectionUITemplateInterface
 *
 * @since 1.8.0.
 */
interface MAKE_Builder_Model_SectionUITemplateInterface {
	public function add_button( $button_id, $args );

	public function remove_button( $button_id );

	public function add_element( $element_id, $args );

	public function remove_element( $element_id );

	public function add_control( $control_id, $args );

	public function remove_control( $control_id );

	public function render();
}