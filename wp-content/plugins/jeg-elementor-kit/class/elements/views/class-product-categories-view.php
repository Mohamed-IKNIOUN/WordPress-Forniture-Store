<?php
/**
 * Product Categories View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Product_Categories_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Product_Categories_View extends View_WooCommerce_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$results = $this->build_module();
		$content = $this->build_column( $results );
		return $this->render_wrapper( 'product-categories', $content, array( 'display-' . esc_attr( $this->attribute['sg_content_display'] ), 'layout-' . esc_attr( $this->attribute['sg_content_layout'] ), 'content-position-' . esc_attr( $this->attribute['sg_content_position'] ), 'text-layout-' . esc_attr( $this->attribute['sg_content_text_layout'] ) ) );
	}

	/**
	 * Build Module
	 */
	protected function build_module() {
		$number  = $this->attribute['number_category'];
		$include = $this->attribute['wc_include_category'];
		$sort    = $this->attribute['sort_by'];
		$args    = array(
			'taxonomy' => 'product_cat',
		);

		if ( ! empty( $include ) ) {
			$args['include'] = $include;
		} else {
			$args['number']  = isset( $number['size'] ) ? $number['size'] : $number;
			$args['exclude'] = $this->attribute['wc_exclude_category'];
		}

		switch ( $sort ) {
			case 'latest':
				$args['order_by'] = 'id';
				$args['order']    = 'DESC';
				break;
			case 'oldest':
				$args['order_by'] = 'id';
				$args['order']    = 'ASC';
				break;
			case 'alphabet_asc':
				$args['order_by'] = 'name';
				$args['order']    = 'ASC';
				break;
			case 'alphabet_desc':
				$args['order_by'] = 'name';
				$args['order']    = 'DESC';
				break;
			case 'number_post_asc':
				$args['order_by'] = 'count';
				$args['order']    = 'ASC';
				break;
			case 'number_post_desc':
				$args['order_by'] = 'count';
				$args['order']    = 'DESC';
				break;
		}

		$results = get_terms( $args );

		return $results;
	}

	/**
	 * Build Column
	 *
	 * @param array $results Results.
	 */
	protected function build_column( $results ) {
		$block     = '';
		$thumbnail = '';
		$count     = '';

		foreach ( $results as $category ) {
			$show_thumbnail = 'yes' === $this->attribute['sg_content_show_thumbnail'];
			$show_count     = 'yes' === $this->attribute['sg_content_show_count'];
			$category_link  = get_category_link( $category );

			if ( $show_thumbnail ) {
				$thumbnail_attr = array(
					'id' => get_term_meta( $category->term_id, 'thumbnail_id', true ),
				);
				$thumbnail      = '<div class="jkit-category-thumbnail">' . $this->render_image_element( $thumbnail_attr, $this->attribute['sg_content_thumbnail_size_imagesize_size'] ) . '</div>';
			}

			if ( $show_count ) {
				$count = ' <span class="jkit-product-category-count">(' . $category->count . ')</span>';
			}

			if ( 'before' === $this->attribute['sg_content_position'] ) {
				$block .=
				'<div class="jkit-product-category">
					<a href="' . esc_url( $category_link ) . '">
						<div class="jkit-product-category-content">' . $category->name . $count . '</div>
						' . $thumbnail . '
					</a>
				</div>';
			} else {
				$block .=
				'<div class="jkit-product-category">
					<a href="' . esc_url( $category_link ) . '">
						' . $thumbnail . '
						<div class="jkit-product-category-content">' . $category->name . $count . '</div>
					</a>
				</div>';
			}
		}

		return $block;
	}
}
