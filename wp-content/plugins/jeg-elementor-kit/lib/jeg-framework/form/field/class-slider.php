<?php
/**
 * Form field : Slider
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Slider control
 */
class Slider extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'slider';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-slider" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<div class="wrapper">
					<input {{data.link}} class="jeg-number-range" type="range" id="{{ data.fieldID }}" name="{{ data.fieldName }}" min="{{ data.options.min }}" max="{{ data.options.max }}" step="{{ data.options.step }}" value="{{ data.value }}" data-reset_value="{{ data.default }}" />
					<div class="jeg_range_value">
						<span class="value">{{{ data.value }}}</span>
					</div>
					<div class="jeg-slider-reset">
						<span class="dashicons dashicons-image-rotate"></span>
					</div>
				</div>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
