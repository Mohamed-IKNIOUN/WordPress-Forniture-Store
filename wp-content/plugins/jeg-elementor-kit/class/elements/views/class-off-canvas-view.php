<?php
/**
 * Off Canvas View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.7.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

use Elementor\Plugin;

/**
 * Class Off_Canvas_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Off_Canvas_View extends View_Abstract {
	/**
	 * Build block content
	 *
	 * @return string
	 */
	public function build_content() {
		$toggle         = '';
		$toggle_item    = '';
		$class_toggle   = 'offcanvas-sidebar-button';
		$panel_position = ! empty( $this->attribute['st_panel_position'] ) ? esc_attr( $this->attribute['st_panel_position'] ) : 'right';
		$toggle_type    = esc_attr( $this->attribute['sg_setting_open_type'] );
		$close_icon     = $this->render_icon_element( $this->attribute['sg_setting_close_icon'] );
		$template       = Plugin::$instance->frontend->get_builder_content( $this->attribute['sg_setting_template'], true );
		$link_attr      = array(
			'url'               => '#',
			'is_external'       => '',
			'nofollow'          => '',
			'custom_attributes' => 'aria-label|Off Canvas Button',
		);

		if ( 'icon' === $toggle_type ) {
			$icon = $this->render_icon_element( $this->attribute['sg_setting_open_icon'] );

			if ( ! empty( $icon ) ) {
				$toggle_item = $icon;
			}
		} else {
			$toggle_item = esc_attr( $this->attribute['sg_setting_open_text'] );
		}

		if ( 'gradient' === $this->attribute['st_open_normal_background_background_background'] || 'gradient' === $this->attribute['st_open_hover_background_background_background'] ) {
			$class_toggle .= ' hover-gradient';
			$toggle_item   = '<span>' . $toggle_item . '</span>';
		}

		$toggle = $this->render_url_element( $link_attr, null, $class_toggle, $toggle_item );

		if ( ! empty( $close_icon ) ) {
			$class_close_button = 'offcanvas-close-button';

			if ( 'gradient' === $this->attribute['st_close_normal_background_background_background'] || 'gradient' === $this->attribute['st_close_hover_background_background_background'] ) {
				$class_close_button .= ' hover-gradient';
				$close_icon          = '<span>' . $close_icon . '</span>';
			}

			$close_icon = $this->render_url_element( $link_attr, null, $class_close_button, $close_icon );
		}

		$content =
		'<div class="toggle-wrapper">' . $toggle . '</div>
		<div class="offcanvas-sidebar position-' . $panel_position . '">
			<div class="bg-overlay"></div>
			<div class="sidebar-widget">
				<div class="widget-container">
					<div class="widget-heading">' . $close_icon . '</div>
					<div class="widget-content">' . $template . '</div>
				</div>
			</div>
		</div>';

		return $this->render_wrapper( 'off-canvas', $content );
	}
}
