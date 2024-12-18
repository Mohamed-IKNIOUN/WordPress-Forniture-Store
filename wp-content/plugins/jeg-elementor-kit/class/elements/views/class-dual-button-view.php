<?php
/**
 * Dual Button View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.10.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Dual_Button_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Dual_Button_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$button_one = $this->render_button_one();
		$button_two = $this->render_button_two();

		$middle = 'yes' === $this->attribute['sg_dual_middle_text_enable'] ? '<span class="jkit-dual-button-middle-text">' . esc_attr( $this->attribute['sg_dual_middle_text'] ) . '</span>' : '';
		$output = '<div class="jkit-dual-button-wrapper">' . $button_one . $middle . $button_two . '</div>';

		return $this->render_wrapper( 'dual-button', $output );
	}

	/**
	 * Render Button One
	 */
	private function render_button_one() {
		$class = 'jkit-dual-btn jkit-dual-button-one';
		$text  = esc_attr( $this->attribute['sg_one_text'] );

		if ( 'yes' === $this->attribute['sg_one_icon_enable'] ) {
			$icon_position = $this->attribute['sg_one_icon_position'];
			$icon          = $this->attribute['sg_one_icon'];

			if ( 'before' === $icon_position ) {
				$text = $this->render_icon_element( $icon ) . $text;
			} else {
				$text = $text . $this->render_icon_element( $icon );
			}

			$class .= ' icon-position-' . $icon_position;
		}

		if ( 'gradient' === $this->attribute['st_one_normal_background_background_background'] || 'gradient' === $this->attribute['st_one_hover_background_background_background'] ) {
			$class .= ' hover-gradient';
			$text   = '<span>' . $text . '</span>';
		}

		return $this->render_url_element( $this->attribute['sg_one_link'], null, $class, $text );
	}

	/**
	 * Render Button Two
	 */
	private function render_button_two() {
		$class = 'jkit-dual-btn jkit-dual-button-two';
		$text  = esc_attr( $this->attribute['sg_two_text'] );

		if ( 'yes' === $this->attribute['sg_two_icon_enable'] ) {
			$icon_position = $this->attribute['sg_two_icon_position'];
			$icon          = $this->attribute['sg_two_icon'];

			if ( 'before' === $icon_position ) {
				$text = $this->render_icon_element( $icon ) . $text;
			} else {
				$text = $text . $this->render_icon_element( $icon );
			}

			$class .= ' icon-position-' . $icon_position;
		}

		if ( 'gradient' === $this->attribute['st_two_normal_background_background_background'] || 'gradient' === $this->attribute['st_two_normal_background_background_background'] ) {
			$class .= ' hover-gradient';
			$text   = '<span>' . $text . '</span>';
		}

		return $this->render_url_element( $this->attribute['sg_two_link'], null, $class, $text );
	}
}
