<?php
/**
 * Form field : Icon Picker
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Icon Picker control
 */
class Iconpicker extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'iconpicker';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-iconpicker" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<button class="btn btn-default iconpicker" id="{{ data.fieldID }}" name="{{ data.fieldName }}" data-iconset="fontawesome" data-icon="{{ data.value }}" data-bs-custom-class="iconpicker-popover jeg-iconpicker-popover" ></button>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
