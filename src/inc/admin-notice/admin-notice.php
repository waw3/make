<?php
/**
 * @package Make
 */

if ( ! class_exists( 'TTFMAKE_Admin_Notice' ) ) :
/**
 * Class TTFMAKE_Admin_Notice
 *
 * Display notices in the WP Admin
 *
 * @since 1.4.9.
 */
class TTFMAKE_Admin_Notice {

	var $notices = array();


	var $template = '';

	/**
	 * The one instance of TTFMAKE_Admin_Notice.
	 *
	 * @since 1.4.9.
	 *
	 * @var   TTFMAKE_Admin_Notice
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMAKE_Admin_Notice instance.
	 *
	 * @since  1.4.9.
	 *
	 * @return TTFMAKE_Admin_Notice
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct the object.
	 *
	 * @since 1.4.9.
	 *
	 * @return TTFMAKE_Admin_Notice
	 */
	public function __construct() {}

	/**
	 * Initialize the formatting functionality and hook into WordPress.
	 *
	 * @since 1.4.9.
	 *
	 * @return void
	 */
	public function init() {
		// Define template path
		$this->template = trailingslashit( dirname( __FILE__ ) ) . 'template.php';

		// Register Ajax action
		add_action( 'wp_ajax_make_hide_notice', array( $this, 'handle_ajax' ) );

		// Hook up notices
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}


	public function register_admin_notice( $id, $message, $args = array() ) {
		// Prep id
		$id = sanitize_title_with_dashes( $id );

		// Prep message
		$message = wp_kses( $message, wp_kses_allowed_html() );

		// Prep args
		$defaults = array(
			'cap'     => 'switch_themes',      // User capability to see the notice
			'dismiss' => true,                 // Whether notice is dismissable
			'screen'  => array( 'index.php' ), // Which screens to show the notice on
			'type'    => 'info',               // success, warning, error, info
		);
		$args = wp_parse_args( $args, $defaults );

		// Register the notice
		if ( $message ) {
			$this->notices[ $id ] = array_merge( array( 'message' => $message ), $args );
		}
	}


	private function get_notices( $screen = '' ) {
		if ( ! $screen ) {
			return $this->notices;
		}

		$user_id = get_current_user_id();
		$dismissed = get_user_meta( $user_id, 'ttfmake-dismissed-notices', true );
		$notices = $this->notices;

		foreach( $notices as $id => $args ) {
			if ( ! in_array( $screen, (array) $args['screen'] ) ) {
				unset( $notices[ $id ] );
				continue;
			}
			if ( ! current_user_can( $args['cap'] ) ) {
				unset( $notices[ $id ] );
				continue;
			}
			if ( in_array( $id, (array) $dismissed ) ) {
				unset( $notices[ $id ] );
				continue;
			}
		}

		return $notices;
	}


	public function admin_notices() {
		global $pagenow;
		$current_notices = $this->get_notices( $pagenow );

		if ( ! empty( $current_notices ) && file_exists( $this->template ) ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'print_footer_scripts' ) );
			$this->render_notices( $current_notices );
		}
	}


	private function render_notices( $notices ) {
		?>
		<style type="text/css">
			.ttfmake-dismiss {
				display: block;
				float: right;
				margin: 0.5em 0;
				padding: 2px;
			}
			.rtl .ttfmake-dismiss {
				float: left;
			}
		</style>
	<?php
		foreach ( $notices as $id => $args ) {
			$message = $args['message'];
			$dismiss = $args['dismiss'];
			$type    = $args['type'];
			$nonce   = wp_create_nonce( 'ttfmake_dismiss_' . $id );

			require( $this->template );
		}
	}


	public function print_footer_scripts() {
		?>
		<script type="application/javascript">
			/* Make admin notices */
			/* <![CDATA[ */
			( function( $ ) {
				$('.notice').on('click', '.ttfmake-dismiss', function(evt) {
					evt.preventDefault();

					var $target = $(evt.target),
						$parent = $target.parents('.notice').first(),
						nonce   = $target.data('nonce'),
						id      = $parent.attr('id').replace('ttfmake-notice-', '');

					$.post(
						ajaxurl,
						{
							action : 'make_hide_notice',
							nid    : id,
							nonce  : nonce
						}
					).done(function(data) {
						if (1 === parseInt(data, 10)) {
							$parent.fadeOut('slow', function() {
								$(this).remove();
							});
						}
					});
				});
			} )( jQuery );
			/* ]]> */
		</script>
	<?php
	}


	public function handle_ajax() {
		// Check requirements
		if (
			! defined( 'DOING_AJAX' ) ||
			true !== DOING_AJAX ||
			! isset( $_POST['nid'] ) ||
			! isset( $_POST['nonce'] ) ||
			! wp_verify_nonce( $_POST['nonce'], 'ttfmake_dismiss_' . $_POST['nid'] )
		) {
			return;
		}

		// Get array of dismissed notices
		$user_id = get_current_user_id();
		$dismissed = get_user_meta( $user_id, 'ttfmake-dismissed-notices', true );
		if ( ! $dismissed ) {
			$dismissed = array();
		}

		// Add a new notice to the array
		$id = $_POST['nid'];
		$dismissed[] = $id;
		$success = update_user_meta( $user_id, 'ttfmake-dismissed-notices', $dismissed );

		// Return a success response.
		if ( $success ) {
			echo 1;
		}
		wp_die();
	}
}

/**
 * Instantiate or return the one TTFMAKE_Admin_Notice instance.
 *
 * @since  1.4.9.
 *
 * @return TTFMAKE_Admin_Notice
 */
function ttfmake_admin_notice() {
	return TTFMAKE_Admin_Notice::instance();
}

ttfmake_admin_notice()->init();


function ttfmake_register_admin_notice( $id, $message, $args ) {
	ttfmake_admin_notice()->register_admin_notice( $id, $message, $args );
}

endif;