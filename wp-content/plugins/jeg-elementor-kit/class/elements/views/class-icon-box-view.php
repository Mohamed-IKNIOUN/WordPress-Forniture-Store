<?php
/**
 * Icon Box View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Icon_Box_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Icon_Box_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$hover_direction           = esc_attr( $this->attribute['st_background_hover_direction'] );
		$container_hover_animation = esc_attr( $this->attribute['st_container_hover_animation'] );
		$icon_hover_animation      = esc_attr( $this->attribute['st_icon_hover_animation'] );
		$icon_description          = nl2br( $this->attribute['sg_icon_description'] );
		$icon_position             = ( 'top' !== $this->attribute['sg_setting_icon_position'] && empty( $this->attribute['sg_setting_icon_position_responsive'] ) ) ? esc_attr( $this->attribute['sg_setting_icon_position'] ) : esc_attr( $this->attribute['sg_setting_icon_position_responsive'] );
		$icon_color_style          = esc_attr( $this->attribute['sg_icon_color_style'] );

		$header      = 'none' !== $this->attribute['sg_icon_type'] ? '<div class="icon-box icon-box-header elementor-animation-' . $icon_hover_animation . '"><div class="icon style-' . $icon_color_style . '">' . $this->render_icon() . '</div></div>' : '';
		$description = ! empty( $icon_description ) ? '<p class="icon-box-description">' . $icon_description . '</p>' : '';

		$class = 'jkit-icon-box-wrapper hover-from-' . $hover_direction;

		if ( 'gradient' === $this->attribute['st_container_background_background_background'] || 'gradient' === $this->attribute['st_container_hover_background_background_background'] ) {
			$class .= ' hover-gradient';
		}

		$icon_box =
		'<div class="' . $class . '">'
			. $header .
			'<div class="icon-box icon-box-body">
                ' . $this->render_title() . $description . $this->render_button() . '
            </div>
            ' . $this->render_badge() . '
            ' . $this->render_hover_watermark() .
		'</div>';

		$icon_box = $this->render_global_link( $icon_box );

		return $this->render_wrapper( 'icon-box', $icon_box, array( 'icon-position-' . $icon_position, 'elementor-animation-' . $container_hover_animation ) );
	}

	/**
	 * Render Title
	 */
	private function render_title() {
		$title_tag = isset( $this->attribute['sg_setting_html_tag'] ) && ! empty( $this->attribute['sg_setting_html_tag'] ) ? \Elementor\Utils::validate_html_tag( $this->attribute['sg_setting_html_tag'] ) : 'h2';
		$title     = esc_attr( $this->attribute['sg_icon_text'] );
		$title     = ! empty( $title ) ? '<' . $title_tag . ' class="title">' . esc_attr( $this->attribute['sg_icon_text'] ) . '</' . $title_tag . '>' : '';

		return $title;
	}

	/**
	 * Render Icon
	 */
	private function render_icon() {
		$icon = null;

		if ( 'icon' === $this->attribute['sg_icon_type'] ) {
			$icon = $this->render_icon_element( $this->attribute['sg_icon_header'] );
		} elseif ( 'image' === $this->attribute['sg_icon_type'] ) {
			$image_size = $this->attribute['sg_icon_image_size_imagesize_size'];
			$icon       = $this->render_image_element( $this->attribute['sg_icon_image'], $image_size, null, null, esc_attr( $this->attribute['sg_icon_text'] ) );
		}

		return $icon;
	}

	/**
	 * Render Badge
	 *
	 * @return mixed
	 */
	private function render_badge() {
		$badge = null;

		if ( 'yes' === $this->attribute['sg_badge_show'] ) {
			$badge =
			'<div class="icon-box-badge ' . esc_attr( $this->attribute['sg_badge_position'] ) . '">
                <span class="badge-text">' . esc_attr( $this->attribute['sg_badge_text'] ) . '</span>
            </div>';
		}

		return $badge;
	}

	/**
	 * Render Global Link
	 *
	 * @param string $icon_box Icon Box.
	 */
	private function render_global_link( $icon_box ) {
		if ( 'yes' === $this->attribute['sg_readmore_enable_globallink'] && ( 'no' === $this->attribute['sg_readmore_enable_button'] || ! $this->attribute['sg_readmore_enable_button'] ) ) {
			if ( ! empty( $this->attribute['sg_readmore_button_label'] ) ) {
				$data_attribute = 'aria-label="' . esc_attr( $this->attribute['sg_readmore_button_label'] ) . '"';
			} else {
				$data_attribute = 'aria-label="' . esc_attr( $this->attribute['sg_icon_text'] ) . '"';
			}

			return $this->render_url_element( $this->attribute['sg_readmore_globallink'], null, 'icon-box-link', $icon_box, $data_attribute );
		}

		return $icon_box;
	}

	/**
	 * Render Button
	 */
	private function render_button() {
		$button        = null;
		$class         = 'icon-box-link';
		$icon_position = esc_attr( $this->attribute['sg_readmore_button_icon_position'] );
		$icon          = 'yes' === $this->attribute['sg_readmore_button_enable_icon'] ? $this->render_icon_element( $this->attribute['sg_readmore_button_icon'] ) : '';
		$icon_before   = 'before' === $icon_position ? $icon : '';
		$icon_after    = 'after' === $icon_position ? $icon : '';
		$hover         = 'yes' === $this->attribute['sg_readmore_enable_hover_button'] ? 'hover' : '';
		$button_item   = $icon_before . esc_attr( $this->attribute['sg_readmore_button_label'] ) . $icon_after;

		if ( 'gradient' === $this->attribute['st_button_normal_background_background_background'] || 'gradient' === $this->attribute['st_button_hover_background_background_background'] ) {
			$class      .= ' hover-gradient';
			$button_item = '<span>' . $button_item . '</span>';
		}

		if ( 'yes' === $this->attribute['sg_readmore_enable_button'] ) {
			if ( ! empty( $this->attribute['sg_readmore_button_label'] ) ) {
				$data_attribute = 'aria-label="' . esc_attr( $this->attribute['sg_readmore_button_label'] ) . '"';
			} else {
				$data_attribute = 'aria-label="' . esc_attr( $this->attribute['sg_icon_text'] ) . '"';
			}

			$button =
			'<div class="icon-box-button ' . $hover . '">
                <div class="btn-wrapper icon-position-' . $icon_position . '">
                    ' . $this->render_url_element( $this->attribute['sg_readmore_globallink'], null, $class, $button_item, $data_attribute ) . '
                </div>
            </div>';
		}

		return $button;
	}

	/**
	 * Render Hover Watermark
	 *
	 * @return mixed
	 */
	private function render_hover_watermark() {
		$watermark = null;

		if ( 'yes' === $this->attribute['sg_setting_enable_hover_watermark'] ) {
			$watermark =
			'<div class=hover-watermark>
                ' . $this->render_icon_element( $this->attribute['sg_setting_hover_watermark_icon'] ) . '
            </div>';
		}

		return $watermark;
	}
}
