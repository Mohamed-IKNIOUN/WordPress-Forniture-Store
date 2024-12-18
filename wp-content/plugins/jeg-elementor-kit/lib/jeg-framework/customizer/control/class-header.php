<?php
/**
 * Customizer Control: Header
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Customizer\Control;

/**
 * Create a simple number control
 */
class Header extends Control_Abstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jeg-header';

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
			<# if ( data.label ) { #>
				<h2 class="customize-control-title" tabindex="">{{{ data.label }}}</h2>
			<# } #>
			<# if ( data.description ) { #>
				<em class="description customize-control-description">{{{ data.description }}}</em>
			<# } #>
		</label>
		<?php
	}
}
