<?php
/**
 * @package ttf-one
 */

if ( ! class_exists( 'TTF_One_CSS' ) ) :
/**
 * Class TTF_One_CSS
 */
class TTF_One_CSS {

	/**
	 * The one instance of TTF_One_CSS
	 *
	 * @since 1.0.0
	 *
	 * @var TTF_One_CSS
	 */
	private static $instance;

	/**
	 *
	 */
	public $data = array();

	/**
	 *
	 */
	private $line_ending = "";

	/**
	 *
	 */
	private $tab = "";

	/**
	 * Instantiate or return the one TTF_One_CSS instance.
	 *
	 * @since  1.0.0
	 *
	 * @return TTF_One_CSS
	 */
	public static function instance() {
		if ( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 *
	 */
	function __construct() {
		// Set line ending
		if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
			$this->line_ending = "\n";
			$this->tab = "\t";
		}
	}

	/**
	 *
	 */
	public function add( $data ) {
		if ( ! isset( $data['selectors'] ) || ! isset( $data['declarations'] ) ) {
			return;
		}

		$entry = array();

		// Sanitize selectors
		$entry['selectors'] = array_map( 'trim', (array) $data['selectors'] );
		$entry['selectors'] = array_unique( $entry['selectors'] );

		// Sanitize declarations
		$entry['declarations'] = array_map( 'trim', (array) $data['declarations'] );

		// Check for media query
		if ( isset( $data['media'] ) ) {
			$media = $data['media'];
		} else {
			$media = 'all';
		}

		// Create new media query if it doesn't exist yet
		if ( ! isset( $this->data[$media] ) || ! is_array( $this->data[$media] ) ) {
			$this->data[$media] = array();
		}

		// Look for matching selector sets
		$match = false;
		foreach ( $this->data[$media] as $key => $rule ) {
			$diff = array_diff( $rule['selectors'], $entry['selectors'] );
			if ( empty( $diff ) ) {
				$match = $key;
				break;
			}
		}

		// No matching selector set, add a new entry
		if ( false === $match ) {
			$this->data[$media][] = $entry;
		}
		// Yes, matching selector set, merge declarations
		else {
			$this->data[$media][$match]['declarations'] = array_merge( $this->data[$media][$match]['declarations'], $entry['declarations'] );
		}
	}

	/**
	 *
	 */
	public function build() {
		if ( empty( $this->data ) ) {
			return '';
		}

		$n = $this->line_ending;

		// Make sure the 'all' array is first
		if ( isset( $this->data['all'] ) && count( $this->data ) > 1 ) {
			$all = $this->data['all'];
			unset( $this->data['all'] );
			$this->data['all'] = $all;
			$this->data['all'] = array_reverse( $this->data['all'], true );
		}

		$output = "\n<!-- Begin One Custom CSS -->\n<style type=\"text/css\" id=\"tff-one-custom-css\">$n";

		foreach ( $this->data as $query => $ruleset ) {
			if ( 'all' !== $query ) {
				$output .= "@media $query \{$n";
			}

			// Build each rule
			foreach ( $ruleset as $rule ) {
				$output .= $this->parse_selectors( $rule['selectors'] ) . '{' . $n;
				$output .= $this->parse_declarations( $rule['declarations'] );
				$output .= '}' . $n;
			}

			if ( 'all' !== $query ) {
				$output .= "\}$n";
			}
		}

		$output .= "</style>\n<!-- End One Custom CSS -->\n";

		return $output;
	}

	/**
	 *
	 */
	private function parse_selectors( $selectors ) {
		$n = $this->line_ending;

		$output = implode( ", $n", $selectors );

		return $output;
	}

	/**
	 *
	 */
	private function parse_declarations( $declarations ) {
		$n = $this->line_ending;
		$t = $this->tab;

		$output = '';

		foreach ( $declarations as $property => $value ) {
			$output .= "{$t}{$property}:{$value};$n";
		}

		return $output;
	}

}

/**
 * Return the one TTF_One_CSS object.
 *
 * @since  1.0.0
 *
 * @return TTF_One_CSS
 */
function ttf_one_get_css() {
	return TTF_One_CSS::instance();
}

endif;