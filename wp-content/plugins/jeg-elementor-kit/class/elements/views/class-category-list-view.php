<?php
/**
 * Category List View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.3.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Category_List_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Category_List_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$results = $this->build_module();
		$content = $this->build_column( $results );
		return $this->render_wrapper( 'categorylist', $content, array( 'layout-' . esc_attr( $this->attribute['sg_content_layout'] ) ) );
	}

	/**
	 * Build Module
	 */
	protected function build_module() {
		$number  = $this->attribute['number_category'];
		$include = $this->attribute['include_category'];
		$sort    = $this->attribute['sort_by'];
		$args    = array(
			'taxonomy' => 'category',
		);

		if ( ! empty( $include ) ) {
			$args['include'] = $include;
		} else {
			$args['number'] = isset( $number['size'] ) ? $number['size'] : $number;
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
		$block    = '';
		$iconlist = '';

		foreach ( $results as $category ) {
			$icon_enable = 'yes' === $this->attribute['sg_content_icon_enable'];

			if ( $icon_enable ) {
				$iconlist = '<span class="icon-list">' . $this->render_icon_element( $this->attribute['sg_content_icon'] ) . '</span>';
			}

			$block .=
			'<div class="jkit-category category-list-item">
                <a href="' . esc_url( get_category_link( $category->term_taxonomy_id ) ) . '">
                    ' . $iconlist . '
                    <div class="jkit-categorylist-content">' . $category->name . '</div>
                </a>
            </div>';
		}

		return $block;
	}
}
