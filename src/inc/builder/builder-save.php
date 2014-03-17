<?php
/**
 * @package One
 */

if ( ! function_exists( 'TTF_One_Builder_Save' ) ) :
	/**
	 * Defines the functionality for the HTML Builder.
	 *
	 * @since 1.0.
	 */
	class TTF_One_Builder_Save {
		/**
		 * The one instance of TTF_One_Builder_Save.
		 *
		 * @since 1.0.
		 *
		 * @var   TTF_One_Builder_Save
		 */
		private static $instance;

		/**
		 * Holds the iterator for managing sections
		 *
		 * @since 1.0.
		 *
		 * @var   int    Current section number.
		 */
		private $_iterator = 0;

		/**
		 * A variable for tracking the current section being processed.
		 *
		 * @since 1.0.
		 *
		 * @var   int
		 */
		private $_current_section_number = 0;

		/**
		 * Instantiate or return the one TTF_One_Builder_Save instance.
		 *
		 * @since  1.0.
		 *
		 * @return TTF_One_Builder_Save
		 */
		public static function instance() {
			if ( is_null( self::$instance ) )
				self::$instance = new self();

			return self::$instance;
		}

		/**
		 * Initiate actions.
		 *
		 * @since  1.0.
		 *
		 * @return TTF_One_Builder_Save
		 */
		public function __construct() {
			add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

			// Combine the input into the post's content
			add_filter( 'wp_insert_post_data', array( $this, 'wp_insert_post_data' ), 30, 2 );
		}

		/**
		 * Save the gallery IDs and order.
		 *
		 * @since  1.0.
		 *
		 * @param  int        $post_id    The ID of the current post.
		 * @param  WP_Post    $post       The post object for the current post.
		 * @return void
		 */
		public function save_post( $post_id, $post ) {
			// Don't do anything during autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Only check permissions for pages since it can only run on pages
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

			// Verify that the page template param is set
			if ( ! isset( $_POST['page_template'] ) ) {
				return;
			}

			// Run the product builder routine maybe
			if ( isset( $_POST[ 'ttf-one-builder-nonce' ] ) && wp_verify_nonce( $_POST[ 'ttf-one-builder-nonce' ], 'save' ) ) {
				// Process and save data
				$sanitized_sections = $this->prepare_data();
				update_post_meta( $post_id, '_ttf-one-sections', $sanitized_sections );

				// Save the value of the hide/show header variable
				if ( isset( $_POST['ttf-one-hide-header'] ) ) {
					$value       = $_POST['ttf-one-hide-header'];
					$clean_value = ( in_array( $value, array( 0, 1 ) ) ) ? (int) $value : 0;

					// Only save it if necessary
					if ( 1 === $clean_value ) {
						update_post_meta( $post_id, '_ttf-one-hide-header', 1 );
					} else {
						delete_post_meta( $post_id, '_ttf-one-hide-header' );
					}
				} else {
					delete_post_meta( $post_id, '_ttf-one-hide-header' );
				}
			}
		}

		/**
		 * Validate and sanitize the builder section data.
		 *
		 * @since  1.0.
		 *
		 * @return array    Array of cleaned section data.
		 */
		public function prepare_data() {
			$sanitized_sections = array();

			if ( isset( $_POST['ttf-one-section'] ) ) {
				// Get section order
				$order = array();
				if ( isset( $_POST['ttf-one-section-order'] ) ) {
					$order = $this->process_order( $_POST['ttf-one-section-order'] );
				}

				// Process and save data
				$sanitized_sections = $this->process_section_data( $_POST['ttf-one-section'], $order );
			}

			return $sanitized_sections;
		}

		/**
		 * Interpret the order input into meaningful order data.
		 *
		 * @since  1.0.
		 *
		 * @param  string    $input    The order string.
		 * @return array               Array of order values.
		 */
		public function process_order( $input ) {
			$input = str_replace( 'ttf-one-section-', '', $input );
			return explode( ',', $input );
		}

		/**
		 * Process data for a single section.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data     The data for the section.
		 * @param  array    $order    The order for the section.
		 * @return array              Sanitized data.
		 */
		public function process_section_data( $data, $order ) {
			$sanitized_sections = array();

			foreach( $order as $section_number ) {
				if ( isset( $data[ $section_number ] ) && isset( $data[ $section_number ]['section-type'] ) ) {
					$section              = $data[ $section_number ];
					$section_type         = $section[ 'section-type' ];
					$sanitized_sections[] = call_user_func_array( array( $this, 'process_' . $section_type ), array( 'data' => $section ) );
				}
			}

			return $sanitized_sections;
		}

		/**
		 * Process the banner section data.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section's data.
		 * @return array             Sanitized data.
		 */
		public function process_banner( $data ) {
			$clean_data = array(
				'section-type' => 'banner'
			);

			if ( isset( $data['image-id'] ) ) {
				$clean_data['image-id'] = absint( $data['image-id'] );
			}

			if ( isset( $data['button-url'] ) ) {
				$clean_data['button-url'] = esc_url_raw( $data['button-url'] );
			}

			if ( isset( $data['button-text'] ) ) {
				$clean_data['button-text'] = sanitize_text_field( $data['button-text'] );
			}

			$clean_data['background-image'] = ( isset( $data['background-image'] ) && 1 === (int) $data['background-image'] ) ? 1 : 0;
			$clean_data['darken-image']     = ( isset( $data['darken-image'] ) && 1 === (int) $data['darken-image'] ) ? 1 : 0;

			if ( isset( $data['title'] ) ) {
				$clean_data['title'] = sanitize_text_field( $data['title'] );
			}

			if ( isset( $data['content'] ) ) {
				$clean_data['content'] = wp_filter_post_kses( $data['content'] );
			}

			if ( isset( $data['state'] ) ) {
				$clean_data['state'] = sanitize_key( $data['state'] );
			}

			return $clean_data;
		}

		/**
		 * Process the slide section data.
		 *
		 * Slides are identical to banner sections; however, the type is different and there is no background image. Instead
		 * of rewriting the routine, the banner routine is used and the two differences are handled in this function.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section's data.
		 * @return array             Sanitized data.
		 */
		public function process_slide( $data ) {
			$clean_data = $this->process_banner( $data );

			// There is no "background-image" option for slides
			unset( $clean_data['background-image'] );

			// Reset the section type value
			$clean_data['section-type'] = 'slide';

			return $clean_data;
		}

		/**
		 * Process the feature section data.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section's data.
		 * @return array             Sanitized data.
		 */
		public function process_feature( $data ) {
			$clean_data = array(
				'section-type' => 'feature'
			);

			if ( isset( $data['image-link'] ) ) {
				$clean_data['image-link'] = esc_url_raw( $data['image-link'] );
			}

			if ( isset( $data['image-id'] ) ) {
				$clean_data['image-id'] = absint( $data['image-id'] );
			}

			if ( isset( $data['title-link'] ) ) {
				$clean_data['title-link'] = esc_url_raw( $data['title-link'] );
			}

			if ( isset( $data['title'] ) ) {
				$clean_data['title'] = sanitize_text_field( $data['title'] );
			}

			if ( isset( $data['content'] ) ) {
				$clean_data['content'] = wp_filter_post_kses( $data['content'] );
			}

			if ( isset( $data['order'] ) ) {
				$clean_data['order'] = explode( ',', $data['order'] );
				array_map( 'sanitize_key', $clean_data['order'] );
			}

			if ( isset( $data['state'] ) ) {
				$clean_data['state'] = sanitize_key( $data['state'] );
			}

			return $clean_data;
		}

		/**
		 * Process the profile section data.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section's data.
		 * @return array             Sanitized data.
		 */
		public function process_profile( $data ) {
			$clean_data = array(
				'section-type' => 'profile'
			);

			// Gather the order of the columns in an array
			if ( isset( $data['order'] ) && ! empty( $data['order'] ) ) {
				$order = str_replace(
					array(
						'ttf-one-profile-',
						'-column'
					),
					array(
						'',
						''
					),
					$data['order']
				);

				// Turn into array and remove empty values
				$order = array_filter( explode( ',', $order ) );
			} else {
				$order = array(
					'left',
					'middle',
					'right'
				);
			}

			// Loop through the order array. Save each value from the corresponding column.
			$i = 0;
			foreach ( $order as $column ) {
				if ( 0 === $i ) {
					$which = 'left';
				} elseif ( 1 === $i ) {
					$which = 'middle';
				} else {
					$which = 'right';
				}

				if ( isset( $data[ $column ]['link'] ) ) {
					$clean_data[ $which ]['link'] = esc_url_raw( $data[ $column ]['link'] );
				}

				if ( isset( $data[ $column ]['image-id'] ) ) {
					$clean_data[ $which ]['image-id'] = absint( $data[ $column ]['image-id'] );
				}

				if ( isset( $data[ $column ]['title'] ) ) {
					$clean_data[ $which ]['title'] = sanitize_text_field( $data[ $column ]['title'] );
				}

				if ( isset( $data[ $column ]['content'] ) ) {
					$clean_data[ $which ]['content'] = wp_filter_post_kses( $data[ $column ]['content'] );
				}

				$i++;
			}

			if ( isset( $data['state'] ) ) {
				$clean_data['state'] = sanitize_key( $data['state'] );
			}

			return $clean_data;
		}

		/**
		 * Process the text section data.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section's data.
		 * @return array             Sanitized data.
		 */
		public function process_text( $data ) {
			$clean_data = array(
				'section-type' => 'text'
			);

			if ( isset( $data['title'] ) ) {
				$clean_data['title'] = sanitize_text_field( $data['title'] );
			}

			if ( isset( $data['content'] ) ) {
				$clean_data['content'] = wp_filter_post_kses( $data['content'] );
			}

			if ( isset( $data['state'] ) ) {
				$clean_data['state'] = sanitize_key( $data['state'] );
			}

			return $clean_data;
		}

		/**
		 * On post save, use a theme template to generate content from metadata.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data       The processed post data.
		 * @param  array    $postarr    The raw post data.
		 * @return array                Modified post data.
		 */
		public function wp_insert_post_data( $data, $postarr ) {
			$product_submit   = ( isset( $_POST[ 'ttf-one-builder-nonce' ] ) && wp_verify_nonce( $_POST[ 'ttf-one-builder-nonce' ], 'save' ) );

			if ( ! $product_submit ) {
				return $data;
			}

			// Don't do anything during autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $data;
			}

			// Only check permissions for pages since it can only run on pages
			if ( ! current_user_can( 'edit_page', get_the_ID() ) ) {
				return $data;
			}

			// Verify that the page template param is set
			if ( ! isset( $_POST['page_template'] ) || ! in_array( $_POST['page_template'], array( 'product.php', 'slideshow.php' ) ) ) {
				return $data;
			}

			// Run the product builder routine maybe
			$sanitized_sections = $this->prepare_data( 'product' );

			// The data has been deleted and can be removed
			if ( empty( $sanitized_sections ) ) {
				$data['post_content'] = '';
				return $data;
			}

			// Remove editor image constraints while rendering section data.
			add_filter( 'editor_max_image_size', array( &$this, 'remove_image_constraints' ) );

			// Start the output buffer to collect the contents of the templates
			ob_start();

			global $ttf_one_sanitized_sections;
			$ttf_one_sanitized_sections = $sanitized_sections;

			// Verify that the section counter is reset
			$this->_current_section_number = 0;

			// For each sections, render it using the template
			foreach ( $sanitized_sections as $section ) {
				global $ttf_one_section_data;
				$ttf_one_section_data = $section;

				// Get the template for the section
				get_template_part( '_section', $section['section-type'] );

				// Note the change in section number
				$this->_current_section_number++;

				// Cleanup the global
				unset( $GLOBALS['ttf_one_section_data'] );
			}

			// Cleanup the global
			unset( $GLOBALS['ttf_one_sanitized_sections'] );

			// Reset the counter
			$this->_current_section_number = 0;

			// Get the rendered templates from the output buffer
			$post_content = ob_get_clean();

			// Allow constraints again after builder data processing is complete.
			remove_filter( 'editor_max_image_size', array( &$this, 'remove_image_constraints' ) );

			// Sanitize and set the content
			$data['post_content'] = sanitize_post_field( 'post_content', $post_content, get_the_ID(), 'db' );

			return $data;
		}

		/**
		 * Allows image size to be saved regardless of the content width variable.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $dimensions    The default dimensions.
		 * @return array                   The modified dimensions.
		 */
		public function remove_image_constraints( $dimensions ) {
			return array( 9999, 9999 );
		}

		/**
		 * Get the next section's data.
		 *
		 * @since  1.0.
		 *
		 * @return array    The next section's data.
		 */
		public function get_next_section_data() {
			global $ttf_one_sanitized_sections;

			// Get the next section number
			$section_to_get = $this->_current_section_number + 1;

			// If the section does not exist, the current section is the last section
			if ( isset( $ttf_one_sanitized_sections[ $section_to_get ] ) ) {
				return $ttf_one_sanitized_sections[ $section_to_get ];
			} else {
				return array();
			}
		}

		/**
		 * Get the previous section's data.
		 *
		 * @since  1.0.
		 *
		 * @return array    The previous section's data.
		 */
		public function get_prev_section_data() {
			global $ttf_one_sanitized_sections;

			// Get the next section number
			$section_to_get = $this->_current_section_number - 1;

			// If the section does not exist, the current section is the last section
			if ( isset( $ttf_one_sanitized_sections[ $section_to_get ] ) ) {
				return $ttf_one_sanitized_sections[ $section_to_get ];
			} else {
				return array();
			}
		}

		/**
		 * Prepare the classes need for a section.
		 *
		 * Includes the name of the current section type, the next section type and the previous section type. It will also
		 * denote if a section is the first or last section.
		 *
		 * @since  1.0.
		 *
		 * @return string
		 */
		public function section_classes() {
			global $ttf_one_sanitized_sections;

			// Get the current section type
			$current = ( isset( $ttf_one_sanitized_sections[ $this->_current_section_number ]['section-type'] ) ) ? $ttf_one_sanitized_sections[ $this->_current_section_number ]['section-type'] : '';

			// Get the next section's type
			$next_data = $this->get_next_section_data();
			$next = ( ! empty( $next_data ) && isset( $next_data['section-type'] ) ) ? 'next-' . $next_data['section-type'] : 'last';

			// Get the previous section's type
			$prev_data = $this->get_prev_section_data();
			$prev = ( ! empty( $prev_data ) && isset( $prev_data['section-type'] ) ) ? 'prev-' . $prev_data['section-type'] : 'first';

			// Return the values as a single string
			return $prev . ' ' . $current . ' ' . $next;
		}

		/**
		 * Duplicate of "the_content" with custom filter name for generating content in builder templates.
		 *
		 * @since  1.0.
		 *
		 * @param  string    $content    The original content.
		 * @return void
		 */
		public function the_builder_content( $content ) {
			$content = apply_filters( 'ttf_one_the_builder_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			echo $content;
		}

		/**
		 * Get the order for a feature section.
		 *
		 * @since  1.0.
		 *
		 * @param  array    $data    The section data.
		 * @return array             The desired order.
		 */
		public function get_featured_section_order( $data ) {
			$order = array(
				'image' => 'left',
				'text'  => 'right',
			);

			if ( isset( $data['order'] ) ) {
				if ( isset( $data['order'][0] ) && false !== strpos( $data['order'][0], 'text' ) ) {
					$order = array(
						'image' => 'right',
						'text'  => 'left',
					);
				}
			}

			return $order;
		}
	}
endif;

/**
 * Instantiate or return the one TTF_One_Builder_Save instance.
 *
 * @since  1.0.
 *
 * @return TTF_One_Builder_Save
 */
function ttf_one_get_builder_save() {
	return TTF_One_Builder_Save::instance();
}

add_action( 'admin_init', 'ttf_one_get_builder_save' );