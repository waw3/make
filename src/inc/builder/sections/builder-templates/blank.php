<?php
/**
 * @package Make
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

$keys = array(
	'title',
	'content',
);
$data = ttfmake_parse_section_data( $ttfmake_section_data['data'], $keys, 'blank' );
?>

	<div class="ttfmake-titlediv">
		<div class="ttfmake-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $data['title'] ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<?php
	$editor_settings = array(
		'tinymce'       => true,
		'quicktags'     => true,
		'editor_height' => 345,
		'textarea_name' => $section_name . '[content]'
	);

	if ( true === $ttfmake_is_js_template ) : ?>
		<?php ttfmake_get_builder_base()->wp_editor( '', ttfmake_get_wp_editor_id( $ttfmake_section_data, $ttfmake_is_js_template ), $editor_settings ); ?>
	<?php else : ?>
		<?php ttfmake_get_builder_base()->wp_editor( $data['content'], ttfmake_get_wp_editor_id( $ttfmake_section_data, $ttfmake_is_js_template ), $editor_settings ); ?>
	<?php endif; ?>

	<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $data['state'] ) ) echo esc_attr( $data['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();