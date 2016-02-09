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
	 * Render the CSS for the Make Errors button in the Admin Bar.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	private function render_adminbar_css() {
		?>
		<style type="text/css">
			#wpadminbar .make-error-detail-head {
				background: #fcfcfc;
				border-bottom: 1px solid #dfdfdf;
				padding: 0;
				min-height: 36px
			}
			#wpadminbar .make-error-detail-body {
				padding: 16px;
			}
			#wpadminbar .make-error-detail-body a {
				color: #0073aa;
				text-decoration: underline;
			}
			#wpadminbar .make-error-detail-body a:hover {
				color: #00a0d2;
			}
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
			#wpadminbar .make-error-detail__ .ab-icon {
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
				background: #ffffff;
				box-sizing: border-box;
				overflow-x: auto;
				overflow-y: scroll;
				color: black;
			}
			#wpadminbar .notice-warning {
				padding: 10px 20px;
				color: #444;
				border-left: 4px solid #ffb900;
				background-color: #fff8e5;
			}
			#wpadminbar .notice-warning p,
			#wpadminbar .notice-warning a {
				font-family: 'Open Sans', sans-serif;
				font-size: 13px !important;
				font-weight: 600 !important;
			}
			#wpadminbar .notice-warning p strong {
				display: block;;
				font-size: 18px;
				font-weight: 600;
				line-height: 18px;
				padding: 9px 0;
			}
			#wpadminbar .make-error-detail h2 {
				font: bold 18px/36px "Open Sans",sans-serif;
				color: #444;
				margin: 0;
				padding: 0 36px 0 16px
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
			#wpadminbar .make-error-detail em,
			#wpadminbar .make-error-detail strong {
				font: 16px/20px "Open Sans",sans-serif;
			}
			#wpadminbar .make-error-detail a {
				display: inline;
				padding: 0;
			}
			#wpadminbar .make-error-detail em {
				font-style: italic;
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
	<?php
	}

	/**
	 * Render the CSS for the Make Errors button in the Admin Bar when there are no errors to display.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	private function render_adminbar_css_no_errors() {
		?>
		<style type="text/css">
			#wpadminbar #wp-admin-bar-make-errors {
				display: none;
			}
		</style>
	<?php
	}

	/**
	 * Render the JavaScript for handling the Make Errors button in the Admin Bar.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	private function render_adminbar_js() {
		?>
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
			$this->render_adminbar_css_no_errors();
			return;
		}

		// CSS
		$this->render_adminbar_css();
		?>
		<div id="make-error-detail-container">
			<div class="make-error-detail">
				<div class="make-error-detail-head">
					<h2><?php echo esc_html( $this->get_errors_title() ); ?></h2>
				</div>
				<div class="make-error-detail-body">
					<div class="notice notice-warning notice-alt notice-large">


					<p><strong><?php esc_html_e( 'What is a Make error?', 'make' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( __( '
							Make errors occurs when Make\'s functionality is used
							incorrectly or has been deprecated through an update. Often these errors will come from code in a child theme or plugin that extends the theme. The messages below
							help you to identify the cause of the errors so they can be fixed.
						', 'make' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'Is it important to fix these errors?', 'make' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( __( '
							Absolutely! Not fixing these errors may mean that parts of your theme are broken. We don\'t want that.
						', 'make' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'How do I fix a Make error?', 'make' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( __( '
							Be sure to update your child theme or plugin to the latest version as an update may be avaible that
							patches up the errors. If you can see it\'s an error caused by a theme modification, you\'ll need to edit the code to fix the errors.
							Check our article about <a href="https://thethemefoundry.com/make-help/" target="_blank">dealing with Make Errors</a> to learn more.
						', 'make' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'How can I hide this notification in the Admin Bar?', 'make' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( sprintf( __( '
							This notification is only visible to users who are logged in and have the capability to
							install themes. To hide it, set <code>WP_DEBUG</code> to <code>false</code>, or add this
							code to your functions.php file: %s
						', 'make' ), '
							<code>add_filter( \'make_show_errors\', \'__return_false\' );</code>
						' ) ); ?>
					</p>
					</div>
					<?php foreach ( $this->errors()->get_error_codes() as $code ) : ?>
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
						<hr />
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php
		// JavaScript
		$this->render_adminbar_js();
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
		return sprintf( _n( '%s Make Error', '%s Make Errors', $error_count, 'make' ), number_format_i18n( $error_count ) );
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
						<a id="make-error-detail-close" class="make-error-detail__close" href="#"><span class="ab-icon"></span></a>
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
		$allowedtags['br'] = true;
		return wp_kses( $message, $allowedtags );
	}
}
