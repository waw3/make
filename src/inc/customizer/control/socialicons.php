<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Customizer_Control_SocialIcons
 *
 * Special control for managing social profile icons.
 *
 * @since x.x.x.
 */
class MAKE_Customizer_Control_SocialIcons extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	public $type = 'make_socialicons';

	/**
	 * Enqueue necessary scripts for this control.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	/**
	 * Add extra properties to JSON array.
	 *
	 * @since x.x.x.
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		$json['id'] = $this->id;
		$json['link'] = $this->get_link();
		$json['value'] = wp_json_encode( $this->value() );
		foreach ( $this->value() as $key => $value ) {
			$json['socialicons'][ $key ] = $value;
		}

		return $json;
	}

	/**
	 * Define the JS template for the control.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if (data.label) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="make-socialicons-container">
			<div class="make-socialicons-stage">
				<# _.each(data.socialicons.items, function(content) { #>
					<# if ('email' === content) { #>
						{{{ data.itemTemplate({ type: 'email' }) }}}
					<# } else if ('rss' === content) { #>
						{{{ data.itemTemplate({ type: 'rss' }) }}}
					<# } else { #>
						{{{ data.itemTemplate({ type: 'link', content: content }) }}}
					<# } #>
				<# }) #>
			</div>
			<div class="make-socialicons-buttons">
				<button id="add-icon_{{ data.id }}" class="button-secondary"><?php esc_html_e( 'Add icon', 'make' ); ?></button>
			</div>
			<div class="make-socialicons-options">
				<label for="email-toggle_{{ data.id }}">
					<input id="email-toggle_{{ data.id }}" data-name="email-toggle" type="checkbox"<# if (true == data.socialicons['email-toggle']) { #> checked="checked" <# } #> />
					<?php esc_html_e( 'Include email address icon', 'make' ); ?>
				</label>
				<label for="email-address_{{ data.id }}">
					<input id="email-address_{{ data.id }}" data-name="email-address" type="text" placeholder="<?php esc_html_e( 'Email address', 'make' ); ?>" value="{{ data.socialicons['email-address'] }}" />
				</label>
				<label for="rss-toggle_{{ data.id }}">
					<input id="rss-toggle_{{ data.id }}" data-name="rss-toggle" type="checkbox"<# if (true == data.socialicons['rss-toggle']) { #> checked="checked" <# } #> />
					<?php esc_html_e( 'Include RSS feed icon', 'make' ); ?>
				</label>
				<label for="rss-url_{{ data.id }}">
					<span class="description customize-control-description"><?php esc_html_e( 'Leave this field blank to use the WordPress default RSS feed.', 'make' ); ?></span>
					<input id="rss-url_{{ data.id }}" data-name="rss-url" type="text" placeholder="<?php esc_html_e( 'RSS feed address', 'make' ); ?>" value="{{ data.socialicons['rss-url'] }}" />
				</label>
				<label for="new-window_{{ data.id }}">
					<input id="new-window_{{ data.id }}" data-name="new-window" type="checkbox"<# if (true == data.socialicons['new-window']) { #> checked="checked" <# } #> />
					<?php esc_html_e( 'Open links in a new window', 'make' ); ?>
				</label>
			</div>
			<input id="input_{{ data.id }}" class="make-socialicons-value" type="text" value="{{ data.value }}" {{{ data.link }}} />
		</div>
	<?php
	}

	/**
     * Define the item sub-template for the control.
     *
     * @since x.x.x.
	 *
	 * @return void
     */
	protected function item_template() {
		?>
		<#
			var type    = ('undefined' === typeof data.type)    ? 'link' : data.type,
			    content = ('undefined' === typeof data.content) ? ''     : data.content;
		#>
		<div class="make-socialicons-item make-socialicons-item-{{ data.type }}" data-type="{{ data.type }}">
			<div class="make-socialicons-item-handle">
				<# if ('email' === type) { #>
					<i class="fa fa-envelope"></i>
				<# } else if ('rss' === type) { #>
					<i class="fa fa-rss"></i>
				<# } else { #>
					<i></i>
				<# } #>
			</div>
			<# if ('email' === type) { #>
				<span class="make-socialicons-item-content"><?php esc_html_e( 'Email', 'make' ); ?></span>
			<# } else if ('rss' === type) { #>
				<span class="make-socialicons-item-content"><?php esc_html_e( 'RSS', 'make' ); ?></span>
			<# } else { #>
				<input class="make-socialicons-item-content" type="text" value="{{ data.content }}" />
				<button class="make-socialicons-item-remove">
					<span class="screen-reader-text"><?php esc_html_e( 'Remove', 'make' ); ?></span>
					<span class="make-socialicons-item-remove-icon"></span>
				</button>
			<# } #>
		</div>
	<?php
	}

	/**
	 * Print additional JS templates.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function print_sub_templates() {
		?>
		<script type="text/html" id="tmpl-customize-control-<?php echo $this->type; ?>-item">
			<?php $this->item_template(); ?>
		</script>
		<?php
	}
}