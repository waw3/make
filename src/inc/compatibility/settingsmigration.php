<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Compatibility_SettingsMigration
 * 
 * @since 1.7.0.
 */
class MAKE_Compatibility_SettingsMigration extends MAKE_Util_Modules implements MAKE_Compatibility_SettingsMigrationInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'notice' => 'MAKE_Admin_NoticeInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Admin notice
		add_action( 'make_notice_loaded', array( $this, 'admin_notice' ) );

		// Admin page
		add_action( 'admin_menu', array( $this, 'add_page' ) );

		// Admin post processing
		add_action( 'admin_post_make-settings-migration', array( $this, 'admin_post' ) );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Add an admin notice if a child theme is activated an the parent has settings.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKE_Admin_NoticeInterface $notice
	 *
	 * @return bool
	 */
	public function admin_notice( MAKE_Admin_NoticeInterface $notice ) {
		// Only run this in the proper hook context.
		if ( 'make_notice_loaded' !== current_action() ) {
			return false;
		}

		// Theme mods
		$parent_mods = get_option( 'theme_mods_' . get_template(), array() );

		// Only register the notice if the parent has settings
		if ( is_child_theme() && ! empty( $parent_mods ) ) {
			return $notice->register_admin_notice(
				'make-child-import-mods',
				sprintf(
					__( 'You\'ve activated a child theme! It looks like the parent theme\'s settings have previously been configured in the Customizer. Would you like to <a href="%s">import these settings into the child theme</a>?', 'make' ),
					menu_page_url( 'make-settings-migration', false )
				),
				array(
					'cap'     => 'edit_theme_options',
					'dismiss' => true,
					'screen'  => array( 'dashboard', 'themes' ),
					'type'    => 'info',
				)
			);
		}

		return false;
	}

	/**
	 * Add an Appearance submenu page to manage setting migrations.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function add_page() {
		// Only run this in the proper hook context.
		if ( 'admin_menu' !== current_action() ) {
			return;
		}

		// Don't add the page if this isn't a child theme.
		if ( ! is_child_theme() ) {
			return;
		}

		add_theme_page(
			__( 'Migrate Settings', 'make' ),
			__( 'Migrate Settings', 'make' ),
			'edit_theme_options',
			'make-settings-migration',
			array( $this, 'page_content' )
		);
	}

	/**
	 * Render the Migrate Theme Settings page
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function page_content() {
		// Only run this in the proper hook context.
		if ( 'appearance_page_make-settings-migration' !== current_action() ) {
			return;
		}

		// Theme mods
		$parent_mods = get_option( 'theme_mods_' . get_template(), array() );

		// Backup mods
		$child_mods_backup = get_option( 'backup_theme_mods_' . get_stylesheet(), array() );

		// Display page content
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Migrate Theme Settings', 'make' ); ?></h1>
		</div>

		<p><?php esc_html_e( '
			This site is currently using a child theme of Make. The parent theme has previously configured settings that
			do not automatically carry over to the child theme.
		', 'make' );?></p>

		<h2><?php esc_html_e( 'Import settings from the parent theme', 'make' ); ?></h2>
		<?php if ( ! empty( $parent_mods ) ) : ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<fieldset>
					<p><?php echo wp_kses( __( '<strong>Notice:</strong> This will modify your database!', 'make' ), array( 'strong' => true ) );?></p>
					<label>
						<input type="checkbox" name="make-settings-migration[verify]" />
						<?php esc_html_e( 'I have backed up my database.', 'make' ); ?>
					</label>
					<input type="hidden" name="action" value="make-settings-migration" />
					<input type="hidden" name="make-settings-migration[action]" value="import" />
					<?php wp_nonce_field( 'import', 'make-settings-migration[nonce]' ); ?>
				</fieldset>
				<p class="submit">
					<input type="submit" class="button button-primary" name="make-settings-migration[submit]" value="<?php esc_attr_e( 'Import', 'make' ); ?>" />
				</p>
			</form>
		<?php else : ?>
			<p><?php esc_html_e( 'There are no parent theme settings to import.', 'make' ); ?></p>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Restore previous child theme settings', 'make' ); ?></h2>
		<?php if ( ! empty( $child_mods_backup ) ) : ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<fieldset>
					<p><?php echo wp_kses( __( '<strong>Notice:</strong> This will modify your database!', 'make' ), array( 'strong' => true ) );?></p>
					<label>
						<input type="checkbox" name="make-settings-migration[verify]" />
						<?php esc_html_e( 'I have backed up my database.', 'make' ); ?>
					</label>
					<input type="hidden" name="action" value="make-settings-migration" />
					<input type="hidden" name="make-settings-migration[action]" value="restore" />
					<?php wp_nonce_field( 'restore', 'make-settings-migration[nonce]' ); ?>
				</fieldset>
				<p class="submit">
					<input type="submit" class="button button-primary" name="make-settings-migration[submit]" value="<?php esc_attr_e( 'Restore', 'make' ); ?>" />
				</p>
			</form>
		<?php else : ?>
			<p><?php esc_html_e( 'There is no backup of child theme settings to restore.', 'make' ); ?></p>
		<?php endif; ?>
	<?php
	}

	/**
	 * Process post data from the Migrate Theme Settings page
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function admin_post() {
		// Only run this in the proper hook context.
		if ( 'admin_post_make-settings-migration' !== current_action() ) {
			return;
		}

		// Process form submissions
		if ( isset( $_POST['make-settings-migration'] ) ) {
			$args = $_POST['make-settings-migration'];

			// User verifies database backup
			if ( ! isset( $args['verify'] ) ) {
				$this->notice()->register_one_time_admin_notice(
					sprintf(
						'%1$s %2$s',
						esc_html__( 'Please verify that you have backed up your database.', 'make' ),
						esc_html__( 'No settings migration has taken place.', 'make' )
					),
					wp_get_current_user(),
					array(
						'type' => 'error'
					)
				);
			}
			// Validate action
			else if ( ! isset( $args['action'] ) || ! in_array( $args['action'], array( 'import', 'restore' ) ) ) {
				$this->notice()->register_one_time_admin_notice(
					sprintf(
						'%1$s %2$s',
						esc_html__( 'Invalid action.', 'make' ),
						esc_html__( 'No settings migration has taken place.', 'make' )
					),
					wp_get_current_user(),
					array(
						'type' => 'error'
					)
				);
			}
			// Validate nonce
			else if ( ! isset( $args['nonce'] ) || ! wp_verify_nonce( $args['nonce'], $args['action'] ) ) {
				$this->notice()->register_one_time_admin_notice(
					sprintf(
						'%1$s %2$s',
						esc_html__( 'Cheatin&#8217; uh?', 'make' ),
						esc_html__( 'No settings migration has taken place.', 'make' )
					),
					wp_get_current_user(),
					array(
						'type' => 'error'
					)
				);
			}
			// Everything validated, do a migration
			else {
				switch ( $args['action'] ) {
					case 'import' :
						$this->import();
						break;

					case 'restore' :
						$this->restore();
						break;
				}
			}

			// Redirect back to the migration page after completing the migration
			$url = add_query_arg( 'page', 'make-settings-migration', admin_url( 'themes.php' ) );
			wp_safe_redirect( $url );
		}
	}

	/**
	 * Routine to import parent theme settings into the child theme
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	private function import() {
		// Theme mods
		$parent_mods = get_option( 'theme_mods_' . get_template(), array() );
		$child_mods = get_option( 'theme_mods_' . get_stylesheet(), array() );

		// Bail if there are no parent theme mods to import
		if ( empty( $parent_mods ) ) {
			$this->notice()->register_one_time_admin_notice(
				esc_html__( 'No parent theme settings were found to import.', 'make' ),
				wp_get_current_user(),
				array(
					'type' => 'error'
				)
			);

			return;
		}

		// Messages
		$backed_up = '';

		// Backup existing child theme mods
		if ( ! empty( $child_mods ) ) {
			update_option( 'backup_theme_mods_' . get_stylesheet(), $child_mods, false );
			$backed_up = __( 'Existing child theme settings were backed up.', 'make' );
		}

		// Copy over the parent theme mods
		$status = update_option( 'theme_mods_' . get_stylesheet(), $parent_mods );

		// Add status notice
		if ( $status ) {
			$this->notice()->register_one_time_admin_notice(
				trim( sprintf(
					'%1$s %2$s',
					esc_html__( 'The parent theme settings were imported!', 'make' ),
					$backed_up
				) ),
				wp_get_current_user(),
				array(
					'type' => 'success'
				)
			);
		} else {
			$this->notice()->register_one_time_admin_notice(
				esc_html__( 'The import process failed.', 'make' ),
				wp_get_current_user(),
				array(
					'type' => 'error'
				)
			);
		}
	}

	/**
	 * Routine to restore a backup of child theme settings.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	private function restore() {
		// Theme mods
		$child_mods = get_option( 'theme_mods_' . get_stylesheet(), array() );

		// Backup mods
		$child_mods_backup = get_option( 'backup_theme_mods_' . get_stylesheet(), array() );

		// Bail if there is no backup to restore
		if ( empty( $child_mods_backup ) ) {
			$this->notice()->register_one_time_admin_notice(
				esc_html__( 'No child theme settings backup was found to restore.', 'make' ),
				wp_get_current_user(),
				array(
					'type' => 'error'
				)
			);

			return;
		}

		// Messages
		$backed_up = '';

		// Copy over the backup theme mods
		$status = update_option( 'theme_mods_' . get_stylesheet(), $child_mods_backup );

		// Backup existing child theme mods, if the restore was successful
		if ( $status && ! empty( $child_mods ) ) {
			update_option( 'backup_theme_mods_' . get_stylesheet(), $child_mods, false );
			$backed_up = __( 'Existing child theme settings were backed up.', 'make' );
		}

		// Add status notice
		if ( $status ) {
			$this->notice()->register_one_time_admin_notice(
				trim( sprintf(
					'%1$s %2$s',
					esc_html__( 'The child theme settings backup was restored!', 'make' ),
					$backed_up
				) ),
				wp_get_current_user(),
				array(
					'type' => 'success'
				)
			);
		} else {
			$this->notice()->register_one_time_admin_notice(
				sprintf(
					'%1$s %2$s',
					esc_html__( 'The restore process failed.', 'make' ),
					esc_html__( 'No settings migration has taken place.', 'make' )
				),
				wp_get_current_user(),
				array(
					'type' => 'error'
				)
			);
		}
	}
}