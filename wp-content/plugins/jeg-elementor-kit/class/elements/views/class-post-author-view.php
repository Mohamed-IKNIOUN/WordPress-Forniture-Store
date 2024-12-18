<?php
/**
 * Post Author View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Author_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Author_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content = '';
		$post    = get_post();

		if ( ! empty( $post ) ) {
			$author = $this->get_author( $post );

			if ( ! empty( $author ) ) {
				$link_to   = $this->attribute['sg_author_link_to'];
				$html_tag  = \Elementor\Utils::validate_html_tag( $this->attribute['sg_author_html_tag'] );
				$animation = ! empty( $this->attribute['st_author_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_author_hover_animation'] ) : '';

				switch ( $link_to ) {
					case 'home':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_home_url() ), $author );
						break;
					case 'post':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_the_permalink() ), $author );
						break;
					case 'author':
						$content = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), $author );
						break;
					case 'custom':
						$content = $this->render_url_element( $this->attribute['sg_author_link_to_custom'], null, null, $author );
						break;
					default:
						$content = $author;
						break;
				}

				$content = sprintf( '<%1$s class="post-author %2$s">%3$s</%1$s>', $html_tag, $animation, $content );
			}
		}

		return $this->render_wrapper( 'post-author', $content );
	}

	/**
	 * Get author for current post
	 *
	 * @param \WP_Post $post Post object.
	 *
	 * @return string
	 */
	private function get_author( $post ) {
		$author = '';

		switch ( $this->attribute['sg_author_type'] ) {
			case 'first_name':
				$author = get_the_author_meta( 'first_name', $post->post_author );
				break;
			case 'last_name':
				$author = get_the_author_meta( 'last_name', $post->post_author );
				break;
			case 'first_last':
				$author = sprintf( '%s %s', get_the_author_meta( 'first_name', $post->post_author ), get_the_author_meta( 'last_name', $post->post_author ) );
				break;
			case 'last_first':
				$author = sprintf( '%s %s', get_the_author_meta( 'last_name', $post->post_author ), get_the_author_meta( 'first_name', $post->post_author ) );
				break;
			case 'nick_name':
				$author = get_the_author_meta( 'nickname', $post->post_author );
				break;
			case 'display_name':
				$author = get_the_author_meta( 'display_name', $post->post_author );
				break;
			case 'user_name':
				$author = get_the_author_meta( 'user_login', $post->post_author );
				break;
			case 'user_bio':
				$author = get_the_author_meta( 'description', $post->post_author );
				break;
			case 'user_image':
				$author = get_avatar( get_the_author_meta( 'email', $post->post_author ), 256 );
				break;
		}

		return $author;
	}
}
