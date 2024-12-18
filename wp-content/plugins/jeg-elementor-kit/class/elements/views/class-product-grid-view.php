<?php
/**
 * Product Grid View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Product_Grid_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Product_Grid_View extends View_WooCommerce_Abstract {
	/**
	 * Post Loop
	 *
	 * @var $post
	 */
	protected $post = null;

	/**
	 * Product Class
	 *
	 * @var $product
	 */
	protected $product = null;

	/**
	 * Render Module
	 *
	 * @param  array  $attr         Array of attribute.
	 * @param  string $column_class Class string.
	 * @return string
	 */
	public function render_element( $attr, $column_class ) {
		$attr = $this->filter_wc_post_attribute( $attr );
		$this->set_attribute( $attr );

		$content    = $this->render_block_element();
		$settings   = $this->render_settings();
		$pagination = 'jkit-pagination-' . esc_attr( $this->attribute['pagination_mode'] );

		return $this->render_wrapper(
			'product-grid',
			$content,
			array( $pagination, 'post-element' ),
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
		$query_param = $this->filter_wc_post_attribute( $query_param );
		$results     = $this->build_query( $query_param );
		$this->wc_query->remove_ordering_args();

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
			'wc_include_post',
			'wc_exclude_post',
			'wc_include_category',
			'wc_exclude_category',
			'wc_include_tag',
			'wc_exclude_tag',
			'sort_by',
			'pagination_mode',
			'pagination_loadmore_text',
			'pagination_loading_text',
			'pagination_number_post',
			'pagination_scroll_limit',
			'pagination_icon',
			'pagination_icon_position',
			'sg_content_column',
			'sg_content_show_element',
			'sg_content_show_button',
			'sg_content_sorting',
			'sg_content_image_heading',
			'sg_content_image_size',
			'sg_content_image_size_imagesize_size',
			'sg_content_sale',
			'sg_content_percentage',
		);
	}

	/**
	 * Render Template
	 */
	public function render_column( $results ) {
		$template = '';
		foreach ( $results as $post ) {
			$ids[] = $post->ID;
		}

		update_meta_cache( 'post', wp_parse_id_list( $ids ) );
		update_object_term_cache( wp_parse_id_list( $ids ), 'product' );

		$show_sorting = isset( $this->attribute['sg_content_sorting'] ) && 'yes' === $this->attribute['sg_content_sorting'];

		if ( $show_sorting ) {
			$template .=
			'<div class="product-order">
				<select class="orderby">
					<option value="default">' . esc_html__( 'Default sorting', 'jeg-elementor-kit' ) . '</option>
					<option value="popularity">' . esc_html__( 'Sort by popularity', 'jeg-elementor-kit' ) . '</option>
					<option value="rating">' . esc_html__( 'Sort by average rating', 'jeg-elementor-kit' ) . '</option>
					<option value="latest">' . esc_html__( 'Sort by latest', 'jeg-elementor-kit' ) . '</option>
					<option value="price_high">' . esc_html__( 'Sort by price: low to high', 'jeg-elementor-kit' ) . '</option>
					<option value="price_low">' . esc_html__( 'Sort by price: high to low', 'jeg-elementor-kit' ) . '</option>
				</select>
			</div>';
		}

		$template .= '<div class="woocommerce">';
		$template .= '<ul class="products jkit-products jkit-align-' . $this->attribute['st_product_block_alignment'] . ' ' . ( ( 'disable' === $this->attribute['pagination_mode'] && ! $show_sorting ) ? '' : 'jkit-ajax-flag' ) . '">';
		$template .= $this->build_column( $results );
		$template .= '</ul>';
		$template .= '</div>';

		return $template;
	}

	/**
	 * Render Template Product
	 *
	 * @param array $result Post IDs.
	 */
	public function build_column( $results ) {
		$template_product = '';

		foreach ( $results as $post ) {
			$this->post    = get_post( $post );
			$this->product = wc_get_product( $this->post );

			$template_product .= '<li class="' . implode( ' ', wc_get_product_class( '', $this->product ) ) . ' jkit-product-block">';
			$template_product .= '<a href="' . esc_url( get_permalink( $this->post ) ) . '" class="jkit-product">';
			$template_product .= $this->render_content_with_order();
			$template_product .= '</a>';
			$template_product .= $this->render_button();
			$template_product .= '</li>';
		}

		return $template_product;
	}

	/**
	 * Render Content with Order
	 */
	public function render_content_with_order() {
		$content = '';
		$orders  = explode( ',', $this->attribute['sg_content_show_element'] );

		foreach ( $orders as $order ) {
			if ( method_exists( $this, 'render_' . $order ) ) {
				$content .= call_user_func( array( $this, 'render_' . $order ) );
			}
		}

		return $content;
	}

	/**
	 * Render Product Category
	 */
	public function render_category() {
		return '<div class="product-categories"><object>' . wc_get_product_category_list( $this->product->get_id(), ', ', '<span>', '</span>' ) . '</object></div>';
	}

	/**
	 * Render Product Title
	 */
	public function render_title() {
		return '<h2 class="product-title">' . get_the_title( $this->post ) . '</h2>';
	}

	/**
	 * Render Product Image
	 */
	public function render_image() {
		$sale    = $this->render_onsale();
		$image   = $this->product->get_image( $this->attribute['sg_content_image_size_imagesize_size'], array( 'class' => 'wp-post-image product-image' ) );
		$content = '<div class="product-link">' . $sale . $image . '</div>';

		return $content;
	}

	/**
	 * Render Product Sale Badge
	 */
	public function render_onsale() {
		$content = '';

		if ( $this->product->is_on_sale() ) {
			$class = sprintf(
				'jkit-onsale-position-%s jkit-onsale-position-%s',
				$this->attribute['st_sale_horizontal_orientation'],
				$this->attribute['st_sale_vertical_orientation']
			);

			if ( ! $this->product->is_type( 'grouped' ) && $this->attribute['sg_content_percentage'] ) {
				if ( $this->product->is_type( 'variable' ) ) {
					$prices           = $this->product->get_variation_prices();
					$regular_price    = $prices['regular_price'];
					$sale_price       = $prices['sale_price'];
					$price_percentage = array();

					foreach ( $prices['price'] as $key => $value ) {
						if ( ! empty( $regular_price[ $key ] ) ) {
							$percentage = round( 100 - ( $sale_price[ $key ] / $regular_price[ $key ] * 100 ) );

							if ( $percentage > 0 ) {
								$price_percentage[] = $percentage;
							}
						}
					}

					if ( ! empty( $price_percentage ) ) {
						asort( $price_percentage );
						$percentage = $price_percentage[0] . '%';

						if ( count( $price_percentage ) > 1 ) {
							$percentage .= '-' . end( $price_percentage ) . '%';
						}

						$content .= '<span class="onsale percent ' . $class . '">' . $percentage . '</span>';
					}
				} else {
					$regular_price = (float) $this->product->get_regular_price();
					$sale_price    = (float) $this->product->get_price();

					if ( ! empty( $regular_price ) ) {
						$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';

						$content .= '<span class="onsale percent ' . $class . '">' . $percentage . '</span>';
					}
				}
			}

			if ( $this->attribute['sg_content_sale'] ) {
				$content .= '<span class="onsale text ' . $class . '">' . esc_html__( 'Sale', 'jeg-elementor-kit' ) . '</span>';
			}
		}

		return $content;
	}

	/**
	 * Render Product Rating
	 */
	public function render_rating() {
		$rating = $this->product->get_average_rating();
		// $count = $this->product->get_rating_counts();
		if ( 0 < $rating ) {
			/* translators: %s: rating */
			$label = sprintf( __( 'Rated %s out of 5', 'jeg-elementor-kit' ), $rating );
			$star  = '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
			$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . $star . '</div>';
			return $html;
		}
	}

	/**
	 * Render Product Price
	 */
	public function render_price() {
		if ( $price_html = $this->product->get_price_html() ) {
			return '<span class="price">' . $price_html . '</span>';
		}
	}

	/**
	 * Render Button
	 */
	public function render_button() {
		if ( isset( $this->attribute['sg_content_show_button'] ) && 'yes' !== $this->attribute['sg_content_show_button'] ) {
			return '';
		}

		$class = implode(
			' ',
			array(
				'button',
				'product_type_' . $this->product->get_type(),
				$this->product->is_purchasable() && $this->product->is_in_stock() ? 'add_to_cart_button' : '',
				$this->product->supports( 'ajax_add_to_cart' ) && $this->product->is_purchasable() && $this->product->is_in_stock() ? 'ajax_add_to_cart' : '',
			)
		);

		$attributes = array(
			'data-product_id'  => $this->product->get_id(),
			'data-product_sku' => $this->product->get_sku(),
			'aria-label'       => $this->product->add_to_cart_description(),
			'rel'              => 'nofollow',
		);

		$html = sprintf(
			'<a href="%s" data-quantity="1" class="%s" %s><i class="fas fa-shopping-cart"></i> %s</a>',
			esc_url( $this->product->add_to_cart_url() ),
			$class,
			wc_implode_html_attributes( $attributes ),
			esc_html( $this->product->add_to_cart_text() )
		);

		return $html;
	}
}
