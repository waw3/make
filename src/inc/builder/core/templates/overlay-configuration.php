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
		$default_value = ( isset( $input['default'] ) ) ? isset( $input['default'] ) : '';
		$current_value = ( isset( $ttfmake_section_data['data'][ $input['name'] ] ) ) ? $ttfmake_section_data['data'][ $input['name'] ] : $default_value;

		switch( $input['type'] ) {
			case 'section-title':
				$placeholder = ( isset( $input['label'] ) ) ? ' placeholder="' . esc_attr( $input['label'] ) . '"' : '';
				$name        = 'name="' . $section_name . '[' . esc_attr( $input['name'] ) . ']"';
				$class       = ( isset( $input['class'] ) ) ? ' class="' . esc_attr( $input['class'] ) . '"' : '';
				$this_output = '<input' . $placeholder . $class .' type="text" ' . $name . ' value="' . $current_value . '" class="ttfmake-title ttfmake-section-header-title-input" autocomplete="off">';
				break;

			case 'select':
				if ( isset( $input['default'] ) && isset( $input['options'] ) ) {
					$id     = $section_name . '[' . $input['name'] . ']';
					$label  = ( isset( $input['label'] ) ) ? '<label for="' . $id . '">' . esc_html( $input['label'] ) . '</label>' : '';
					$class  = ( isset( $input['class'] ) ) ? ' class="' . esc_attr( $input['class'] ) . '"' : '';
					$select = '<select id="' . $id . '"' . $class .' name="' . $id . '">%s</select>';

					$options = '';

					foreach ( $input['options'] as $key => $value ) {
						$options .= '<option value="' . esc_attr( $key ) . '"' . selected( $key, $current_value, false ) . '>' . $value . '</option>';
					}

					$this_output = $label . sprintf( $select, $options );
				}
				break;

			case 'checkbox':
				$id          = $section_name . '[' . $input['name'] . ']';
				$label       = ( isset( $input['label'] ) ) ? '<label for="' . $id . '">' . esc_html( $input['label'] ) . '</label>' : '';
				$input       = '<input id="' . $id . '" type="checkbox" name="' . $id . '" value="1"' . checked( 1, $current_value, false ) . '>';
				$this_output = $label . $input;
				break;

			case 'text':
				$id          = $section_name . '[' . $input['name'] . ']';
				$label       = ( isset( $input['label'] ) ) ? '<label for="' . $id . '">' . esc_html( $input['label'] ) . '</label>' : '';
				$this_output = $label . '<input type="text" id="' . $id . '" name="' . $id . '" value="' . $current_value . '" />';
				break;

			case 'image':
				$name        = $section_name . '[' . $input['name'] . ']';
				$this_output = ttfmake_get_builder_base()->add_uploader( $name, $current_value );
				break;

			case 'color':
				$name        = $section_name . '[' . $input['name'] . ']';
				$class       = ( isset( $input['class'] ) ) ? ' class="' . esc_attr( $input['class'] ) . '"' : '';
				$this_output = '<input id="' . $name . '" type="text" name="' . $name . '" ' . $class . ' value="' . $current_value . '" />';
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
	$wrap = apply_filters( 'make_configuration_overlay_input_wrap', '<div class="ttfmake-configuration-overlay-input-wrap %1$s">%2$s</div>', $input, $ttfmake_section_data );

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

	if ( $input_html ) {
		$class   = ( isset( $input['class'] ) ) ? esc_attr( $input['class'] ) . '-wrap' : '';
		$output .= sprintf( $wrap, $class, $input_html );
	}
}

echo $output;

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );