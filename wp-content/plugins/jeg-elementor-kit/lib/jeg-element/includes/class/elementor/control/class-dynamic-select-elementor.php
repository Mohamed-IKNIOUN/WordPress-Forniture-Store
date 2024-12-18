<?php
/**
 * Jeg News Element Elementor Alert
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Elementor\Control;

use Elementor\Base_Data_Control;

/**
 * Class Alert
 *
 * @package Jeg\Element\Elementor\Control
 */
class Dynamic_Select_Elementor extends Base_Data_Control {
	/**
	 * Retrieve the control type.
	 */
	public function get_type() {
		return 'dynamic-select';
	}

	/**
	 * Control content template.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper type-select">
				<# if ( 1 < data.multiple || 'no' === data.multiple ) { #>
				<input id="<?php echo esc_attr( $control_uid ); ?>" type="text" class="tooltip-target input-sortable"
					title="{{ data.title }}"
					placeholder="{{ data.placeholder }}"
					data-retriever="{{ data.retriever }}"
					data-setting="{{ data.name }}"
					data-tooltip="{{ data.title }}"
					data-ajax="{{ data.ajax }}"
					data-slug="{{ data.slug }}"
					data-multiple="{{ ('no' === data.multiple) ? 1 : data.multiple }}"
					data-nonce="{{ data.nonce }}"/>
				<div class="data-option" style="display: none;">{{ data.options }}</div>
				<# } else { #>
					<select id="<?php echo esc_attr( $control_uid ); ?>" class="widefat" data-setting="{{ data.name }}" data-ajax="{{ data.ajax }}" data-nonce="{{ data.nonce }}">
						<# for ( key in data.options ) { #>
							<option value="{{ key }}">{{ data.options[ key ] }}</option>
							<# } #>
					</select>
					<# } #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<#
			(function ($) {
				window.open_control($('#<?php echo esc_attr( str_replace( '{{{ data._cid }}}', '', $control_uid ) ); ?>' + data._cid));
			})(jQuery);
		#>
		<?php
	}
}
