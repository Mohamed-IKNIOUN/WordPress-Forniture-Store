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
class Heading extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'heading';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-heading" data-field="{{ data.fieldID }}">
			<div class="widget-heading">
				<h2>{{{ data.title }}}</h2>
			</div>
		</div>
		<?php
	}
}
