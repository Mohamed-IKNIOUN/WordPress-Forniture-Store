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
class Text extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'text';

	/**
	 * Input Type
	 *
	 * @var string
	 */
	protected $input_type = 'text';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-text" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<input class="widefat" id="{{ data.fieldID }}" name="{{ data.fieldName }}" autocomplete="off" type="<?php echo esc_attr( $this->input_type ); ?>" value="{{ data.value }}" />
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
