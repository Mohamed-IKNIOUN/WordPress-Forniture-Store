<?php
/**
 * Tabs View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.8.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

use Elementor\Plugin;

/**
 * Class Tabs_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Tabs_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$lists   = $this->attribute['sg_content_list'];
		$nav     = $this->render_nav( $lists );
		$content = $this->render_content( $lists );

		return $this->render_wrapper( 'tabs', $nav . $content, array( 'layout-' . esc_attr( $this->attribute['sg_general_layout'] ) ) );
	}

	/**
	 * Render Navigation
	 *
	 * @param array $lists Content lists.
	 */
	public function render_nav( $lists ) {
		$nav           = '';
		$caret         = 'yes' === $this->attribute['st_caret_enable'] ? 'caret-on' : '';
		$icon_enable   = 'yes' === $this->attribute['sg_general_icon_enable'];
		$toggle_tab    = 'yes' === $this->attribute['sg_general_toggle_tab_enable'] ? 'toggle-tab' : '';
		$icon_position = $icon_enable ? 'icon-position-' . esc_attr( $this->attribute['sg_general_icon_position'] ) : '';
		$animation     = isset( $this->attribute['sg_general_animation'] ) ? esc_attr( $this->attribute['sg_general_animation'] ) : '';

		foreach ( $lists as $list ) {
			$active      = 'yes' === $list['sg_content_set_default'] ? 'active' : '';
			$title       = '<span class="tab-title">' . esc_attr( $list['sg_content_list_title'] ) . '</span>';
			$description = '<div class="tab-description">' . $list['sg_content_list_description'] . '</div>';
			$tab_id      = 'tab-' . esc_attr( $list['_id'] );
			$icon_type   = $list['sg_content_icon_type'];
			$button      = '';
			$tab_class   = 'tab-nav ' . $active . ' ' . $toggle_tab;

			if ( 'yes' === $list['sg_content_list_button'] ) {
				$url            = $list['sg_content_list_button_link'];
				$class          = 'tab-button';
				$content_button = '<span>' . $list['sg_content_list_button_text'] . '</span>' . $this->render_icon_element( $list['sg_content_list_button_icon'] );
				$button         = $this->render_url_element( $url, null, $class, $content_button );
			}

			$content = '<div class="tab-content">' . $description . $button . '</div>';

			if ( $icon_enable ) {
				if ( 'icon' === $icon_type ) {
					if ( 'icon-position-after' === $icon_position ) {
						$title = $title . $this->render_icon_element( $list['sg_content_icon'] );
					} else {
						$title = $this->render_icon_element( $list['sg_content_icon'] ) . $title;
					}
				} elseif ( 'image' === $icon_type ) {
					if ( 'icon-position-after' === $icon_position ) {
						$title = $title . $this->render_image_element( $list['sg_content_image'], $list['sg_content_image_size_imagesize_size'] );
					} else {
						$title = $this->render_image_element( $list['sg_content_image'], $list['sg_content_image_size_imagesize_size'] ) . $title;
					}
				}
			}

			$nav_item = $title . $content;

			if ( 'gradient' === $this->attribute['st_tab_normal_background_background_background'] || 'gradient' === $this->attribute['st_tab_hover_background_background_background'] || 'gradient' === $this->attribute['st_tab_active_background_background_background'] ) {
				$tab_class .= ' hover-gradient';
				$nav_item   = '<span>' . $nav_item . '</span>';
			}

			$nav .= '<li class="' . $tab_class . '" data-tab="' . $tab_id . '">' . $nav_item . '</li>';
		}

		$nav = '<div class="tab-navigation"><ul class="tab-nav-list ' . $icon_position . ' ' . $animation . ' ' . $caret . '" data-toggle="' . esc_attr( $this->attribute['sg_general_toggle_tab_enable'] ) . '">' . $nav . '</ul></div>';

		return $nav;
	}

	/**
	 * Render Content
	 *
	 * @param array $lists Content list.
	 */
	public function render_content( $lists ) {
		$content = '';

		foreach ( $lists as $list ) {
			$active       = 'yes' === $list['sg_content_set_default'] ? 'active' : '';
			$content_type = $list['sg_content_type'];
			$tab_id       = 'tab-' . esc_attr( $list['_id'] );

			if ( 'content' === $content_type ) {
				$content .= '<div class="tab-content ' . $tab_id . ' ' . $active . '">' . wp_kses_post( $list['sg_content_text'] ) . '</div>';
			} elseif ( 'template' === $content_type ) {
				$available_templates = jkit_get_elementor_saved_template_option();

				if ( ! empty( $available_templates ) && array_key_exists( $list['sg_content_template'], $available_templates ) ) {
					$template = Plugin::$instance->frontend->get_builder_content( $list['sg_content_template'], true );
				}

				$content .= '<div class="tab-content ' . $tab_id . ' ' . $active . '">' . $template . '</div>';
			}
		}

		$content = '<div class="tab-content-list">' . $content . '</div>';

		return $content;
	}
}
