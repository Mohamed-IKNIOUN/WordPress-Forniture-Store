<?php
/**
 * Form field : Color
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Color control.
 */
class Color extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'color';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-color" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<input {{{ data.link }}} class="jeg-color-picker" type="text" id="{{ data.fieldID }}" name="{{ data.fieldName }}" data-alphaenabled="true" data-default-color="{{ data.default }}" value="{{ data.value }}"/>
				<input class="jeg-color-picker-clone" type="text" data-alphaenabled="true" data-default-color="{{ data.default }}" value="{{ data.value }}"/>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
