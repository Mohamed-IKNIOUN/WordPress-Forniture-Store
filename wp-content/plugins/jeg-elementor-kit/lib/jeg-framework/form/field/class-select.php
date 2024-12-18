<?php
/**
 * Form field : Select
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Select control
 */
class Select extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'select';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-dynamic-select" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<# if ( 1 < data.multiple ) { #>
					<input type="text" id="{{ data.fieldID }}" name="{{ data.fieldName }}" value="{{{ data.value }}}"/>
				<# } else { #>
					<select class="widefat" id="{{ data.fieldID }}" name="{{ data.fieldName }}">
						<# for ( key in data.options ) { #>
							<# var select = ( key == data.value ) ? 'selected' : ''; #>
							<option value="{{ key }}" {{ select }}>{{ data.options[ key ] }}</option>
						<# } #>
					</select>
				<# } #>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
