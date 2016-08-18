<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_HTMLAttributesInterface
 *
 * @since 1.8.0.
 */
interface MAKE_Util_HTMLAttributesInterface {
	public function add_one( $name, $value );

	public function add_class( $value );

	public function add_style( $value );

	public function add_data( $name, $value );

	public function add( $attributes );

	public function parse_style( $style );

	public function remove_all();

	public function remove_att( $name );

	public function remove_class( $value );

	public function remove_style( $value );

	public function remove_data( $name = '' );

	public function remove_one( $name, $value = '' );

	public function get();

	public function get_att( $name );

	public function get_data( $name = '' );

	public function has_att( $name );

	public function has_data( $name );

	public function render_att( $name );

	public function render_data( $name = '' );

	public function render( $leading_space = true );
}