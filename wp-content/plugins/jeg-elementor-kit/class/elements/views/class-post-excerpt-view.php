<?php
/**
 * Post Excerpt View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Excerpt_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Excerpt_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content = '';

		$excerpt = ! jeg_is_editor_elementor() ? get_the_excerpt() : esc_html__( 'This is dummy excerpt and will be replaced with real excerpt of your post', 'jeg-elementor-kit' );

		if ( ! empty( $excerpt ) ) {
			$link_to   = $this->attribute['sg_excerpt_link_to'];
			$html_tag  = \Elementor\Utils::validate_html_tag( $this->attribute['sg_excerpt_html_tag'] );
			$animation = ! empty( $this->attribute['st_excerpt_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_excerpt_hover_animation'] ) : '';

			switch ( $link_to ) {
				case 'home':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_home_url() ), $excerpt );
					break;
				case 'post':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_permalink() ), $excerpt );
					break;
				case 'custom':
					$content = $this->render_url_element( $this->attribute['sg_excerpt_link_to_custom'], null, null, $excerpt );
					break;
				default:
					$content = $excerpt;
					break;
			}

			$content = sprintf( '<%1$s class="post-excerpt %2$s">%3$s</%1$s>', $html_tag, $animation, $content );
		}

		return $this->render_wrapper( 'post-excerpt', $content );
	}
}
