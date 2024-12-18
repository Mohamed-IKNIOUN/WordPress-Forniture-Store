<?php
/**
 * Customizer Control: color.
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Customizer\Control;

/**
 * Adds a color & color-alpha control
 *
 * @see https://github.com/23r9i0/wp-color-picker-alpha
 */
class Color extends Control_Abstract {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jeg-color';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @var bool
	 */
	public $palette = true;


	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$this->json['palette']  = $this->palette;
		$this->choices['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div>
				<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default }}" data-alphaenabled="{{ data.choices['alpha'] }}" value="{{ data.value }}" class="jeg-color-control" {{{ data.link }}} />
			</div>
		</label>
		<?php
	}
}
