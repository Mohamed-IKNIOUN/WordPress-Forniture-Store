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

namespace Jeg\Form\Field;

/**
 * Slider control (range).
 */
class Alert extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'alert';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-alert" data-field="{{ data.fieldID }}">
			<div class="widget-alert alert-{{ data.default }}" id="{{ data.fieldID }}" name="{{ data.fieldName }}">
				<strong>{{{ data.title }}}</strong>
				<div class="alert-description">{{{ data.description }}}</div>
			</div>
		</div>
		<?php
	}
}
