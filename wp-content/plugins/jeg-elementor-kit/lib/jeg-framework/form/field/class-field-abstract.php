<?php
/**
 * Form Field
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Field control abstract.
 */
abstract class Field_Abstract {

	/**
	 * Form Control Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'text';

	/**
	 * Render the control's JS template.
	 */
	public function render_template() {
		?>
		<script type="text/html" id="tmpl-form-field-<?php echo esc_attr( $this->type ); ?>">
			<?php $this->js_template(); ?>
		</script>
		<?php
	}

	/**
	 * An Underscore (JS) template for this control's content
	 */
	abstract public function js_template();
}
