<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Settings_SanitizeInterface
 *
 * @since 1.7.0.
 */
interface MAKE_Settings_SanitizeInterface extends MAKE_Util_ModulesInterface {
	public function sanitize_float( $value );

	public function sanitize_image( $value, $raw = false );

	public function sanitize_image_raw( $value );

	public function sanitize_text( $string );

	public function sanitize_title_for_frontend( $value );

	public function sanitize_title_for_ui( $title );

	public function sanitize_builder_section_choice( $value, $setting_id, MAKE_Builder_Model_SectionInstanceInterface $section_instance );

	public function sanitize_builder_section_content_for_frontend( $content );

	public function sanitize_builder_section_content_for_db( $content );

	public function sanitize_builder_section_content_for_ui( $content );

	public function sanitize_choice( $value, $setting_id );

	public function sanitize_font_choice( $value, $setting_id );
	
	public function sanitize_font_stack_cache( $value );

	public function sanitize_google_font_subset( $value );

	public function sanitize_socialicons( array $icon_data, $context = '' );

	public function sanitize_socialicons_from_customizer( $json );

	public function sanitize_socialicons_to_customizer( array $icon_data );
}