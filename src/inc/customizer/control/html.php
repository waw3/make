<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Customizer_Control_Html
 *
 * JS-based control for adding arbitrary HTML to Customizer sections. Is the successor to TTFMAKE_Customize_Misc_Control
 *
 * @since x.x.x.
 */
class MAKE_Customizer_Control_Html extends WP_Customize_Control {
	/**
	 * The current setting name.
	 *
	 * This is a hack, since the HTML control is not actually associated with any settings. It must be linked to a valid
	 * setting before it will render, however.
	 *
	 * @since x.x.x.
	 *
	 * @var   string    The current setting name.
	 */
	public $settings = 'make-customize-control-html';

	/**
	 * The control type.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	public $type = 'make_html';

	/**
	 * The HTML to display with the control.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	public $html = '';

	/**
	 * Add extra properties to JSON array.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['html'] = $this->html;
	}

	/**
	 * Define the JS template for the control.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	protected function content_template() { ?>
		<label>
			<# if (data.label) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if (data.description) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<# if (data.html) { #>
				<div class="make-customize-control-html-container">
					{{{ data.html }}}
				</div>
			<# } #>
		</label>
	<?php }
}