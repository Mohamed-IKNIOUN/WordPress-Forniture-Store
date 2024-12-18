<?php
/**
 * Banner View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Banner_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Banner_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		return $this->render_wrapper( 'banner', $this->render_template() );
	}

	/**
	 * Render Template
	 */
	public function render_template() {
		$image_bg      = $this->attribute['sg_banner_image'];
		$image_bg_size = $this->attribute['sg_banner_image_size_imagesize_size'];
		$image_src     = ! empty( $image_bg['id'] ) ? wp_get_attachment_image_src( $image_bg['id'], $image_bg_size ) : $image_bg['url'];

		$subtitle    = '<h5 class="jkit-banner-subtitle">' . esc_attr( $this->attribute['sg_banner_subtitle'] ) . '</h5>';
		$title       = '<h4 class="jkit-banner-title">' . esc_attr( $this->attribute['sg_banner_title'] ) . '</h4>';
		$description = $this->attribute['sg_banner_show_description'] === 'yes' ? '<div class="jkit-banner-description">' . $this->attribute['sg_banner_description'] . '</div>' : '';

		$before_box_sale_text = '<div class="jkit-banner-box-sale-before-text">' . esc_attr( $this->attribute['sg_box_sale_before_text'] ) . '</div>';
		$box_sale_unit        = '<span class="jkit-banner-box-sale-unit">' . esc_attr( $this->attribute['sg_box_sale_unit'] ) . '</span>';
		$box_sale_text        = '<div class="jkit-banner-box-sale-text">' . esc_attr( $this->attribute['sg_box_sale_text'] ) . $box_sale_unit . '</div>';

		$button_link = '';
		if ( $this->attribute['sg_button_text'] ) {
			$button_text = $this->attribute['sg_button_text'];
			if ( 'icon' === $this->attribute['sg_button_icon_type'] ) {
				$icon = $this->render_icon_element( $this->attribute['sg_button_icon'] );
				if ( 'before' === $this->attribute['sg_button_icon_position'] ) {
					$button_text = sprintf( '%s%s', $icon, $this->attribute['sg_button_text'] );
				} else {
					$button_text = sprintf( '%s%s', $this->attribute['sg_button_text'], $icon );
				}
			}
			$button_link = $this->render_url_element( $this->attribute['sg_button_link'], null, 'jkit-banner-button-link', $button_text );
		}

		$box_sale_class = sprintf(
			'jkit-box-sale-position-%s jkit-box-sale-position-%s',
			$this->attribute['st_box_sale_horizontal_orientation'],
			$this->attribute['st_box_sale_vertical_orientation']
		);

		$image     = sprintf( '<div class="jkit-banner-image" style="background-image: url(%s)"></div>', esc_url( is_array( $image_src ) ? $image_src[0] : $image_src ) );
		$content   = '<div class="jkit-banner-content"><div class="jkit-banner-content-inner">' . $subtitle . $title . $description . $button_link . '</div></div>';
		$box_sale  = '<div class="jkit-banner-box-sale ' . $box_sale_class . '">' . $before_box_sale_text . $box_sale_text . '</div>';
		$type_link = ( 'all' === $this->attribute['sg_link_type'] ) ? $this->render_url_element( $this->attribute['sg_button_link'], null, 'jkit-banner-all-link' ) : '';
		$wrapper   = '<div class="jkit-banner-wrapper">' . $image . $content . $box_sale . $type_link . '</div>';

		return wp_kses_post( $wrapper );
	}
}
