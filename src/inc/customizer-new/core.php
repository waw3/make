<?php
/**
 * @package Make
 */


class TTFMAKE_Customizer_Core {

	private $settings = null;

	public function __construct( $settings ) {
		if ( $settings instanceof TTFMAKE_Customizer_Settings ) {
			return;
		}

		$this->settings = $settings;

		$this->load();
	}

	private function load() {

	}

	private function get_panels() {

	}

	public function add_panels() {

	}

	private function get_sections() {

	}

	public function add_sections() {

	}

	private function add_controls() {

	}
}