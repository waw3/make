<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Error_Collector
 *
 * A tool for collecting Make-related error messages and outputting them all in one place.
 *
 * @since x.x.x.
 */
final class MAKE_Error_Collector extends MAKE_Util_Modules implements MAKE_Error_CollectorInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'errors' => 'WP_Error',
	);

	/**
	 * Switch for showing errors.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $show_errors = true;

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * MAKE_Error_Collector constructor.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct(
		MAKE_APIInterface $api,
		array $modules = array()
	) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'errors' => new WP_Error,
		) );

		// Load dependencies.
		parent::__construct( $api, $modules );

		/**
		 * Filter: Toggle for showing Make errors.
		 *
		 * @since x.x.x.
		 *
		 * @param bool    $show_errors    True to show errors.
		 */
		$this->show_errors = apply_filters( 'make_show_errors', true );
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Only hook up the error display if it is enabled and the current user can install themes.
		if ( true === $this->show_errors && current_user_can( 'install_themes' ) ) {
			// Add a button to the Admin Bar
			add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 500 );

			// Render the error markup in the page footer.
			if ( is_admin() ) {
				add_action( 'admin_footer', array( $this, 'render_errors' ), 99 );
			} else {
				add_action( 'wp_footer', array( $this, 'render_errors' ), 99 );
			}
		}

		// Hooking has occurred.
		$this->hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return $this->hooked;
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
		$this->errors()->add( $code, $message, $data );
	}

	/**
	 * Check if any errors have been added.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function has_errors() {
		return ! empty( $this->errors()->errors );
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
			?>
			<style type="text/css">
				#wpadminbar #wp-admin-bar-make-errors {
					display: none;
				}
			</style
		<?php
			return;
		}

		?>
		<style type="text/css">
			#wpadminbar #wp-admin-bar-make-errors {
				display: list-item;
				background-color: red;
			}
			#wpadminbar #wp-admin-bar-make-errors > .ab-item .ab-icon:before {
				content: "\f534";
				top: 2px;
			}
			#wpadminbar .make-error-detail-wrapper {
				display: none;
				-webkit-box-pack: center;-webkit-justify-content: center;-ms-flex-pack: center;justify-content: center;
				position: fixed;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
				z-index: 9999;
				background-color: rgba(0, 0, 0, .8);
				-webkit-font-smoothing: subpixel-antialiased; /*fix font-weight bug with transparent backgrounds*/
			}
			#wpadminbar .make-error-detail-wrapper--active {
				display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;
			}
			#wpadminbar .make-error-detail__close {
				display: block;
				position: absolute;
				top: 24px;
				right: 24px;
				margin: 0;
				font: 17px/17px "Open Sans",sans-serif;
				color: #fff;
				z-index: 1000;
			}
			#wpadminbar .make-error-detail__close .ab-icon {
				margin: 0;
				padding: 0;
				color: #fff;
			}
			#wpadminbar .make-error-detail__close .ab-icon:before {
				content: "\f158";
			}
			#wpadminbar .make-error-detail {
				-webkit-align-self: center;-ms-flex-item-align: center;align-self: center;
				z-index: 999;
				width: 100%;
				max-width: 1200px;
				max-height: 90%;
				margin: 24px;
				padding: 24px;
				background: #ffffff;
				box-sizing: border-box;
				overflow-x: auto;
				overflow-y: scroll;
				color: black;
			}
			#wpadminbar .make-error-detail h2 {
				font: bold 24px/32px "Open Sans",sans-serif;
				margin-bottom: 1.4em;
			}
			#wpadminbar .make-error-detail h3 {
				font: bold 20px/32px "Open Sans",sans-serif;
				margin-top: 1em;
				margin-bottom: 1em;
			}
			#wpadminbar .make-error-detail p {
				margin-bottom: 1em;
			}
			#wpadminbar .make-error-detail p,
			#wpadminbar .make-error-detail a,
			#wpadminbar .make-error-detail strong {
				font: 16px/20px "Open Sans",sans-serif;
			}
			#wpadminbar .make-error-detail a {
				display: inline;
				padding: 0;
			}
			#wpadminbar .make-error-detail strong {
				font-weight: bold;
			}
			#wpadminbar .make-error-detail code {
				font: 16px/20px monospace;
				padding: 2px 6px;
			}
			#make-error-detail-container {
				display: none;
			}
			@media screen and (max-width: 1400px) {
				#wpadminbar .make-error-detail-wrapper--active {
					-webkit-flex-direction: column;flex-direction: column;
				}
				#wpadminbar .quicklinks .make-error-detail__close {
					-webkit-align-self: center;-ms-flex-item-align: center;align-self: center;
					position: static;
					margin: 12px;
				}
				#wpadminbar .make-error-detail {
					margin: 0 24px;
				}
			}
			@media screen and (max-width: 782px) {
				#wpadminbar .quicklinks .make-error-detail__close {
					font: 36px/1 "Open Sans",sans-serif;
				}
			}
		</style>

		<div id="make-error-detail-container">
			<div class="make-error-detail">
				<h2><?php echo esc_html( $this->get_errors_title() ); ?></h2>
				<p><strong><?php esc_html_e( 'What is a &ldquo;Make error&rdquo;?', 'make' ); ?></strong></p>
				<p>
					<?php echo $this->sanitize_message( __( '
						This site is using the Make theme. A Make error occurs when Make\'s functionality is used
						incorrectly, often in a child theme or plugin that extends the theme. The messages below
						help to identify the cause of the errors so they can be fixed.
					', 'make' ) ); ?>
				</p>
				<p><strong><?php esc_html_e( 'How do I fix a Make error?', 'make' ); ?></strong></p>
				<p>
					<?php echo $this->sanitize_message( __( '
						Check to see if your child theme or plugin has an update available, as a new version may
						address the issues. If it is custom, you will need to modify the code to fix the errors.
						Consult the <a href="https://thethemefoundry.com/make-help/" target="_blank">Make
						documentation</a> for more information.
					', 'make' ) ); ?>
				</p>
				<p><strong><?php esc_html_e( 'How can I hide this notification?', 'make' ); ?></strong></p>
				<p>
					<?php echo $this->sanitize_message( sprintf( __( '
						This notification is only visible to users who are logged in and have the capability to
						install themes. To hide it, set <code>WP_DEBUG</code> to <code>false</code>, or add this
						code to your <strong>functions.php</strong> file: %s
					', 'make' ), '
						<code>add_filter( \'make_show_errors\', \'__return_false\' );</code>
					' ) ); ?>
				</p>
				<?php foreach ( $this->errors()->get_error_codes() as $code ) : ?>
					<hr />
					<h3><?php printf( esc_html__( 'Error code: %s', 'make' ), esc_html( $code ) ); ?></h3>
					<p>
						<?php foreach ( $this->errors()->get_error_messages( $code ) as $message ) :
							if ( is_array( $message ) ) :
								$message = $this->parse_backtrace( $message );
							endif;
							?>
							<?php echo $this->sanitize_message( $message ); ?><br />
						<?php endforeach; ?>
					</p>
				<?php endforeach; ?>
			</div>
		</div>

		<script type="application/javascript">
			if ('undefined' !== typeof jQuery) {
				(function($) {
					$(document).ready(function() {
						var $container   = $('#wp-admin-bar-make-errors'),
							$barbutton   = $container.find('> .ab-item'),
							$closebutton = $('#make-error-detail-close'),
							$overlay     = $('#make-error-detail-wrapper'),
							$content     = $('#make-error-detail-container');
						
						$barbutton.html('<span class="ab-icon"></span><span class="ab-label"><?php echo $this->get_errors_title(); ?></span>');
						$overlay.append($content.html());

						$barbutton.on('click', function(evt) {
							evt.preventDefault();
							$overlay.addClass('make-error-detail-wrapper--active');
						});

						$closebutton.on('click', function(evt) {
							evt.preventDefault();
							$overlay.removeClass('make-error-detail-wrapper--active');
						});
					});
				})(jQuery);
			}
		</script>
	<?php
	}

	/**
	 * Return a string showing the number of "Make errors".
	 *
	 * @since x.x.x.
	 *
	 * @return string
	 */
	private function get_errors_title() {
		// Get the error message count.
		$error_count = count( $this->errors()->get_error_messages() );
		return sprintf( _n( '%s Make error', '%s Make errors', $error_count, 'make' ), number_format_i18n( $error_count ) );
	}

	/**
	 * Add a node to the Admin Bar for showing the error notification.
	 *
	 * @since x.x.x.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 */
	public function admin_bar( WP_Admin_Bar $wp_admin_bar ) {
		// Only run this in the proper hook context.
		if ( 'admin_bar_menu' !== current_action() ) {
			return;
		}

		$wp_admin_bar->add_menu( array(
			'id'     => 'make-errors',
			'title'  => '',
			'href'   => '#',
			'parent' => 'top-secondary',
			'meta'   => array(
				'html' => '
					<div id="make-error-detail-wrapper" class="make-error-detail-wrapper">
						<a id="make-error-detail-close" class="make-error-detail__close" href="#"><span class="ab-icon"></span></span>' . esc_html__( 'Close', 'make' ) . '</a>
					</div>
				',
			),
		) );
	}

	/**
	 * Attempt to parse the backtrace components of an array.
	 *
	 * @since x.x.x.
	 *
	 * @param array $backtrace
	 *
	 * @return string
	 */
	public function parse_backtrace( array $backtrace ) {
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