<?php
/**
 * Product Carousel View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Product_Carousel_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Product_Carousel_View extends View_WooCommerce_Abstract {
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

		$arrow_position = 'arrow-' . esc_attr( $this->attribute['sg_carousel_arrow_position'] );

		$content  = $this->render_block_element();
		$settings = $this->render_option();

		return $this->render_wrapper(
			'product-carousel',
			$content,
			array( 'jkit-postblock', 'post-element', $arrow_position ),
			array(
				'id'       => $this->unique_id,
				'settings' => $settings,
			)
		);
	}

	/**
	 * Render Template
	 */
	public function render_column( $results ) {
		$content = $this->build_column( $results );
		$wrapper = '<div class="products jkit-products">' . $content . '</div>';
		$wrapper = '<div class="woocommerce">' . $wrapper . '</div>';

		return $wrapper;
	}

	public function build_column( $results ) {
		$block = '';
		foreach ( $results as $post ) {
			$this->post    = get_post( $post );
			$this->product = wc_get_product( $this->post );

			$content = $this->render_content_with_order();
			$link    = '<a href="' . esc_url( $this->product->get_permalink() ) . '" class="jkit-product-link">' . $content . '</a>';
			$button  = $this->render_button();
			$wrapper = '<div class="jkit-product-block-wrapper">' . $link . $button . '</div>';
			$block  .= '<div class="product jkit-product-block">' . $wrapper . '</div>';
		}

		return $block;
	}

	/**
	 * Render Content with Order
	 */
	public function render_content_with_order() {
		$content = '';
		$orders  = explode( ',', $this->attribute['sg_content_show_element'] );

		foreach ( $orders as $order ) {
			$content .= call_user_func( array( $this, 'render_' . $order ) );
		}

		return $content;
	}

	/**
	 * Render Product Title
	 */
	public function render_title() {
		return '<h2 class="product-title">' . get_the_title( $this->post ) . '</h2>';
	}

	/**
	 * Render Product Category
	 */
	public function render_category() {
		return '<div class="jkit-product-categories"><object>' . wc_get_product_category_list( $this->product->get_id(), '<span>, </span>', ) . '</object></div>';
	}

	/**
	 * Render Product Title
	 */
	public function render_image() {
		$sale    = $this->render_onsale();
		$image   = $this->product->get_image( $this->attribute['sg_content_image_size_imagesize_size'], array( 'class' => 'wp-post-image product-image jkit-product-image' ) );
		$content = '<div class="jkit-product-image-block">' . $sale . $image . '</div>';

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
				$this->attribute['st_product_sale_horizontal_orientation'],
				$this->attribute['st_product_sale_vertical_orientation']
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
		$html   = '';
		$rating = $this->product->get_average_rating();
		// $count = $this->product->get_rating_counts();
		if ( 0 < $rating ) {
			/* translators: %s: rating */
			$label = sprintf( __( 'Rated %s out of 5', 'jeg-elementor-kit' ), $rating );
			$star  = '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
			$html  = '<div class="jkit-product-rating"><div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . $star . '</div></div>';
		}
		return $html;
	}

	/**
	 * Render Product Title
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

	/**
	 * Render Option
	 */
	private function render_option() {
		$default   = array(
			'widescreen'   => array(
				'items'  => 4,
				'margin' => 10,
			),
			'dekstop'      => array(
				'items'  => 4,
				'margin' => 10,
			),
			'laptop'       => array(
				'items'  => 4,
				'margin' => 10,
			),
			'tablet_extra' => array(
				'items'  => 4,
				'margin' => 10,
			),
			'tablet'       => array(
				'items'  => 3,
				'margin' => 10,
			),
			'mobile_extra' => array(
				'items'  => 3,
				'margin' => 10,
			),
			'mobile'       => array(
				'items'  => 1,
				'margin' => 10,
			),
		);
		$nav_left  = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_carousel_arrow_left'] ) );
		$nav_right = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_carousel_arrow_right'] ) );
		$items     = ! empty( $this->attribute['sg_carousel_slide_show_responsive']['size'] ) ? $this->attribute['sg_carousel_slide_show_responsive']['size'] : $default['dekstop']['items'];
		$margin    = ! empty( $this->attribute['sg_carousel_margin_responsive']['size'] ) ? $this->attribute['sg_carousel_margin_responsive']['size'] : $default['dekstop']['margin'];

		$prev_key              = 'desktop';
		$responsive['desktop'] = array(
			'items'      => $items,
			'margin'     => $margin,
			'breakpoint' => 0,
		);

		foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
			$responsive[ $breakpoint['key'] ]      = array(
				'items'      => $default[ $breakpoint['key'] ]['items'],
				'margin'     => $default[ $breakpoint['key'] ]['margin'],
				'breakpoint' => 0,
			);
			$responsive[ $prev_key ]['breakpoint'] = $breakpoint['value'] + 1;

			if ( isset( $this->attribute[ 'sg_carousel_slide_show_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['items'] = ! empty( $this->attribute[ 'sg_carousel_slide_show_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_carousel_slide_show_responsive_' . $breakpoint['key'] ]['size'] : $responsive[ $prev_key ]['items'];
			}

			if ( isset( $this->attribute[ 'sg_carousel_margin_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['margin'] = ! empty( $this->attribute[ 'sg_carousel_margin_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_carousel_margin_responsive_' . $breakpoint['key'] ]['size'] : $responsive[ $prev_key ]['margin'];
			}

			$prev_key = $breakpoint['key'];
		}

		$options = array(
			'autoplay'             => 'yes' === $this->attribute['sg_carousel_autoplay'],
			'autoplay_speed'       => ! empty( $this->attribute['sg_carousel_autoplay_speed']['size'] ) ? intval( $this->attribute['sg_carousel_autoplay_speed']['size'] ) : '',
			'autoplay_hover_pause' => 'yes' === $this->attribute['sg_carousel_autoplay_pause'],
			'show_navigation'      => 'yes' === $this->attribute['sg_carousel_arrow'],
			'navigation_left'      => $nav_left,
			'navigation_right'     => $nav_right,
			'show_dots'            => 'yes' === $this->attribute['sg_carousel_dots'],
			'arrow_position'       => 'top-left' === $this->attribute['sg_carousel_arrow_position'] || 'top-right' === $this->attribute['sg_carousel_arrow_position'] ? 'top' : 'bottom',
			'responsive'           => $responsive,
		);

		return htmlspecialchars( wp_json_encode( $options ), ENT_QUOTES, 'UTF-8' );
	}
}
