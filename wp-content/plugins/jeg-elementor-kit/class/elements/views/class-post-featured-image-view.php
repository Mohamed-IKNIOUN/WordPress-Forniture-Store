<?php
/**
 * Post Featured Image View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Featured_Image_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Featured_Image_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content = '';
		$image   = get_the_post_thumbnail( get_the_ID(), $this->attribute['sg_image_size_imagesize_size'] );

		if ( empty( $image ) && jeg_is_editor_elementor() ) {
			$image_sizes = wp_get_registered_image_subsizes();
			$size        = isset( $image_sizes[ $this->attribute['sg_image_size_imagesize_size'] ] ) ? $image_sizes[ $this->attribute['sg_image_size_imagesize_size'] ] : $image_sizes['large'];
			$image       = '<img width="' . $size['width'] . '" height="' . $size['height'] . '" src="' . \Elementor\Utils::get_placeholder_image_src() . '"/>';
		}

		if ( ! empty( $image ) ) {
			$link_to   = $this->attribute['sg_image_link_to'];
			$animation = ! empty( $this->attribute['st_image_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_image_hover_animation'] ) : '';

			switch ( $link_to ) {
				case 'home':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_home_url() ), $image );
					break;
				case 'post':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_permalink() ), $image );
					break;
				case 'media':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_post_thumbnail_url() ), $image );
					break;
				case 'custom':
					$content = $this->render_url_element( $this->attribute['sg_image_link_to_custom'], null, null, $image );
					break;
				default:
					$content = $image;
					break;
			}

			$content = sprintf( '<div class="post-featured-image %1$s">%2$s</div>', $animation, $content );
		}

		return $this->render_wrapper( 'post-featured-image', $content );
	}
}
