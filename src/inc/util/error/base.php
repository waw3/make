<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Util_Error_Base
 *
 * A tool for collecting Make-related error messages and outputting them all in one place.
 *
 * @since x.x.x.
 */
class MAKE_Util_Error_Base implements MAKE_Util_Error_ErrorInterface {
	/**
	 * Instance of WP_Error.
	 *
	 * @since x.x.x.
	 *
	 * @var
	 */
	private $errors;

	/**
	 * Switch for showing errors.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $show_errors = true;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Inject dependencies and set properties.
	 *
	 * @since x.x.x.
	 *
	 * @param WP_Error $errors
	 */
	public function __construct(
		WP_Error $errors = null
	) {
		// Set the WP_Error object.
		$this->errors = ( is_null( $errors ) ) ? new WP_Error : $errors;

		/**
		 * Filter: Toggle for showing Make errors.
		 *
		 * WP_DEBUG must also be set to true.
		 *
		 * @since x.x.x.
		 *
		 * @param bool    $show_errors    True to show errors.
		 */
		$this->show_errors = defined( 'WP_DEBUG' ) && true === WP_DEBUG && apply_filters( 'make_show_errors', true );
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Render the error markup in the page footer.
		if ( is_admin() ) {
			add_action( 'admin_footer', array( $this, 'render_errors' ), 99 );
		} else {
			add_action( 'wp_footer', array( $this, 'render_errors' ), 99 );
		}

		// Loading has occurred.
		$this->loaded = true;
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Wrapper to add an error to the injected instance of WP_Error.
	 *
	 * @since x.x.x.
	 *
	 * @param        $code
	 * @param        $message
	 * @param string $data
	 */
	public function add_error( $code, $message, $data = '' ) {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		$this->errors->add( $code, $message, $data );
	}

	/**
	 * Check if any errors have been added.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function has_errors() {
		return ! empty( $this->errors->errors );
	}

	/**
	 * Render the error messages within a container, include help text.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function render_errors() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'admin_footer', 'wp_footer' ) ) ) {
			return;
		}

		// Bail if there aren't any errors, or if showing them has been disabled.
		if ( ! $this->has_errors() || false === $this->show_errors ) {
			return;
		}

		// Classes for the error message container.
		$classes = 'notice notice-error error make-errors';
		if ( ! is_admin() ) {
			$classes .= '-frontend';
		}

		// Get the error message count.
		$error_count = count( $this->errors->get_error_messages() );

		?>
		<style type="text/css">
			.make-errors {
				max-height: 200px;
				overflow: scroll;
			}
			.make-errors-frontend {
				width: 100%;
				margin: 0 auto;
				padding: 1em;
			}
		</style>
		<div class="<?php echo $classes; ?>">
			<p>
				<strong><?php echo esc_html( sprintf( _n( '%s Make error', '%s Make errors', $error_count, 'make' ), number_format_i18n( $error_count ) ) ); ?></strong><br />
				<?php echo $this->sanitize_message( __( 'To hide, turn off <code>WP_DEBUG</code> or add a filter to <code>make_show_errors</code>.', 'make' ) ); ?>
			</p>
			<?php foreach ( $this->errors->get_error_codes() as $code ) : ?>
				<p><strong><?php echo esc_html( $code ); ?></strong></p>
				<p>
					<?php foreach ( $this->errors->get_error_messages( $code ) as $message ) :
						if ( is_array( $message ) ) :
							$message = $this->parse_backtrace( $message );
						endif;
						?>
						<?php echo $this->sanitize_message( $message ); ?><br />
					<?php endforeach; ?>
				</p>
			<?php endforeach; ?>
		</div>
	<?php
	}

	/**
	 * Attempt to parse the backtrace components of an array.
	 *
	 * @since x.x.x.
	 *
	 * @param array $backtrace
	 *
	 * @return mixed|string
	 */
	private function parse_backtrace( array $backtrace ) {
		if ( isset( $backtrace['file'] ) && isset( $backtrace['line'] ) ) {
			return sprintf( __( 'Called in <strong>%1$s</strong> on line <strong>%2$s</strong>.' ), $backtrace['file'], $backtrace['line'] );
		} else {
			return print_r( $backtrace, true );
		}
	}

	/**
	 * Sanitize an error message.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $message    The message string to sanitize.
	 * @return string                The sanitized message string.
	 */
	private function sanitize_message( $message ) {
		$allowedtags = wp_kses_allowed_html();
		$allowedtags['a']['target'] = true;
		return wp_kses( $message, $allowedtags );
	}
}