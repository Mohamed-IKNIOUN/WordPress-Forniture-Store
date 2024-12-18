<?php
/**
 * Post Terms View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Terms_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Terms_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content       = '';
		$term_taxonomy = $this->attribute['sg_term_taxonomy'];
		$term_list     = get_the_terms( get_the_ID(), $term_taxonomy );
		$animation     = ! empty( $this->attribute['st_term_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_term_hover_animation'] ) : '';
		$link_to       = $this->attribute['sg_term_link_to'];
		$html_tag      = \Elementor\Utils::validate_html_tag( $this->attribute['sg_term_html_tag'] );

		if ( ! empty( $term_list ) && is_array( $term_list ) ) {
			$separator = esc_attr( $this->attribute['sg_term_separator'] );
			$count     = count( $term_list );

			$term = $term_list[0]->name;

			if ( 'term' === $link_to ) {
				$term = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_term_link( $term_list[0] ) ), $term );
			}

			$content .= sprintf( '<%1$s class="term-list %2$s">%3$s</%1$s>', $html_tag, $animation, $term );

			for ( $i = 1; $i < $count; $i++ ) {
				$term = $term_list[ $i ]->name;

				if ( 'term' === $link_to ) {
					$term = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_term_link( $term_list[ $i ] ) ), $term );
				}

				$content .= sprintf( '%1$s<%2$s class="term-list %3$s">%4$s</%2$s>', $separator, $html_tag, $animation, $term );
			}

			$content = sprintf( '<span class="post-terms">%1$s</span>', $content );
		} elseif ( empty( $term_list ) && jeg_is_editor_elementor() ) {
			$term = esc_html__( 'Dummy ', 'jeg-elementor-kit' ) . $term_taxonomy;

			if ( 'term' === $link_to ) {
				$term = sprintf( '<a href="%1$s">%2$s</a>', '#', $term );
			}

			$content .= sprintf( '<%1$s class="term-list %2$s">%3$s</%1$s>', $html_tag, $animation, $term );
		}

		return $this->render_wrapper( 'post-terms', $content );
	}
}
