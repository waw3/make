<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Settings_Sanitize
 *
 * Methods for sanitizing setting values.
 *
 * @since 1.7.0.
 */
final class MAKE_Settings_Sanitize extends MAKE_Util_Modules implements MAKE_Settings_SanitizeInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
		'choices'       => 'MAKE_Choices_ManagerInterface',
		'font'          => 'MAKE_Font_ManagerInterface',
		'thememod'      => 'MAKE_Settings_ThemeModInterface',
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

		// Filters for sanitize_title_for_frontend
		add_filter( 'make_builder_section_title_frontend', 'wptexturize' );
		add_filter( 'make_builder_section_title_frontend', 'convert_chars' );
		add_filter( 'make_builder_section_title_frontend', 'trim' );

		// Filters for sanitize_title_for_ui
		add_filter( 'make_builder_section_title_ui', 'trim' );

		// Filters for sanitize_builder_section_content_for_frontend
		add_filter( 'make_the_builder_content', 'wpautop' );
		add_filter( 'make_the_builder_content', 'shortcode_unautop' );

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
	 * Sanitize a string to ensure that it is a float number.
	 *
	 * @since 1.5.0.
	 *
	 * @param  string|float    $value    The value to sanitize.
	 *
	 * @return float                     The sanitized value.
	 */
	public function sanitize_float( $value ) {
		return floatval( $value );
	}

	/**
	 * Sanitize the value of an image setting.
	 *
	 * If the given value is a URL instead of an attachment ID, this tries to find the URL's associated attachment.
	 *
	 * @since 1.7.0.
	 *
	 * @param      $value
	 * @param bool $raw
	 *
	 * @return int|string    The attachment ID, or a sanitized URL if the attachment can't be found.
	 */
	public function sanitize_image( $value, $raw = false ) {
		if ( is_string( $value ) && 0 === strpos( $value, 'http' ) ) {
			// Value is URL. Try to find the attachment ID.
			$find_attachment = attachment_url_to_postid( $value );
			if ( 0 !== $find_attachment ) {
				return $find_attachment;
			}

			// Attachment ID is unavailable. Return sanitized URL.
			if ( true === $raw ) {
				return esc_url_raw( $value );
			} else {
				return esc_url( $value );
			}
		} else {
			// Value is not URL. Treat as attachment ID.
			return absint( $value );
		}
	}

	/**
	 * Wrapper for using the sanitize_image method with raw set to true.
	 *
	 * @since 1.7.0.
	 *
	 * @param $value
	 *
	 * @return int|string
	 */
	public function sanitize_image_raw( $value ) {
		return $this->sanitize_image( $value, true );
	}

	/**
	 * Allow only certain tags and attributes in a string.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $string    The unsanitized string.
	 *
	 * @return string               The sanitized string.
	 */
	public function sanitize_text( $string ) {
		global $allowedtags;
		$expandedtags = $allowedtags;

		// span
		$expandedtags['span'] = array();

		// Enable id, class, and style attributes for each tag
		foreach ( $expandedtags as $tag => $attributes ) {
			$expandedtags[ $tag ]['id']    = true;
			$expandedtags[ $tag ]['class'] = true;
			$expandedtags[ $tag ]['style'] = true;
		}

		// br (doesn't need attributes)
		$expandedtags['br'] = array();

		/**
		 * Customize the tags and attributes that are allowed during text sanitization.
		 *
		 * @since 1.4.3
		 *
		 * @param array     $expandedtags    The list of allowed tags and attributes.
		 * @param string    $string          The text string being sanitized.
		 */
		$expandedtags = apply_filters( 'make_sanitize_text_allowed_tags', $expandedtags, $string );

		return wp_kses( $string, $expandedtags );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function sanitize_title_for_frontend( $value ) {
		/**
		 *
		 */
		return apply_filters( 'make_builder_section_title_frontend', $value );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function sanitize_title_for_ui( $value ) {
		/**
		 *
		 */
		return apply_filters( 'make_builder_section_title_ui', $value );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param mixed                                       $value
	 * @param string                                      $setting_id
	 * @param MAKE_Builder_Model_SectionInstanceInterface $section_instance
	 *
	 * @return mixed
	 */
	public function sanitize_builder_section_choice( $value, $setting_id, MAKE_Builder_Model_SectionInstanceInterface $section_instance ) {
		// Get the choice set ID.
		$choice_set_id = null;
		if ( $section_instance->setting_exists( $setting_id, 'choice_set_id' ) ) {
			$setting = $section_instance->get_setting( $setting_id );
			$choice_set_id = sanitize_key( $setting['choice_set_id'] );
		}

		// Sanitize the value.
		$sanitized_value = $this->choices()->sanitize_choice(
			$value,
			$choice_set_id,
			$section_instance->get_default( $setting_id )
		);

		return $sanitized_value;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function sanitize_builder_section_content_for_frontend( $content ) {
		// Check for deprecated filter.
		if ( has_filter( 'ttfmake_the_builder_content' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmake_the_builder_content',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_the_builder_content</code>'
				)
			);

			/**
			 * Filter the content used for "post_content" when the builder is used to generate content.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $content    The post content.
			 */
			$content = apply_filters( 'ttfmake_the_builder_content', $content );
		}

		/**
		 * Filter the content used for "post_content" when the builder is used to generate content.
		 *
		 * @since 1.2.3.
		 *
		 * @param string    $content    The post content.
		 */
		$content = apply_filters( 'make_the_builder_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function sanitize_builder_section_content_for_db( $content ) {
		$post_id = ( get_post() ) ? get_the_ID() : 0;

		$sanitized_content = sanitize_post_field(
			'post_content',
			$content,
			$post_id,
			'db'
		);

		return $sanitized_content;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function sanitize_builder_section_content_for_ui( $content ) {
		$post_id = ( get_post() ) ? get_the_ID() : 0;

		$sanitized_content = sanitize_post_field(
			'post_content',
			$content,
			$post_id,
			'edit'
		);

		return $sanitized_content;
	}

	/**
	 * Sanitize the value of a theme mod that has a choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @param mixed  $value         The value given to sanitize.
	 * @param string $setting_id
	 *
	 * @return mixed
	 */
	public function sanitize_choice( $value, $setting_id ) {
		// Sanitize the value.
		$sanitized_value = $this->choices()->sanitize_choice(
			$value,
			$this->thememod()->get_choice_set( $setting_id, true ),
			$this->thememod()->get_default( $setting_id )
		);

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_choice' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_choice',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Deprecated: Filter the sanitized value.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param mixed     $value      The sanitized value.
			 * @param string    $setting    The key for the setting.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_choice', $sanitized_value, $setting_id );
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize the value of a theme mod with a font family choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string $value
	 * @param  string $setting_id
	 *
	 * @return string
	 */
	public function sanitize_font_choice( $value, $setting_id ) {
		// Sanitize the value.
		$sanitized_value = $this->font()->sanitize_font_choice( $value, null, $this->thememod()->get_default( $setting_id ) );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_font_choice' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_choice',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Deprecated: Filter the sanitized font choice.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $value    The chosen font value.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_font_choice', $sanitized_value );
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize an array of font name/stack pairs.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $value
	 *
	 * @return array
	 */
	public function sanitize_font_stack_cache( $value ) {
		return array_filter( (array) $value, 'wp_strip_all_tags' );
	}

	/**
	 * Sanitize the value of the font-subset setting.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function sanitize_google_font_subset( $value ) {
		// Make sure the Google font source is available.
		if ( ! $this->font()->has_source( 'google' ) ) {
			return '';
		}

		$sanitized_value = $this->font()->get_source( 'google' )->sanitize_subset( $value, $this->thememod()->get_default( 'font-subset' ) );

		// Check for deprecated filter
		if ( has_filter( 'make_sanitize_font_subset' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_subset',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Filter the sanitized subset choice.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $value    The chosen subset value.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_font_subset', $value );
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize the social icons array and the individual items within it.
	 *
	 * @since 1.7.0.
	 *
	 * @param array  $icon_data
	 * @param string $context
	 *
	 * @return array
	 */
	public function sanitize_socialicons( array $icon_data, $context = '' ) {
		$sanitized_icon_data = array();

		// Options
		$settings = array_keys( $this->thememod()->get_settings( 'social_icon_option' ), true );
		foreach ( $settings as $setting_id ) {
			$option_id = str_replace( 'social-icons-', '', $setting_id );
			if ( isset( $icon_data[ $option_id ] ) ) {
				$sanitized_icon_data[ $option_id ] = $this->thememod()->sanitize_value( $icon_data[ $option_id ], $setting_id, $context );
			} else {
				$sanitized_icon_data[ $option_id ] = $this->thememod()->get_default( $setting_id );
			}
		}

		// Items
		if ( isset( $icon_data['items'] ) && is_array( $icon_data['items'] ) ) {
			$raw_items = $icon_data['items'];
		} else {
			$raw_items = array();
		}
		$sanitized_icon_data['items'] = array();
		foreach ( $raw_items as $key => $item ) {
			$item = wp_parse_args( (array) $item, array( 'type' => '', 'content' => '' ) );
			$sanitized_icon_data['items'][ $key ] = array();
			$sanitized_icon_data['items'][ $key ]['type'] = $type = $this->thememod()->sanitize_value( $item['type'], 'social-icons-item-type', $context );
			$sanitized_icon_data['items'][ $key ]['content'] = $this->thememod()->sanitize_value( $item['content'], 'social-icons-item-content-' . $type, $context );
		}

		// Email item
		if ( true === $sanitized_icon_data[ 'email-toggle' ] && ! in_array( 'email', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			array_push(
				$sanitized_icon_data['items'],
				array(
					'type'    => 'email',
					'content' => $this->thememod()->get_default( 'social-icons-item-content-email' ),
				)
			);
		} else if ( true !== $sanitized_icon_data[ 'email-toggle' ] && $key = array_search( 'email', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			unset( $sanitized_icon_data['items'][ $key ] );
		}

		// RSS item
		if ( true === $sanitized_icon_data[ 'rss-toggle' ] && ! in_array( 'rss', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			array_push(
				$sanitized_icon_data['items'],
				array(
					'type'    => 'rss',
					'content' => $this->thememod()->get_default( 'social-icons-item-content-rss' ),
				)
			);
		} else if ( true !== $sanitized_icon_data[ 'rss-toggle' ] && $key = array_search( 'rss', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			unset( $sanitized_icon_data['items'][ $key ] );
		}

		return $sanitized_icon_data;
	}

	/**
	 * Convert the social icons JSON string into an array and sanitize it for storage in the database.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $json
	 *
	 * @return array
	 */
	public function sanitize_socialicons_from_customizer( $json ) {
		$value = json_decode( $json, true );
		return $this->sanitize_socialicons( $value, 'from_customizer' );
	}

	/**
	 * Sanitize the social icons array from the database and then convert to JSON for use in the Customizer.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $icon_data
	 *
	 * @return bool|false|string
	 */
	public function sanitize_socialicons_to_customizer( array $icon_data ) {
		$value = $this->sanitize_socialicons( $icon_data, 'to_customizer' );
		return wp_json_encode( $value );
	}
}