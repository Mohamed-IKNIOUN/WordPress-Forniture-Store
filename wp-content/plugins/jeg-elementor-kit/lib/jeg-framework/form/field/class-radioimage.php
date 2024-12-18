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
class Radioimage extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'radioimage';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-radioimage" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<div id="{{ data.fieldID }}" class="radio-image-wrapper" type="radio-image">
					<# for(key in data.options) { #>
						<# var checked =  ( key == data.value ) ? 'checked' : ''; #>
						<label>
							<input {{{ data.link }}} type='radio' name="{{ data.fieldName }}" value="{{ key }}" class='radio-image-item radioimage_field' {{ checked }}  />
							<img src='{{ data.options[ key ] }}' class='radio-image'/>
						</label>
					<# } #>
				</div>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
