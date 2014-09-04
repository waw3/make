<?php
global $ttfmake_overlay_id, $ttfmake_section_data, $ttfmake_is_js_template;
$ttfmake_overlay_id = 'ttfmake-configuration-overlay';
$section_name       = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

// Include the header
get_template_part( '/inc/builder/core/templates/overlay', 'header' );

// Sort the config in case 3rd party code added another input
ksort( $ttfmake_section_data['section']['config'], SORT_NUMERIC );

// Print the inputs
$output = '';
foreach ( $ttfmake_section_data['section']['config'] as $input ) {
	$this_output = '';

	if ( isset( $input['type'] ) && isset( $input['name'] ) ) {
		switch( $input['type'] ) {
			case 'section-title':
				$placeholder = ( isset( $input['label'] ) ) ? ' placeholder="' . esc_attr( $input['label'] ) . '"' : '';
				$name        = 'name="' . $section_name . '[' . esc_attr( $input['name'] ) . ']"';
				$this_output = '<input' . $placeholder . ' type="text" ' . $name . ' class="ttfmake-title ttfmake-section-header-title-input" value="" autocomplete="off">';
				break;

			case 'select':
				if ( isset( $input['default'] ) && isset( $input['options'] ) ) {
					$id     = $section_name . '[' . $input['name'] . ']';
					$label  = ( isset( $input['label'] ) ) ? '<label for="' . $id . '">' . esc_html( $input['label'] ) . ':</label>' : '';
					$select = '<select id="' . $id . '" class="ttfmake-text-columns" name="' . $id . '">%s</select>';

					$options = '';

					foreach ( $input['options'] as $key => $value ) {
						$options .= '<option value="' . esc_attr( $key ) . '">' . $value . '</option>';
					}

					$this_output = $label . sprintf( $select, $options );
				}
				break;
		}
	}

	/**
	 * Filter the wrapped used for the inputs.
	 *
	 * @since 1.4.0.
	 *
	 * @param string    $wrapper                 The HTML to wrap around the input.
	 * @param string    $input                   The input data that is wrapped.
	 * @param string    $ttfmake_section_data    The data for the section.
	 */
	$wrap  = apply_filters( 'make_configuration_overlay_input_wrap', '<div class="ttfmake-configuration-overlay-input-wrap">%s</div>', $input, $ttfmake_section_data );

	/**
	 * Filter the HTML for the input.
	 *
	 * @since 1.4.0.
	 *
	 * @param string    $this_output             The HTML for the input.
	 * @param string    $input                   The input data.
	 * @param string    $ttfmake_section_data    The data for the section.
	 */
	$input_html = apply_filters( 'make_configuration_overlay_input', $this_output, $input, $ttfmake_section_data );

	$output .= sprintf( $wrap, $input_html );
}

echo $output;

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );