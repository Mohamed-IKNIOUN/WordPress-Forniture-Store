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

namespace Jeg\Form\Segment;

/**
 * Slider control (range).
 */
class Nowrap_Segment extends Segment_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'nowrap';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="jeg_metabox_normal_segment jeg_metabox_wrapper {{ data.id }} {{ data.context }}">
			<div class="jeg_metabox_body"></div>
		</div>
		<?php
	}
}
