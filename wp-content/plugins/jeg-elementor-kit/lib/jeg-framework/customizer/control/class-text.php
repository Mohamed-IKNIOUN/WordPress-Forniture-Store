<?php
/**
 * Customizer Control: text.
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Customizer\Control;

/**
 * Slider control (range).
 */
class Text extends Control_Abstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jeg-text';

	/**
	 * The input type
	 *
	 * @access public
	 * @var string
	 */
	public $input_type = 'text';

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
				<input type="<?php echo esc_attr( $this->input_type ); ?>" {{{ data.link }}} value="{{ data.value }}"/>
			</div>
		</label>
		<?php
	}
}
