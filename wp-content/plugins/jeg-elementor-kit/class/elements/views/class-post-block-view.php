<?php
/**
 * Post Block View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Block_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Block_View extends View_Abstract {
	/**
	 * Render Module
	 *
	 * @param  array  $attr         Array of attribute.
	 * @param  string $column_class Class string.
	 * @return string
	 */
	public function render_element( $attr, $column_class ) {
		$attr = $this->filter_post_attribute( $attr );
		$this->set_attribute( $attr );

		$content        = $this->render_block_element();
		$settings       = $this->render_settings();
		$postblock_type = 'postblock-' . esc_attr( $this->attribute['sg_content_postblock_type'] );
		$pagination     = 'jkit-pagination-' . esc_attr( $this->attribute['pagination_mode'] );

		return $this->render_wrapper(
			'postblock',
			$content,
			array( $postblock_type, $pagination, 'post-element' ),
			array(
				'id'       => $this->unique_id,
				'settings' => $settings,
			)
		);
	}

	/**
	 * Render result element
	 *
	 * @param array $results Result element.
	 * @param array $attr Options.
	 */
	public function render_result_element( $results, $attr ) {
		$attr = $this->filter_post_attribute( $attr );
		$this->set_attribute( $attr );

		$content  = $this->render_result_block_element( $results );
		$settings = $this->render_settings();

		$breakpoint     = 'type-1' === $this->attribute['sg_content_postblock_type'] || 'type-4' === $this->attribute['sg_content_postblock_type'] ? 'break-point-' . esc_attr( $this->attribute['sg_content_breakpoint'] ) : '';
		$postblock_type = 'postblock-' . esc_attr( $this->attribute['sg_content_postblock_type'] );
		$pagination     = 'jkit-pagination-' . esc_attr( $this->attribute['pagination_mode'] );

		return $this->render_wrapper(
			'postblock',
			$content,
			array( $postblock_type, $pagination, $breakpoint, 'post-element' ),
			array(
				'id'       => $this->unique_id,
				'settings' => $settings,
			)
		);
	}

	/**
	 * Ajax request handler
	 */
	public function ajax_request() {
		// @codingStandardsIgnoreStart sanitize value using jeg_sanitize_array
		$attr        = jeg_sanitize_array( $_REQUEST['data'] );
		// @codingStandardsIgnoreEnd
		$query_param = $this->build_ajax_query( $attr );
		$results     = $this->build_query( $query_param );

		$this->set_attribute( $attr['attr'] );

		if ( ! empty( $results['result'] ) ) {
			if ( 1 === intval( $attr['current_page'] ) && 'nextprev' !== $attr['attr']['pagination_mode'] ) {
				$content = $this->render_column( $results['result'] );
			} else {
				$content = $this->render_column_alt( $results['result'] );
			}
		} else {
			$content = $this->empty_content();
		}

		wp_send_json(
			array(
				'content' => $content,
				'next'    => $results['next'],
				'prev'    => $results['prev'],
			)
		);
	}

	/**
	 * Get post excerpt
	 *
	 * @param  int|\WP_Post $post Post object.
	 * @return mixed
	 */
	protected function get_excerpt( $post ) {
		$excerpt        = null;
		$excerpt_enable = 'yes' === $this->attribute['sg_content_excerpt_enable'];

		if ( $excerpt_enable ) {
			$excerpt = $post->post_excerpt;

			if ( empty( $excerpt ) ) {
				$excerpt = $post->post_content;
			}

			$excerpt = preg_replace( '/\[[^\]]+\]/', '', $excerpt );
			$excerpt = wp_trim_words( $excerpt, $this->excerpt_length(), $this->excerpt_more() );
			$excerpt = apply_filters( 'jeg_module_excerpt', $excerpt, $post->ID, $this->excerpt_length(), $this->excerpt_more() );
			$excerpt = '<div class="jkit-post-excerpt"><p>' . $excerpt . '</p></div>';
		}

		return $excerpt;
	}

	/**
	 * Get post read more button
	 *
	 * @param  int|\WP_Post $post Post object.
	 * @return mixed
	 */
	protected function get_readmore( $post, $post_title ) {
		$readmore        = null;
		$readmore_enable = 'yes' === $this->attribute['sg_content_readmore_enable'];

		if ( $readmore_enable ) {
			$icon          = $this->render_icon_element( $this->attribute['sg_content_readmore_icon'] );
			$icon_position = esc_attr( $this->attribute['sg_content_readmore_icon_position'] );
			$text          = esc_attr( $this->attribute['sg_content_readmore_text'] );

			if ( 'before' === $icon_position ) {
				$readmore = $icon . $text;
			} else {
				$readmore = $text . $icon;
			}

			$readmore =
			'<div class="jkit-meta-readmore icon-position-' . $icon_position . '">
                <a title="' . $post_title . '" href="' . esc_url( get_the_permalink( $post ) ) . '" class="jkit-readmore">' . $readmore . '</a>
            </div>';
		}

		return $readmore;
	}

	/**
	 * Get comment bubble icon
	 *
	 * @param  int|\WP_Post $post Post object.
	 * @return mixed
	 */
	protected function get_comment_bubble( $post ) {
		$comment        = null;
		$comment_enable = 'yes' === $this->attribute['sg_content_comment_enable'];

		if ( $comment_enable ) {
			$number        = jkit_get_comments_number( $post->ID );
			$icon          = $this->render_icon_element( $this->attribute['sg_content_comment_icon'] );
			$icon_position = esc_attr( $this->attribute['sg_content_comment_icon_position'] );

			if ( 'before' === $icon_position ) {
				$comment = $icon . '<span>' . $number . '</span>';
			} else {
				$comment = '<span>' . $number . '</span>' . $icon;
			}

			$comment =
			'<div class="jkit-meta-comment icon-position-' . $icon_position . '">
                <a href="' . jkit_get_respond_link( $post->ID ) . '" >
                    ' . $comment . '
                </a>
            </div>';
		}

		return $comment;
	}

	/**
	 * Get excerpt length
	 *
	 * @return int
	 */
	public function excerpt_length() {
		if ( isset( $this->attribute['sg_content_excerpt_length'] ) ) {
			if ( isset( $this->attribute['sg_content_excerpt_length']['size'] ) ) {
				return intval( $this->attribute['sg_content_excerpt_length']['size'] );
			}

			return intval( $this->attribute['sg_content_excerpt_length'] );
		} else {
			return 20;
		}
	}

	/**
	 * Get excerpt more
	 *
	 * @return string
	 */
	public function excerpt_more() {
		return isset( $this->attribute['sg_content_excerpt_more'] ) ? esc_attr( $this->attribute['sg_content_excerpt_more'] ) : ' ...';
	}

	/**
	 * Filter keys to ajax post request
	 *
	 * @return string
	 */
	public function get_ajax_param() {
		return array(
			'lang',
			'post_type',
			'number_post',
			'post_offset',
			'unique_content',
			'include_post',
			'exclude_post',
			'include_category',
			'exclude_category',
			'include_author',
			'include_tag',
			'exclude_tag',
			'sort_by',
			'sg_content_postblock_type',
			'sg_content_element_order',
			'sg_content_breakpoint',
			'sg_content_image_size_imagesize_size',
			'sg_content_title_html_tag',
			'sg_content_category_enable',
			'sg_content_excerpt_enable',
			'sg_content_excerpt_length',
			'sg_content_excerpt_more',
			'sg_content_readmore_enable',
			'sg_content_readmore_icon',
			'sg_content_readmore_icon_position',
			'sg_content_readmore_text',
			'sg_content_comment_enable',
			'sg_content_comment_icon',
			'sg_content_comment_icon_position',
			'sg_content_meta_enable',
			'sg_content_meta_author_enable',
			'sg_content_meta_author_by_text',
			'sg_content_meta_author_icon',
			'sg_content_meta_author_icon_position',
			'sg_content_meta_date_enable',
			'sg_content_meta_date_type',
			'sg_content_meta_date_format',
			'sg_content_meta_date_format_custom',
			'sg_content_meta_date_icon',
			'sg_content_meta_date_icon_position',
			'st_category_position',
			'pagination_mode',
			'pagination_loadmore_text',
			'pagination_loading_text',
			'pagination_number_post',
			'pagination_scroll_limit',
			'pagination_icon',
			'pagination_icon_position',
		);
	}

	/**
	 * Build primary category element
	 *
	 * @param  int $post_id Post ID.
	 * @return array|null|object|string|\WP_Error
	 */
	public function get_primary_category( $post_id ) {
		$cat_id          = jeg_get_primary_category( $post_id );
		$category_enable = 'yes' === $this->attribute['sg_content_category_enable'];
		$category        = '';

		if ( $category_enable && $cat_id ) {
			$category = get_category( $cat_id );
			$position = 'type-3' === $this->attribute['sg_content_postblock_type'] ? 'position-' . esc_attr( $this->attribute['st_category_position'] ) : '';
			$class    = 'class="category-' . esc_attr( $category->slug ) . '"';
			$category = '<div class="jkit-post-category ' . $position . '"><span><a href="' . esc_url( get_category_link( $cat_id ) ) . '" ' . $class . '>' . esc_attr( $category->name ) . '</a></span></div>';
		}

		return $category;
	}

	/**
	 * Build post meta 1
	 *
	 * @param  int|\WP_Post $post Post object.
	 * @return mixed
	 */
	public function post_meta( $post ) {
		$meta        = null;
		$meta_enable = $this->attribute['sg_content_meta_enable'];

		if ( $meta_enable ) {
			$author_output = null;
			$date_output   = null;

			$author_enable = $this->attribute['sg_content_meta_author_enable'];
			$date_enable   = $this->attribute['sg_content_meta_date_enable'];

			if ( $author_enable ) {
				$author      = $post->post_author;
				$author_url  = esc_url( get_author_posts_url( $author ) );
				$author_name = esc_attr( get_the_author_meta( 'display_name', $author ) );
				$author_by   = esc_attr( $this->attribute['sg_content_meta_author_by_text'] );

				$icon          = $this->render_icon_element( $this->attribute['sg_content_meta_author_icon'] );
				$icon_position = esc_attr( $this->attribute['sg_content_meta_author_icon_position'] );

				if ( 'before' === $icon_position ) {
					$author_output = '<div class="jkit-meta-author icon-position-' . $icon_position . '">' . $icon . '<span class="by">' . $author_by . '</span><a href="' . $author_url . '">' . $author_name . '</a></div>';
				} else {
					$author_output = '<div class="jkit-meta-author icon-position-' . $icon_position . '"><span class="by">' . $author_by . '</span><a href="' . $author_url . '">' . $author_name . '</a>' . $icon . '</div>';
				}
			}

			if ( $date_enable ) {
				$icon          = $this->render_icon_element( $this->attribute['sg_content_meta_date_icon'] );
				$icon_position = esc_attr( $this->attribute['sg_content_meta_date_icon_position'] );

				if ( 'before' === $icon_position ) {
					$date_output = '<div class="jkit-meta-date icon-position-' . $icon_position . '">' . $icon . $this->format_date( $post ) . '</div>';
				} else {
					$date_output = '<div class="jkit-meta-date icon-position-' . $icon_position . '">' . $this->format_date( $post ) . $icon . '</div>';
				}
			}

			$meta = '<div class="jkit-post-meta">' . $author_output . $date_output . '</div>';
		}

		return apply_filters( 'jkit_post_block_meta', $meta, $post, $this );
	}

	/**
	 * Format Date for frontend view.
	 *
	 * @param  int|\WP_Post $post Post object.
	 * @return mixed
	 */
	public function format_date( $post ) {
		$date_type = isset( $this->attribute['sg_content_meta_date_type'] ) ? $this->attribute['sg_content_meta_date_type'] : 'published';

		if ( 'both' === $date_type ) {
			$output = $this->get_post_date( $post, $this->attribute['sg_content_meta_date_format'], 'published', $this->attribute['sg_content_meta_date_format_custom'] );
			$output = $output . esc_html__( ' - Updated on ', 'jeg-elementor-kit' );
			$output = $output . $this->get_post_date( $post, $this->attribute['sg_content_meta_date_format'], 'modified', $this->attribute['sg_content_meta_date_format_custom'] );
		} else {
			$output = $this->get_post_date( $post, $this->attribute['sg_content_meta_date_format'], $date_type, $this->attribute['sg_content_meta_date_format_custom'] );
		}

		return $output;
	}

	/**
	 * Build column type 1 method
	 *
	 * @param array $results Result element.
	 * @return string
	 */
	public function build_column( $results ) {
		$block      = '';
		$image_size = esc_attr( $this->attribute['sg_content_image_size_imagesize_size'] );
		$html_tag   = \Elementor\Utils::validate_html_tag( $this->attribute['sg_content_title_html_tag'] );
		$type       = esc_attr( $this->attribute['sg_content_postblock_type'] );
		$order      = explode( ',', $this->attribute['sg_content_element_order'] );

		foreach ( $results as $post ) {
			$thumbnail        = $this->get_thumbnail( $post->ID, $image_size );
			$primary_category = $this->get_primary_category( $post->ID );
			$post_url         = esc_url( get_the_permalink( $post ) );
			$post_title       = esc_attr( get_the_title( $post ) );
			$content          = '';

			foreach ( $order as $item ) {
				if ( 'title' === $item ) {
					$content .=
						'<' . $html_tag . ' class="jkit-post-title">
							<a href="' . $post_url . '">' . $post_title . '</a>
						</' . $html_tag . '>';
				}

				if ( 'meta' === $item ) {
					$content .= $this->post_meta( $post );
				}

				if ( 'excerpt' === $item ) {
					$content .= $this->get_excerpt( $post );
				}

				if ( 'read' === $item ) {
					$content .=
						'<div class="jkit-post-meta-bottom">
							' . $this->get_readmore( $post, $post_title ) . $this->get_comment_bubble( $post ) . '
						</div>';
				}
			}

			$thumb = jkit_edit_post( $post->ID ) . '<a aria-label="' . $post_title . '" href="' . $post_url . '">' . $thumbnail . '</a>';

			if ( 'type-3' === $type ) {
				$block .=
				'<article ' . jeg_post_class( 'jkit-post', $post->ID ) . '>
                    <div class="jkit-thumb">' . $thumb . $primary_category . '</div>
                    <div class="jkit-postblock-content">' . $content . '</div>
                </article>';
			} else {
				$block .=
				'<article ' . jeg_post_class( 'jkit-post', $post->ID ) . '>
                    <div class="jkit-thumb">' . $thumb . '</div>
                    <div class="jkit-postblock-content">' . $primary_category . $content . '</div>
                </article>';
			}
		}

		return $block;
	}
}
