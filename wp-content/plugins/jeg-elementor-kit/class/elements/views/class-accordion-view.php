<?php
/**
 * Accordion View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Accordion_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Accordion_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		return $this->render_wrapper( 'accordion', $this->render_accordion(), array( 'style-' . $this->attribute['sg_accordion_style'] ) );
	}

	/**
	 * Render Accordion
	 */
	private function render_accordion() {
		$accordions = '';
		$left_icon  = '';
		$right_icon = '';

		$left_icon_normal  = $this->attribute['sg_icon_left'];
		$left_icon_active  = $this->attribute['sg_icon_left_active'];
		$right_icon_normal = $this->attribute['sg_icon_right'];
		$right_icon_active = $this->attribute['sg_icon_right_active'];
		$icon_position     = esc_attr( $this->attribute['sg_icon_position'] );
		$number            = 'yes' === $this->attribute['sg_icon_number'] && 'right' === $this->attribute['sg_icon_position'] ? '<span class="number"></span>' : '';
		$first_expand      = 'yes' === $this->attribute['sg_accordion_open'] ? 'expand' : '';
		$list              = $this->attribute['sg_accordion_list'];

		if ( 'left' === $icon_position || 'both' === $icon_position ) {
			$left_icon =
			'<div class="left-icon-group">
                <div class="normal-icon">' . $this->render_icon_element( $left_icon_normal ) . '</div>
                <div class="active-icon">' . $this->render_icon_element( $left_icon_active ) . '</div>
            </div>';
		}

		if ( 'right' === $icon_position || 'both' === $icon_position ) {
			$right_icon =
			'<div class="right-icon-group">
                <div class="normal-icon">' . $this->render_icon_element( $right_icon_normal ) . '</div>
                <div class="active-icon">' . $this->render_icon_element( $right_icon_active ) . '</div>
            </div>';
		}

		$class_wrapper = 'card-wrapper';
		$class_header  = 'card-header';

		if ( 'gradient' === $this->attribute['st_wrapper_open_background_background_background'] || 'gradient' === $this->attribute['st_wrapper_close_background_background_background'] ) {
			$class_wrapper .= ' background-gradient';
		}

		if ( 'gradient' === $this->attribute['st_title_open_background_background_background'] || 'gradient' === $this->attribute['st_title_close_background_background_background'] ) {
			$class_header .= ' background-gradient';
		}

		foreach ( $list as $key => $accordion ) {
			$expand_id    = 'expand-' . esc_attr( $accordion['_id'] );
			$title        = esc_attr( $accordion['sg_accordion_list_title'] );
			$content      = wp_kses_post( $accordion['sg_accordion_list_content'] );
			$expand       = 'yes' === $accordion['sg_accordion_list_open'] ? 'expand' : '';
			$expand       = 0 === $key && 'expand' !== $expand ? $first_expand : $expand;
			$style_expand = 'expand' === $expand ? 'block' : 'none';

			$accordions = $accordions .
			'<div class="' . $class_wrapper . ' ' . $expand . '">
                <div class="' . $class_header . '">
                    <a href="#' . $expand_id . '" class="card-header-button" aria-expanded="false" data-target="#' . $expand_id . '" aria-controls="' . $expand_id . '">
                        ' . $number . $left_icon . '<span class="title">' . $title . '</span>' . $right_icon . '
                    </a>
                </div>
                <div class="card-expand" id="' . $expand_id . '" style="display:' . $style_expand . '"><div class="card-body">' . $content . '</div></div>
            </div>';
		}

		return $accordions;
	}
}
