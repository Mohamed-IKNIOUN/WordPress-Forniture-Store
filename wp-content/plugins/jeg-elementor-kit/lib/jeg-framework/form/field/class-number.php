<?php
/**
 * Customizer Control: Number.
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Number Control.
 */
class Number extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'number';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-number" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<div class="wrapper">
					<input class="widefat" type="text" id="{{ data.fieldID }}" name="{{ data.fieldName }}" min="{{ data.options.min }}" max="{{ data.options.max }}" step="{{ data.options.step }}" value="{{ data.value }}" />
				</div>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
