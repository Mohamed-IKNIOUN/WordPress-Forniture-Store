<?php
/**
 * Elements View Abstract Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

use Jeg\Element\Elements\Elements_View_Abstract;
use Elementor\Icons_Manager;

/**
 * Class View_Abstract
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class View_Abstract extends Elements_View_Abstract {
	/**
	 * Temporary Attr
	 *
	 * @var array
	 */
	public $attr = array();

	/**
	 * Render element for frontend site
	 *
	 * @param array  $attr Options.
	 * @param string $column_class Column class.
	 *
	 * @return mixed
	 */
	public function render_frontend( $attr, $column_class ) {
		$this->set_attribute( $attr );
		return $this->build_content( $attr );
	}

	/**
	 * Render element for backend editor
	 *
	 * @param array  $attr Options.
	 * @param string $column_class Column class.
	 *
	 * @return mixed
	 */
	public function render_backend( $attr, $column_class ) {
		$this->set_attribute( $attr );
		return $this->build_content( $attr );
	}

	/**
	 * Build block content
	 * Extended by each element
	 */
	public function build_content() {
		return null;
	}

	/**
	 * Render element
	 *
	 * @param array  $attr Options.
	 * @param string $column_class Column class.
	 */
	public function render_element( $attr, $column_class ) {
		$this->set_attribute( $attr );
		return $this->build_content( $attr );
	}

	/**
	 * Render result element
	 *
	 * @param array $result Result element.
	 * @param array $attr Options.
	 */
	public function render_result_element( $result, $attr ) {
		$this->set_attribute( $attr );
		return $this->build_content( $attr );
	}

	/**
	 * Build URL element from given setting
	 *
	 * @param array  $attr URL options.
	 * @param string $additional_id ID.
	 * @param string $additional_class Class.
	 * @param string $child_element Element wrapped by URL.
	 * @param string $data_attribute Data attribute.
	 *
	 * @return string
	 */
	protected function render_url_element( $attr, $additional_id = null, $additional_class = null, $child_element = null, $data_attribute = null ) {
		$id                = ! empty( $additional_id ) ? ' id="' . $additional_id . '" ' : '';
		$class             = ! empty( $additional_class ) ? ' class="' . $additional_class . '" ' : '';
		$target            = 'on' === $attr['is_external'] ? ' target="_blank" ' : '';
		$nofollow          = 'on' === $attr['nofollow'] ? ' rel="nofollow" ' : '';
		$custom_attributes = ' ';

		foreach ( explode( ',', $attr['custom_attributes'] ) as $attribute ) {
			if ( $attribute ) {
				$value             = explode( '|', $attribute );
				$custom_attributes = $custom_attributes . ' ' . $value[0] . '="' . $value[1] . '" ';
			}
		}

		return wp_kses_post( '<a href="' . esc_url( $attr['url'] ) . '" ' . $id . $class . $target . $nofollow . $custom_attributes . $data_attribute . '>' . $child_element . '</a>' );
	}

	/**
	 * Build image element from given setting
	 *
	 * @param array  $attr Image options.
	 * @param string $image_size Image size.
	 * @param string $additional_id ID.
	 * @param string $additional_class Class.
	 * @param string $additional_alt Alt.
	 *
	 * @return string
	 */
	protected function render_image_element( $attr, $image_size = 'thumbnail', $additional_id = null, $additional_class = null, $additional_alt = null ) {
		if ( ! empty( $attr['id'] ) ) {
			$attachment_id = $attr['id'];
			unset( $attr['id'] );

			if ( ! empty( $additional_id ) ) {
				$attr['id'] = $additional_id;
			}

			if ( ! empty( $additional_class ) ) {
				$attr['class'] = $additional_class;
			}

			if ( ! empty( $additional_alt ) ) {
				$attr['alt'] = $additional_alt;
			}

			foreach ( $attr as $key => $data ) {
				if ( empty( $data ) ) {
					unset( $attr[ $key ] );
				}
			}

			$attr = apply_filters( 'jkit_render_image_element', $attr, $this->attribute );

			return wp_get_attachment_image( $attachment_id, $image_size, false, $attr );
		}

		$id         = ! empty( $additional_id ) ? ' id="' . $additional_id . '"' : '';
		$class      = ! empty( $additional_class ) ? ' class="' . $additional_class . '"' : '';
		$alt        = ! empty( $additional_alt ) ? ' alt="' . $additional_alt . '"' : ( isset( $attr['alt'] ) && ! empty( $attr['alt'] ) ? ' alt="' . $attr['alt'] . '"' : '' );
		$width      = ! empty( $attr['width'] ) ? ' width="' . $attr['width'] . '"' : '';
		$height     = ! empty( $attr['height'] ) ? ' height="' . $attr['height'] . '"' : '';
		$attachment = ! empty( $attr['id'] ) ? wp_get_attachment_image_src( $attr['id'], $image_size ) : '';
		$image      = ! empty( $attachment[0] ) ? '<img src="' . esc_url( $attachment[0] ) . '" ' . $id . $class . $alt . $width . $height . '>' : '';
		$image      = ! empty( $attr['url'] ) && empty( $image ) ? '<img src="' . esc_url( $attr['url'] ) . '" ' . $id . $class . $alt . $width . $height . '>' : $image;

		ob_start();
		\Elementor\Utils::print_wp_kses_extended( $image, array( 'image' ) );
		return ob_get_clean();
	}

	/**
	 * Build icon element from given setting. Use Elementor Icon Manager. Render as string
	 *
	 * @param array $icon Icon options from the setting.
	 * @param array $attr Additonal attribute. Default: aria-hidden true.
	 *
	 * @return string
	 */
	protected function render_icon_element( $icon, $attr = array() ) {
		$attr = array_merge( $attr, array( 'aria-hidden' => 'true' ) );

		ob_start();
		Icons_Manager::render_icon( $icon, $attr );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Build element with wrapper
	 *
	 * @param string $element_name Element name.
	 * @param string $inner Inner element.
	 * @param array  $array_classes Classes.
	 * @param array  $array_data Data attribute.
	 * @param array  $id Element ID.
	 *
	 * @return string
	 */
	protected function render_wrapper( $element_name, $inner, $array_classes = array(), $array_data = array(), $id = null ) {
		$classes = '';
		$data    = '';

		foreach ( $array_classes as $class ) {
			$classes = $classes . ' ' . $class;
		}

		foreach ( $array_data as $key => $value ) {
			$data = $data . ' data-' . $key . '="' . esc_attr( $value ) . '"';
		}

		if ( $id ) {
			$id = 'id="' . esc_attr( $id ) . '"';
		}

		$classes = esc_attr( 'jeg-elementor-kit jkit-' . $element_name . $classes . ' ' . $this->unique_id );

		return '<div ' . $id . ' class="' . $classes . '" ' . $data . '>' . $inner . '</div>';
	}

	/**
	 * Get post date
	 *
	 * @param int|\WP_Post $post Post.
	 * @param string       $format Format.
	 * @param string       $type Type.
	 * @param string       $custom Custom format.
	 *
	 * @return false|string
	 */
	public function get_post_date( $post, $format, $type, $custom ) {
		if ( 'ago' === $format ) {
			$output = jkit_get_post_ago_time( $type, $post );
		} elseif ( 'custom' === $format ) {
			$output = jkit_get_post_date( $custom, $post, $type );
		} else {
			$output = jkit_get_post_date( null, $post, $type );
		}

		return $output;
	}

	/**
	 * Get color scheme
	 *
	 * @return mixed
	 */
	public function color_scheme() {
		return isset( $this->attribute['scheme'] ) ? $this->attribute['scheme'] : '';
	}

	/**
	 * Return empty content element
	 *
	 * @return mixed
	 */
	public function empty_content() {
		$no_content = '<div class="jeg_empty_module">' . esc_attr( $this->attribute['st_nocontent_text'] ) . '</div>';

		return apply_filters( 'jeg_module_no_content', $no_content );
	}

	/**
	 * Get post thumbnail
	 *
	 * @param  int    $post_id Post ID.
	 * @param  string $size    Image size.
	 * @return mixed
	 */
	public function get_thumbnail( $post_id, $size ) {
		$additional_class = '';

		if ( ! has_post_thumbnail( $post_id ) ) {
			$additional_class = 'no_thumbnail';
		}

		$thumbnail =
		'<div class="thumbnail-container ' . $additional_class . '">
            ' . get_the_post_thumbnail( $post_id, $size, array( 'loading' => 'lazy' ) ) . '
        </div>';

		return $thumbnail;
	}

	/**
	 * Render result block element
	 *
	 * @param array $results Results.
	 */
	public function render_result_block_element( $results ) {
		$pagination       = $this->render_pagination( true, false, intval( $this->attribute['max_num_pages'] ) );
		$pagination_align = isset( $this->attribute['pagination_align'] ) ? esc_attr( $this->attribute['pagination_align'] ) : '';

		if ( ! empty( $results ) ) {
			$content = $this->build_column( $results );
		} else {
			$content = $this->empty_content();
		}

		$block      = '<div class="jkit-block-container">' . apply_filters( 'jkit_module_block_container_extend', $content, $this->attribute ) . '</div>';
		$pagination = '<div class="jkit-block-pagination jkit-align' . $pagination_align . '">' . apply_filters( 'jkit_module_block_pagination_extend', $pagination, $this->attribute ) . '</div>';

		if ( 'nextprev' === $this->attribute['pagination_mode'] && 'top' === $this->attribute['pagination_position'] ) {
			$wrapper = $pagination . $block;
		} else {
			$wrapper = $block . $pagination;
		}

		return $wrapper;
	}

	/**
	 * Render pagination
	 *
	 * @param  bool $next Next.
	 * @param  bool $prev Previous.
	 * @param  int  $total Total page.
	 * @return string
	 */
	protected function render_pagination( $next = false, $prev = false, $total = 1 ) {
		$output = '';

		if ( isset( $this->attribute['pagination_mode'] ) ) {
			$pagination_align = isset( $this->attribute['pagination_align'] ) ? esc_attr( $this->attribute['pagination_align'] ) : '';
			if ( 'nextprev' === $this->attribute['pagination_mode'] ) {
				$pagination_button_display = isset( $this->attribute['pagination_button_display'] ) ? esc_attr( $this->attribute['pagination_button_display'] ) : '';

				$prev_class = $prev ? '' : 'disabled';
				$next_class = $next ? '' : 'disabled';

				if ( 'text' === $pagination_button_display ) {
					$prev = isset( $this->attribute['pagination_prev_text'] ) ? $this->attribute['pagination_prev_text'] : '';
					$next = isset( $this->attribute['pagination_next_text'] ) ? $this->attribute['pagination_next_text'] : '';
				} elseif ( 'icon' === $pagination_button_display ) {
					$prev = $this->render_icon_element( $this->attribute['pagination_prev_icon'] );
					$next = $this->render_icon_element( $this->attribute['pagination_next_icon'] );
				}

				$class = sprintf(
					'jkit-block-%s jkit-nextprev-%s',
					$this->attribute['pagination_mode'],
					isset( $this->attribute['pagination_style'] ) ? $this->attribute['pagination_style'] : ''
				);

				$output =
					'<div class="jkit-pagination-button ' . $class . '">
						<a href="#" class="prev ' . $prev_class . '" title="' . esc_html__( 'Previous', 'jeg-elementor-kit' ) . '">' . $prev . '</a>
						<a href="#" class="next ' . $next_class . '" title="' . esc_html__( 'Next', 'jeg-elementor-kit' ) . '">' . $next . '</a>
					</div>';
				$output = '<div class="jkit-block-pagination jkit-align' . $pagination_align . '">' . apply_filters( 'jkit_module_block_pagination_extend', $output, $this->attribute ) . '</div>';
			} elseif ( in_array( $this->attribute['pagination_mode'], array( 'loadmore', 'scrollload' ), true ) && $next ) {
				$icon          = $this->render_icon_element( $this->attribute['pagination_icon'] );
				$icon_position = esc_attr( $this->attribute['pagination_icon_position'] );

				$output = '<a href="#" data-load="' . esc_attr( $this->attribute['pagination_loadmore_text'] ) . '" data-loading="' . esc_attr( $this->attribute['pagination_loading_text'] ) . '">' . esc_attr( $this->attribute['pagination_loadmore_text'] ) . '</a>';

				if ( ! empty( $icon ) ) {
					if ( 'before' === $icon_position ) {
						$output = $icon . $output;
					} else {
						$output = $output . $icon;
					}
				}

				$output = '<div class="jkit-pagination-button jkit-block-' . $this->attribute['pagination_mode'] . ' icon-position-' . $icon_position . '">' . $output . '</div>';
				$output = '<div class="jkit-block-pagination jkit-align' . $pagination_align . '">' . apply_filters( 'jkit_module_block_pagination_extend', $output, $this->attribute ) . '</div>';
			}
		}

		return $output;
	}

	/**
	 * Render Preloader
	 *
	 * @return string
	 */
	protected function render_preloader() {
		$output = '';

		if ( ( isset( $this->attribute['pagination_mode'] ) && 'nextprev' === $this->attribute['pagination_mode'] ) || ( isset( $this->attribute['sg_content_sorting'] ) && 'yes' === $this->attribute['sg_content_sorting'] ) ) {
			$output =
				'<div class="jkit-preloader-overlay">
					<div class="jkit-preloader-type jkit-preloader-dot">
						<div class="jkit-preloader">
							<span></span><span></span><span></span>
						</div>
					</div>
				</div>';
		}

		return $output;
	}

	/**
	 * Get settings attribute
	 *
	 * @return string
	 */
	protected function render_settings() {
		if ( $this->unique_id ) {
			$keys = array_merge( $this->get_ajax_param(), array_keys( jeg_get_enabled_custom_taxonomy() ) );

			$attr = array_filter(
				$this->attribute,
				function ( $key ) use ( $keys ) {
					return in_array( $key, $keys, true );
				},
				ARRAY_FILTER_USE_KEY
			);

			$attr['paged'] = 1;
			$attr['class'] = $this->id;

			return htmlspecialchars( wp_json_encode( $attr ), ENT_QUOTES, 'UTF-8' );
		}
	}

	/**
	 * Build query for ajax request
	 *
	 * @param  array $attr Array of attribute.
	 * @return mixed
	 */
	public function build_ajax_query( $attr ) {
		$args                = $attr['attr'];
		$args['paged']       = $attr['current_page'];
		$args['number_post'] = $attr['attr']['number_post'];

		if ( is_array( $attr['attr']['pagination_number_post'] ) ) {
			$args['pagination_number_post'] = 'nextprev' === $attr['attr']['pagination_mode'] ? $attr['attr']['number_post']['size'] : $attr['attr']['pagination_number_post']['size'];
		} else {
			$args['pagination_number_post'] = 'nextprev' === $attr['attr']['pagination_mode'] ? $attr['attr']['number_post'] : $attr['attr']['pagination_number_post'];
		}

		return $args;
	}

	/**
	 * Ajax request handler. Override in element view class.
	 */
	public function ajax_request() {}

	/**
	 * Render column method
	 *
	 * @param  array $result Result.
	 * @return mixed|string
	 */
	public function render_column( $result ) {
		return '<div class="jkit-posts jkit-ajax-flag">
            ' . $this->build_column( $result ) . '
        </div>';
	}

	/**
	 * Render alt column method (ajax request)
	 *
	 * @param  array $result Result.
	 * @return mixed|string
	 */
	public function render_column_alt( $result ) {
		return $this->build_column( $result );
	}

	/**
	 * Get Current Page
	 *
	 * @return mixed
	 */
	public function get_current_page() {
		$page  = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		return max( $page, $paged );
	}

	/**
	 * Render block element
	 *
	 * @return mixed
	 */
	public function render_block_element() {
		if ( isset( $this->attribute['results'] ) ) {
			$results = $this->attribute['results'];
		} else {
			$results = $this->build_query( $this->attribute );
		}

		if ( ! empty( $results['result'] ) ) {
			$content = $this->render_column( $results['result'] );
		} else {
			$content = $this->empty_content();
		}

		$pagination = $this->render_pagination( $results['next'], $results['prev'], $results['total_page'] );
		$block      = '<div class="jkit-block-container">' . apply_filters( 'jkit_module_block_container_extend', $content, $this->attribute ) . $this->render_preloader() . '</div>';

		if ( ( isset( $this->attribute['pagination_mode'] ) && 'nextprev' === $this->attribute['pagination_mode'] ) && 'top' === $this->attribute['pagination_position'] ) {
			$wrapper = $pagination . $block;
		} else {
			$wrapper = $block . $pagination;
		}

		return $wrapper;
	}

	/**
	 * Filter attribute for post query
	 *
	 * @param array $attr Attributes.
	 *
	 * @return array
	 */
	public function filter_post_attribute( $attr ) {
		if ( isset( $attr['content_selection'] ) && 'related' === $attr['content_selection'] ) {
			$post_id   = get_the_ID();
			$post_type = get_post_type( $post_id );
			$category  = $post_tag  = array();

			if ( in_array( $attr['related_filter'], array( 'category', 'both' ), true ) ) {
				$cats = get_the_category( $post_id );

				if ( $cats ) {
					foreach ( $cats as $cat ) {
						$category[] = $cat->term_id;
					}
				}
			}

			if ( in_array( $attr['related_filter'], array( 'tag', 'both' ), true ) ) {
				$tags = get_the_tags( $post_id );

				if ( $tags ) {
					foreach ( $tags as $tag ) {
						$post_tag[] = $tag->term_id;
					}
				}
			}

			if ( ! is_archive() && ! is_search() ) {
				if ( ! empty( $attr['exclude_post'] ) ) {
					$attr['exclude_post'] .= ',' . $post_id;
				} else {
					$attr['exclude_post'] = $post_id;
				}
			}

			if ( ! empty( $post_type ) ) {
				$attr['post_type'] = $post_type;
			} else {
				$attr['post_type'] = array();
			}

			$attr['include_tag']      = implode( ',', $post_tag );
			$attr['include_category'] = implode( ',', $category );

			$this->attr = $attr;

			add_filter(
				'jeg_default_query_args',
				array( $this, 'custom_jeg_query_args' ),
				10,
				2
			);
		}

		if ( jkit_is_multilanguage() ) {
			$attr['lang'] = jkit_get_current_language();
		}

		return $attr;
	}

	/**
	 * Custom Jeg Query Args
	 *
	 * @param array $args
	 * @param array $filtered_attr
	 *
	 * @return array $args
	 */
	public function custom_jeg_query_args( $args, $filtered_attr ) {
		if ( isset( $this->attr['content_selection'] ) && 'related' === $this->attr['content_selection'] ) {
			if ( in_array( $this->attr['related_filter'], array( 'tag', 'both' ), true ) ) {
				if ( empty( $this->attr['include_tag'] ) ) {
					$args['tag__in'] = array( 0 );
				}
			}

			if ( in_array( $this->attr['related_filter'], array( 'category', 'both' ), true ) ) {
				if ( empty( $this->attr['include_category'] ) ) {
					$args['category__in'] = array( 0 );
				}
			}

			if ( $this->attr['related_filter'] === 'none' ) {
				if ( is_archive() || is_search() ) {
					$args = array_merge( $args, $GLOBALS['wp_query']->query );
				}
			}
		}

		remove_filter( 'jeg_default_query_args', array( $this, 'custom_jeg_query_args' ) );

		return $args;
	}

	/**
	 * Check if current page is on the Elementor editor
	 *
	 * @return boolean
	 */
	protected function is_on_editor() {
		if ( isset( $_REQUEST['action'] ) ) {
			if ( ( $_REQUEST['action'] === 'elementor' || $_REQUEST['action'] === 'elementor_ajax' ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Build block content separately
	 */
	protected function build_content_separately( $name ) {
		if ( $this->is_on_editor() || is_preview() ) {
			return $this->build_content_backend( $name );
		} else {
			return $this->build_content_frontend( $name );
		}
	}


	protected function build_content_backend( $name ) {}
	protected function build_content_frontend( $name ) {}
	protected function build_column( $result ) {}
}
