<?php
/**
 * Post Title View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Title_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Title_View extends View_Abstract {
	/**
	 * Build block content
	 *
	 * @return mixed
	 */
	public function build_content() {
		$content = '';
		$title   = get_the_title();

		if ( ! empty( $title ) ) {
			$link_to   = $this->attribute['sg_title_link_to'];
			$html_tag  = \Elementor\Utils::validate_html_tag( $this->attribute['sg_title_html_tag'] );
			$animation = ! empty( $this->attribute['st_title_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_title_hover_animation'] ) : '';
			$style     = 'style-' . esc_attr( $this->attribute['sg_title_color_style'] );

			switch ( $link_to ) {
				case 'home':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_home_url() ), $title );
					break;
				case 'post':
					$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_permalink() ), $title );
					break;
				case 'custom':
					$content = $this->render_url_element( $this->attribute['sg_title_link_to_custom'], null, null, $title );
					break;
				default:
					$content = $title;
					break;
			}

			$content = sprintf( '<%1$s class="post-title %2$s %3$s">%4$s</%1$s>', $html_tag, $style, $animation, $content );
		}

		return $this->render_wrapper( 'post-title', $content );
	}
}
