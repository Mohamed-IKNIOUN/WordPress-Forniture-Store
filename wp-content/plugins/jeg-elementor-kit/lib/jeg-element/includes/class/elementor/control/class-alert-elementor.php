<?php
/**
 * Jeg News Element Elementor Alert
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Elementor\Control;

use Elementor\Base_Data_Control;

/**
 * Class Alert
 *
 * @package Jeg\Element\Elementor\Control
 */
class Alert_Elementor extends Base_Data_Control {
	/**
	 * Retrieve the control type.
	 */
	public function get_type() {
		return 'alert';
	}

	/**
	 * Control content template.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<div id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-input-wrapper type-alert">
				<div class="widget-alert alert-{{{ data.default }}}">
					<strong>{{{ data.label }}}</strong>
					<div class="alert-description">{{{ data.description }}}</div>
				</div>
			</div>
		</div>
		<?php
	}
}
