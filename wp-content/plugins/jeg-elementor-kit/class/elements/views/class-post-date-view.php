<?php
/**
 * Post Date View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Date_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Date_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content = '';
		$post    = get_post();

		if ( ! empty( $post ) ) {
			$date_type = $this->attribute['sg_date_type'];

			if ( 'both' === $date_type ) {
				$date = $this->get_post_date( $post, $this->attribute['sg_date_format'], 'published', $this->attribute['sg_date_format_custom'] );
				$date = $date . esc_html__( ' - Updated on ', 'jeg-elementor-kit' );
				$date = $date . $this->get_post_date( $post, $this->attribute['sg_date_format'], 'modified', $this->attribute['sg_date_format_custom'] );
			} else {
				$date = $this->get_post_date( $post, $this->attribute['sg_date_format'], $date_type, $this->attribute['sg_date_format_custom'] );
			}

			if ( ! empty( $date ) ) {
				$link_to   = $this->attribute['sg_date_link_to'];
				$html_tag  = \Elementor\Utils::validate_html_tag( $this->attribute['sg_date_html_tag'] );
				$animation = ! empty( $this->attribute['st_date_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_date_hover_animation'] ) : '';

				switch ( $link_to ) {
					case 'home':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_home_url() ), $date );
						break;
					case 'post':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_permalink() ), $date );
						break;
					case 'date':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) ), $date );
						break;
					case 'custom':
						$content = $this->render_url_element( $this->attribute['sg_date_link_to_custom'], null, null, $date );
						break;
					default:
						$content = $date;
						break;
				}

				$content = sprintf( '<%1$s class="post-date %2$s">%3$s</%1$s>', $html_tag, $animation, $content );
			}
		}

		return $this->render_wrapper( 'post-date', $content );
	}
}
