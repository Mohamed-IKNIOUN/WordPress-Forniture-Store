<?php
/**
 * Feature List View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.11.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Feature_List_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Feature_List_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$icon_position        = ! empty( $this->attribute['sg_setting_icon_position_responsive'] ) ? 'icon-position-' . esc_attr( $this->attribute['sg_setting_icon_position_responsive'] ) : 'icon-position-left';
		$tablet_icon_position = ! empty( $this->attribute['sg_setting_icon_position_responsive_tablet'] ) ? 'tablet-icon-position-' . esc_attr( $this->attribute['sg_setting_icon_position_responsive_tablet'] ) : 'icon-position-left';
		$mobile_icon_position = ! empty( $this->attribute['sg_setting_icon_position_responsive_mobile'] ) ? 'mobile-icon-position-' . esc_attr( $this->attribute['sg_setting_icon_position_responsive_mobile'] ) : 'icon-position-left';

		return $this->render_wrapper( 'feature-list', $this->render_list(), array( $icon_position, $tablet_icon_position, $mobile_icon_position ) );
	}

	/**
	 * Render List
	 */
	private function render_list() {
		$output         = '';
		$connector      = '';
		$connector_type = '';
		$html_tag       = \Elementor\Utils::validate_html_tag( $this->attribute['sg_setting_html_tag'] );
		$shape          = 'shape-' . esc_attr( $this->attribute['sg_setting_icon_shape'] );
		$shape_view     = 'shape-view-' . esc_attr( $this->attribute['sg_setting_shape_view'] );

		if ( 'yes' === $this->attribute['sg_setting_connector_enable'] ) {
			$connector_type = 'connector-type-' . esc_attr( $this->attribute['st_list_connector_type'] );
			$connector      = '<span class="connector"></span>';
		}

		foreach ( $this->attribute['sg_setting_list'] as $list ) {
			$id         = 'elementor-repeater-item-' . esc_attr( $list['_id'] );
			$image_size = $list['sg_setting_list_image_size_imagesize_size'];

			$icon = 'icon' === $list['sg_setting_list_icon_type'] ? $this->render_icon_element( $list['sg_setting_list_icon'] ) : $this->render_image_element( $list['sg_setting_list_image'], $image_size, null, 'feature-list-img' );
			$icon = ! empty( $list['sg_setting_list_link']['url'] ) ? $this->render_url_element( $list['sg_setting_list_link'], null, null, $icon ) : $icon;

			$title = esc_attr( $list['sg_setting_list_title'] );
			$title = ! empty( $list['sg_setting_list_link']['url'] ) ? $this->render_url_element( $list['sg_setting_list_link'], null, null, $title ) : $title;
			$title = ! empty( $title ) ? '<' . $html_tag . ' class="feature-list-title">' . $title . '</' . $html_tag . '>' : '';

			$content = ! empty( $list['sg_setting_list_content'] ) ? '<p class="feature-list-content">' . esc_attr( $list['sg_setting_list_content'] ) . '</p>' : '';

			$output .=
			'<li class="feature-list-item ' . $id . '">
				' . $connector . '
				<div class="feature-list-icon-box">
					<div class="feature-list-icon-inner">
						<span class="feature-list-icon">
							' . $icon . '
						</span>
					</div>
				</div>
				<div class="feature-list-content-box">
					' . $title . $content . '
				</div>
			</li>';
		}

		$output = '<ul class="feature-list-items ' . $shape . ' ' . $shape_view . ' ' . $connector_type . '">' . $output . '</ul>';

		return $output;
	}
}
