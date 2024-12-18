<?php
/**
 * Post List View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_List_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_List_View extends View_Abstract {
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

		$class    = 'yes' === $this->attribute['sg_content_background_image_enable'] ? array( 'bg-image' ) : array();
		$class[]  = 'layout-' . esc_attr( $this->attribute['sg_content_layout'] );
		$class[]  = 'post-element';
		$class[]  = 'jkit-pagination-' . esc_attr( $this->attribute['pagination_mode'] );
		$content  = $this->render_block_element();
		$settings = $this->render_settings();

		return $this->render_wrapper(
			'postlist',
			$content,
			$class,
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

		$class   = 'yes' === $this->attribute['sg_content_background_image_enable'] ? array( 'bg-image' ) : array();
		$class[] = 'layout-' . esc_attr( $this->attribute['sg_content_layout'] );
		$class[] = 'post-element';
		$class[] = 'jkit-pagination-' . esc_attr( $this->attribute['pagination_mode'] );

		return $this->render_wrapper(
			'postlist',
			$content,
			$class,
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
			$content = $this->render_column_alt( $results['result'] );
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
			'sg_content_layout',
			'sg_content_image_enable',
			'sg_content_background_image_enable',
			'sg_content_icon_enable',
			'sg_content_icon',
			'sg_content_image_size_imagesize_size',
			'sg_content_meta_enable',
			'sg_content_meta_date_enable',
			'sg_content_meta_date_type',
			'sg_content_meta_date_format',
			'sg_content_meta_date_format_custom',
			'sg_content_meta_date_icon',
			'sg_content_meta_date_icon_position',
			'sg_content_meta_category_enable',
			'sg_content_meta_category_icon',
			'sg_content_meta_position',
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
	 * Build column type 1 method
	 *
	 * @param array $results Result element.
	 * @return string
	 */
	public function build_column( $results ) {
		$block      = '';
		$image_size = $this->attribute['sg_content_image_size_imagesize_size'];

		foreach ( $results as $post ) {
			$content   = null;
			$thumbnail = null;
			$bg        = null;

			if ( 'top' === $this->attribute['sg_content_meta_position'] ) {
				$content = $this->post_meta( $post ) . '<span class="jkit-postlist-title">' . esc_attr( get_the_title( $post ) ) . '</span>';
			} else {
				$content = '<span class="jkit-postlist-title">' . esc_attr( get_the_title( $post ) ) . '</span>' . $this->post_meta( $post );
			}

			if ( 'yes' === $this->attribute['sg_content_image_enable'] ) {
				$thumbnail = get_the_post_thumbnail( $post->ID, $image_size );
			} elseif ( 'yes' === $this->attribute['sg_content_icon_enable'] ) {
					$icon = $this->render_icon_element( $this->attribute['sg_content_icon'] );

				if ( $icon ) {
					$thumbnail = '<span class="icon-list">' . $icon . '</span>';
				}
			}

			if ( 'yes' === $this->attribute['sg_content_background_image_enable'] ) {
				$bg = 'style="background-image: url(' . get_the_post_thumbnail_url( $post->ID, $image_size ) . ')"';
			}

			$block .=
			'<article class="jkit-post post-list-item">
                <a href="' . esc_url( get_the_permalink( $post ) ) . '" ' . $bg . '>
                    ' . $thumbnail . '
                    <div class="jkit-postlist-content">' . $content . '</div>
                </a>
            </article>';
		}

		return $block;
	}

	/**
	 * Get post meta
	 *
	 * @param WP_Post $post Post.
	 * @return mixed
	 */
	public function post_meta( $post ) {
		$meta          = null;
		$meta_date     = null;
		$meta_category = null;

		if ( 'yes' === $this->attribute['sg_content_meta_enable'] ) {
			if ( 'yes' === $this->attribute['sg_content_meta_date_enable'] ) {
				$date_icon = $this->render_icon_element( $this->attribute['sg_content_meta_date_icon'] );
				$date      = esc_attr( $this->format_date( $post ) );

				if ( $date_icon ) {
					$meta_date = $date_icon . $date;
				}

				$meta_date = '<span class="meta-date">' . $meta_date . '</span>';
			}

			if ( 'yes' === $this->attribute['sg_content_meta_category_enable'] ) {
				$category_icon = $this->render_icon_element( $this->attribute['sg_content_meta_category_icon'] );
				$category      = get_category( jeg_get_primary_category( $post->ID ) );

				if ( $category_icon && isset( $category->name ) ) {
					$meta_category = $category_icon . $category->name;
				}

				$meta_category = '<span class="meta-category">' . $meta_category . '</span>';
			}

			$meta = '<div class="meta-lists">' . $meta_date . ' ' . $meta_category . '</div>';
		}

		return apply_filters( 'jkit_post_list_meta', $meta, $post, $this );
	}
}
