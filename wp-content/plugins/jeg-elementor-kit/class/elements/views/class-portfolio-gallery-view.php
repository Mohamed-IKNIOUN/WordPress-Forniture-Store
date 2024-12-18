<?php
/**
 * Portfolio Gallery View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Portfolio_Gallery_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Portfolio_Gallery_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$output  = '';
		$row     = '';
		$gallery = '';

		$html_tag    = \Elementor\Utils::validate_html_tag( $this->attribute['sg_setting_title_tag'] );
		$behavior    = esc_attr( $this->attribute['sg_setting_behavior'] );
		$image_size  = esc_attr( $this->attribute['sg_gallery_image_size_imagesize_size'] );
		$more_enable = 'yes' === $this->attribute['sg_setting_more_enable'];

		foreach ( $this->attribute['sg_gallery_list'] as $key => $item ) {
			$row     = $row . $this->render_row_item( $key, $item, $html_tag, $more_enable );
			$gallery = $gallery . $this->render_gallery_item( $key, $item, $image_size );
		}

		$output =
		'<div class="portfolio-gallery-container">
            <div class="row-items">' . $row . '</div>
            <div class="gallery-items">' . $gallery . '</div>
        </div>';

		return $this->render_wrapper( 'portfolio-gallery', $output, array( 'on-' . $behavior ) );
	}

	/**
	 * Render row item
	 *
	 * @param string $key Key.
	 * @param array  $item Image option.
	 * @param string $html_tag HTML Tag option.
	 * @param bool   $more_enable More option enable.
	 *
	 * @return mixed
	 */
	public function render_row_item( $key, $item, $html_tag, $more_enable ) {
		$info   = null;
		$more   = null;
		$output = null;

		$id           = 'elementor-repeater-item-' . esc_attr( $item['_id'] );
		$title        = esc_attr( $item['sg_gallery_list_title'] );
		$subtitle     = esc_attr( $item['sg_gallery_list_subtitle'] );
		$current_item = 0 === $key || 'yes' === $item['sg_gallery_list_current'] ? 'current-item' : '';

		$info =
		'<div class="row-item-info">
            <p class="info-subtitle">' . $subtitle . '</p>
            <' . $html_tag . ' class="info-title">' . $title . '</' . $html_tag . '>
        </div>';

		if ( $more_enable ) {
			$more_text = esc_attr( $item['sg_gallery_list_more_text'] );
			$more_icon = $this->render_icon_element( $item['sg_gallery_list_more_icon'] );

			if ( 'before' === $item['sg_gallery_list_more_icon_position'] ) {
				$more = '<div class="row-item-more position-before">' . $this->render_url_element( $item['sg_gallery_list_more_link'], null, null, $more_icon . $more_text ) . '</div>';
			} else {
				$more = '<div class="row-item-more position-after">' . $this->render_url_element( $item['sg_gallery_list_more_link'], null, null, $more_text . $more_icon ) . '</div>';
			}
		}

		$output = '<div class="row-item ' . $id . ' ' . $current_item . '" data-tab="portfolio-gallery-tab-' . strval( $key ) . '">' . $info . $more . '</div>';

		return $output;
	}

	/**
	 * Render gallery item.
	 *
	 * @param string $key Key.
	 * @param array  $item Image option.
	 * @param string $image_size Image size option.
	 *
	 * @return mixed
	 */
	public function render_gallery_item( $key, $item, $image_size ) {
		$current_item     = 0 === $key || 'yes' === $item['sg_gallery_list_current'] ? 'current-item' : '';
		$image_attachment = ! empty( $item['sg_gallery_list_image']['id'] ) ? wp_get_attachment_image_src( $item['sg_gallery_list_image']['id'], $image_size ) : '';
		$image_src        = ! empty( $image_attachment[0] ) ? $image_attachment[0] : $item['sg_gallery_list_image']['url'];
		$output           = '<div id="portfolio-gallery-tab-' . $key . '" class="image-item ' . $current_item . '" data-background="' . esc_attr( $image_src ) . '" style="background-image:url(' . esc_url( $image_src ) . ');"></div>';

		return $output;
	}
}
