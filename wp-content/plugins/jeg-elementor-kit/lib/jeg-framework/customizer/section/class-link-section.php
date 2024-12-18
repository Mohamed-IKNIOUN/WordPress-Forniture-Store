<?php
/**
 * @author      Jegtheme
 * @license     https://opensource.org/licenses/MIT
 */

namespace Jeg\Customizer\Section;

use Error;

class Link_Section extends Default_Section {
	const TYPE = 'link';

	/**
	 * Type of control, used by JS.
	 *
	 * @access public
	 * @var string
	 */
	public $type = self::TYPE;

	public $url = '';

	public $label = '';

	/**
	 * Render the panel's JS templates.
	 *
	 * This function is only run for panel types that have been registered with
	 * WP_Customize_Manager::register_panel_type().
	 *
	 * @see WP_Customize_Manager::register_panel_type()
	 */
	public function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand {{ data.additional_class }}">
			<h3 class="accordion-section-title">
				<a href="{{{ data.url }}}" target="_blank" data-label="{{ data.label }}">
					<span>{{ data.title }}</span>
					<# if ( 'string' === typeof data.additional_class && 'locked' === data.additional_class ) { #>
						<button class="activate-license" >Activate</button>
					<# } #>
				</a>
			</h3>
		</li>
		<?php
	}

	/**
	 * Export data to JS.
	 *
	 * @return array
	 */
	public function json() {
		$data                     = parent::json();
		$data['url']              = esc_url( $this->url );
		$data['additional_class'] = 'activate-license' === $this->url ? 'locked' : '';
		$data['url']              = ! empty( $data['additional_class'] ) ? esc_url( get_admin_url() ) : $data['url'];

		return $data;
	}
}
