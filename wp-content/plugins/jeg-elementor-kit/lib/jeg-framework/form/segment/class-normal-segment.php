<?php
/**
 * Normal Segment
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Segment;

/**
 * Normal Segment
 */
class Normal_Segment extends Segment_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'normal';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="jeg_accordion_wrapper collapsible close widget_class {{ data.id }} jeg_metabox_wrapper {{ data.context }}">
			<div class="jeg_accordion_heading">
				<span class="jeg_accordion_title">{{ data.name }}</span>
				<span class="jeg_accordion_button"></span>
			</div>
			<div class="jeg_accordion_body" style="display: none"></div>
		</div>
		<?php
	}
}
