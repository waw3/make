<?php
/**
 * @package Make
 */


class MAKE_Builder_Model_SectionInstance extends MAKE_Settings_Base {

	private $values = array();


	public function set_value( $setting_id, $value ) {
		if ( $this->setting_exists( $setting_id ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id );

			if ( $this->undefined !== $sanitized_value ) {
				$this->values[ $setting_id ] = $sanitized_value;
				return true;
			}
		}

		return false;
	}


	public function unset_value( $setting_id ) {
		if ( $this->setting_exists( $setting_id ) ) {
			unset( $this->values[ $setting_id ] );
			return true;
		}

		return false;
	}


	public function get_raw_value( $setting_id ) {
		$value = $this->undefined;

		if ( $this->setting_exists( $setting_id ) ) {
			$value = $this->values[ $setting_id ];
		}

		return $value;
	}
	
	
	public function set_values( array $values ) {
		foreach ( $values as $setting_id => $value ) {
			$this->set_value( $setting_id, $value );
		}
	}
}