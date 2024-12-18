<?php
/**
 * Form field : Checkbox
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Checkbox control
 */
class Checkbox extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'checkbox';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<# var checked = ( '1' == data.value ) ? 'checked' : ''; #>
		<div class="widget-wrapper type-checkbox" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label>{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<label class="checkbox-container" for="{{ data.fieldID }}">
					<input type="hidden" value="0" name="{{ data.fieldName }}">
					<input type="checkbox" class="checkbox" name="{{ data.fieldName }}" id="{{ data.fieldID }}" hidden value="1" {{ checked }}/>
					<span class="switch"></span>
				</label>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
