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

namespace Jeg\Form\Segment;

/**
 * Slider control (range).
 */
class Tabbed_Segment extends Segment_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'tabbed';

	/**
	 * Render the control's JS template.
	 */
	public function render_template() {
		?>
		<script type="text/html" id="tmpl-form-segment-<?php echo esc_attr( $this->type ); ?>">
			<?php $this->js_template(); ?>
		</script>
		<script type="text/html" id="tmpl-form-segment-<?php echo esc_attr( $this->type ); ?>-tab">
			<?php $this->tab_js_template(); ?>
		</script>
		<?php
	}

	/**
	 * An Underscore (JS) template for this segment's content
	 */
	public function js_template() {
		?>
		<# var active = ( data.index === 0 ) ? 'active' : ''; #>
		<div class="jeg_tabbed_body {{ data.id }} {{ active }} jeg_metabox_wrapper {{ data.context }}" id="{{ data.id }}">
			<div class="jeg_metabox_body"></div>
		</div>
		<?php
	}

	/**
	 * An Underscore (JS) template for this segment tab content
	 */
	public function tab_js_template() {
		?>
		<# var active = ( data.index === 0 ) ? 'active' : ''; #>
		<li href="#{{ data.id }}" class="{{ active }}"><span>{{ data.name }}</span></li>
		<?php
	}
}
