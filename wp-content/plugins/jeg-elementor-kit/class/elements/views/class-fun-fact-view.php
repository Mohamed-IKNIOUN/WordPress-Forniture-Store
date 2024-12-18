<?php
/**
 * Fun Fact View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Fun_Fact_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Fun_Fact_View extends View_Abstract {
	/**
	 * Build block content
	 *
	 * @return bool
	 */
	public function build_content() {
		$title_tag            = isset( $this->attribute['sg_setting_html_tag'] ) && ! empty( $this->attribute['sg_setting_html_tag'] ) ? \Elementor\Utils::validate_html_tag( $this->attribute['sg_setting_html_tag'] ) : 'h2';
		$title                = esc_attr( $this->attribute['sg_content_title'] );
		$alignment            = esc_attr( $this->attribute['sg_setting_alignment'] );
		$hover_direction      = esc_attr( $this->attribute['st_background_hover_direction'] );
		$hover_animation      = esc_attr( $this->attribute['st_background_hover_animation'] );
		$icon_hover_animation = esc_attr( $this->attribute['st_icon_hover_animation'] );
		$icon_type            = esc_attr( $this->attribute['sg_icon_type'] );

		$icon = 'none' !== $icon_type ? '<div class="icon elementor-animation-' . $icon_hover_animation . '">' . $this->render_icon() . '</div>' : '';

		$output =
		'<div class=fun-fact-inner>' . $icon . '
            <div class="content">
                <div class="number-wrapper">' . $this->render_number() . '</div>
                <' . $title_tag . ' class="title">' . $title . '</' . $title_tag . '>
            </div>
        </div>' . $this->render_border_bottom();

		return $this->render_wrapper( 'fun-fact', $output, array( 'align-' . $alignment, 'hover-from-' . $hover_direction, 'elementor-animation-' . $hover_animation ) );
	}

	/**
	 * Render Icon
	 *
	 * @return mixed
	 */
	private function render_icon() {
		$icon = null;

		if ( 'icon' === $this->attribute['sg_icon_type'] ) {
			$icon = $this->render_icon_element( $this->attribute['sg_icon_choose'] );
		} elseif ( 'image' === $this->attribute['sg_icon_type'] ) {
			$image_size = $this->attribute['sg_icon_image_size_imagesize_size'];
			$icon       = $this->render_image_element( $this->attribute['sg_icon_image'], $image_size );
		}

		return $icon;
	}

	/**
	 * Render Number
	 *
	 * @return string
	 */
	private function render_number() {
		$animation_duration = isset( $this->attribute['sg_setting_number_aniamtion_duration']['size'] ) ? esc_attr( $this->attribute['sg_setting_number_aniamtion_duration']['size'] ) : 3500;
		$super              = 'yes' === $this->attribute['sg_setting_enable_super'] ? '<sup class="super">' . esc_attr( $this->attribute['sg_content_super'] ) . '</sup>' : '';
		$prefix             = '<span class="prefix">' . $this->attribute['sg_content_number_prefix'] . '</span>';
		$suffix             = '<span class="suffix">' . $this->attribute['sg_content_number_suffix'] . '</span>';

		return $prefix . '
        <span class="number" data-value="' . esc_attr( $this->attribute['sg_content_number'] ) . '" data-animation-duration="' . $animation_duration . '">0</span>
        ' . $suffix . $super;
	}

	/**
	 * Render Border Bottom
	 *
	 * @return mixed
	 */
	private function render_border_bottom() {
		$border_bottom = null;

		if ( 'yes' === $this->attribute['sg_setting_enable_hover_border_bottom'] ) {
			$border_bottom = '<div class="border-bottom ' . esc_attr( $this->attribute['sg_setting_hover_direction'] ) . '"></div>';
		}

		return $border_bottom;
	}
}
