<?php
/**
 * Search View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.10.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Search_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Search_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$output = null;
		$icon   = $this->render_icon_element( $this->attribute['sg_search_icon'] );
		$type   = $this->attribute['sg_search_style'];

		if ( 'popup' === $type ) {
			$output = $this->render_modal( $icon );
		} else {
			$output = $this->render_form( $icon );
		}

		return $this->render_wrapper( 'search', $output );
	}

	/**
	 * Render Modal
	 *
	 * @param string $icon Rendered icon.
	 */
	private function render_modal( $icon ) {
		$search_modal_class = 'jkit-search-modal';

		if ( 'gradient' === $this->attribute['st_icon_normal_background_background_background'] || 'gradient' === $this->attribute['st_icon_hover_background_background_background'] ) {
			$search_modal_class .= ' hover-gradient';
		}

		return '<a href="#" class="' . $search_modal_class . '">' . $icon . '</a>
			<div class="jkit-modal-search-panel-wrapper">
				<div class="jkit-modal-search-panel">
					' . $this->render_form( $icon ) . '
				</div>
			</div>';
	}

	/**
	 * Render Form
	 *
	 * @param string $icon Rendered icon.
	 */
	private function render_form( $icon ) {
		$language_prefix = function_exists( 'pll_current_language' ) ? pll_current_language() : '';
		$placeholder     = esc_attr( $this->attribute['sg_search_placeholder'] );
		$button_icon     = 'icon' === $this->attribute['sg_search_button_style'] ? $icon : esc_attr( $this->attribute['sg_search_text'] );

		$button_class = 'jkit-search-button';
		$input_class  = 'jkit-search-field';

		if ( 'gradient' === $this->attribute['st_button_background_background_background'] || 'gradient' === $this->attribute['st_button_hover_background_background_background'] ) {
			$button_class .= ' hover-gradient';
		}

		return '<div class="jkit-search-panel">
					<form role="search" method="get" class="jkit-search-group" action="' . esc_url( home_url( '/' . $language_prefix ) ) . '">
						<input type="search" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . esc_attr( get_search_query() ) . '" name="s" />
						<button type="submit" class="' . $button_class . '" aria-label="search-button">' . $button_icon . '</button>
					</form>
				</div>';
	}
}
