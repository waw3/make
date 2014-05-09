<?php
/**
 * @package Make
 */

global $ttfmake_section_data, $ttfmake_is_js_template, $ttfmake_slide_id;
$section_name = 'ttfmake-section';
if ( true === $ttfmake_is_js_template ) {
    $section_name .= '[{{{ parentID }}}][banner-slides][{{{ id }}}]';
} else {
    $section_name .= '[' . $ttfmake_section_data['data']['id'] . '][banner-slides][' . $ttfmake_slide_id . ']';
}

$keys = array(
	'content',
	'background-color',
	'darken',
	'image-id',
	'alignment'
);
$slide = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ] : array();
$data = ttfmake_parse_section_data( $slide, $keys, 'banner-slide' );

$state = ( isset( $data['state'] ) ) ? $data['state'] : 'open';
?>
<?php if ( true !== $ttfmake_is_js_template ) : ?>
<div class="ttfmake-banner-slide<?php if ( 'open' === $state ) echo ' ttfmake-banner-slide-open'; ?>" id="ttfmake-banner-slide-<?php echo esc_attr( $ttfmake_slide_id ); ?>" data-id="<?php echo esc_attr( $ttfmake_slide_id ); ?>">
<?php endif; ?>
    <div class="ttfmake-banner-slide-header">
        <h3>
            <em><?php _e( 'Slide', 'make' ); ?></em>
        </h3>
        <a href="#" class="ttfmake-banner-slide-toggle" title="<?php esc_attr_e( 'Click to toggle', 'make' ); ?>">
            <div class="handlediv"></div>
        </a>
    </div>

    <div class="clear"></div>

    <div class="ttfmake-banner-slide-body">

        <div class="ttfmake-banner-slide-option-wrapper">
            <h4><?php _e( 'Background image', 'make' ); ?></h4>
            <p>
                <input id="<?php echo $section_name; ?>[darken]" type="checkbox" name="<?php echo $section_name; ?>[darken]" value="1"<?php checked( $data['darken'] ); ?> />
                <label for="<?php echo $section_name; ?>[darken]">
                    <?php _e( 'Darken to improve readability', 'make' ); ?>
                </label>
            </p>

            <div class="ttfmake-banner-slide-background-color-wrapper">
                <h4><label for="<?php echo $section_name; ?>[background-color]"><?php _e( 'Background color', 'make' ); ?></label></h4>
                <input id="<?php echo $section_name; ?>[background-color]" type="text" name="<?php echo $section_name; ?>[background-color]" class="ttfmake-banner-slide-background-color" value="<?php echo maybe_hash_hex_color( $data['background-color'] ); ?>" />
            </div>

            <div class="ttfmake-banner-slide-alignment-wrapper">
                <h4><label for="<?php echo $section_name; ?>[alignment]"><?php _e( 'Content position:', 'make' ); ?></label></h4>
                <select id="<?php echo $section_name; ?>[alignment]" name="<?php echo $section_name; ?>[alignment]">
					<?php foreach ( ttfmake_get_section_choices( 'alignment', 'banner-slide' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['alignment'], 'alignment', 'banner-slide' ) ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
                </select>
            </div>

        </div>

        <div class="ttfmake-banner-slide-background-image-wrapper">
            <?php
            ttfmake_get_builder_base()->add_uploader(
                $section_name,
                ttfmake_sanitize_image_id( $data['image-id'] ),
                array(
                    'add'    => __( 'Set slide image', 'make' ),
                    'remove' => __( 'Remove slide image', 'make' ),
                    'title'  => __( 'Slide image', 'make' ),
                    'button' => __( 'Use as slide image', 'make' ),
                )
            );
            ?>
        </div>

        <div class="clear"></div>

        <h2>
            <?php _e( 'Slide content overlay', 'make' ); ?>
        </h2>

        <?php
        $editor_settings = array(
            'tinymce'       => true,
            'quicktags'     => true,
            'textarea_name' => $section_name . '[content]'
        );

        if ( true === $ttfmake_is_js_template ) : ?>
            <?php ttfmake_get_builder_base()->wp_editor( '', 'ttfmakeeditorbannerslidetemp', $editor_settings ); ?>
        <?php else : ?>
            <?php ttfmake_get_builder_base()->wp_editor( $data['content'], 'ttfmakeeditorbannerslide' . $ttfmake_slide_id, $editor_settings ); ?>
        <?php endif; ?>

        <a href="#" class="ttfmake-banner-slide-remove">
            <?php _e( 'Remove this slide', 'make' ); ?>
        </a>
    </div>
    <input type="hidden" class="ttfmake-banner-slide-state" name="<?php echo $section_name; ?>[state]" value="<?php echo esc_attr( $state ); ?>" />
<?php if ( true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>
