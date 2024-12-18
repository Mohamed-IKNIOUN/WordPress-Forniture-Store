<?php
/**
 * Social Share View Class
 *
 * @author Jegtheme
 * @since 1.6.0
 * @package jeg-elementor-kit
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Social Share View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Social_Share_View extends View_Abstract {
	/**
	 * Build block content
	 *
	 * @return mixed
	 */
	public function build_content() {
		$lists         = '';
		$style         = $this->attribute['sg_social_style'];
		$icon_position = $this->attribute['sg_social_icon_position'];

		foreach ( $this->attribute['sg_social_list'] as $social ) {
			$label_icon = '';
			$id         = 'elementor-repeater-item-' . esc_attr( $social['_id'] );
			$brand      = esc_attr( $social['sg_social_brand'] );
			$label      = esc_attr( $social['sg_social_label'] );
			$class      = $brand . ' social-icon';
			$link_attr  = array(
				'url'               => '#',
				'is_external'       => '',
				'nofollow'          => '',
				'custom_attributes' => 'aria-label|social-share',
			);

			if ( 'icon' === $style ) {
				$label_icon = $this->render_icon_element( $social['sg_social_icon'] );
			} elseif ( 'text' === $style ) {
				$label_icon = $label;
			} elseif ( 'before' === $icon_position ) {
					$label_icon = '<span class="icon-position-' . $icon_position . '">' . $this->render_icon_element( $social['sg_social_icon'] ) . $label . '</span>';
			} else {
				$label_icon = '<span class="icon-position-' . $icon_position . '">' . $label . $this->render_icon_element( $social['sg_social_icon'] ) . '</span>';
			}

			if ( 'gradient' === $social['sg_social_normal_background_background_background'] || 'gradient' === $social['sg_social_hover_background_background_background'] || 'gradient' === $this->attribute['st_social_normal_background_background_background'] || 'gradient' === $this->attribute['st_social_hover_background_background_background'] ) {
				$class     .= ' hover-gradient';
				$label_icon = '<span>' . $label_icon . '</span>';
			}

			$lists .=
			'<li class="' . $id . '" data-social="' . $brand . '">
				' . $this->render_url_element( $link_attr, null, $class, $label_icon ) . '
			</li>';
		}

		return $this->render_wrapper( 'social-share', '<ul class="social-share-list">' . $lists . '</ul>' );
	}
}
