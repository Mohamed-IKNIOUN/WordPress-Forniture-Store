<?php
/**
 * Elements WooCommerce Abstract Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

use WC_Query;

/**
 * Class View_WooCommerce_Abstract
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class View_WooCommerce_Abstract extends View_Abstract {
	/**
	 * WC Query Variable
	 *
	 * @var object
	 */
	protected $wc_query;

	/**
	 * Construct
	 *
	 * @param string $id
	 * @param array  $classes
	 */
	public function __construct( $id, $classes ) {
		$this->wc_query = new WC_Query();
		parent::__construct( $id, $classes );
	}

	/**
	 * Include tax query to the product filter
	 *
	 * @param array $args
	 * @param array $data
	 *
	 * @return array
	 */
	public function filter_tax_query( $args, $data ) {
		if ( isset( $args['tax_query'] ) ) {
			array_push( $args['tax_query'], $data );
		} else {
			$args['tax_query'][] = $data;
		}

		return $args;
	}

	/**
	 * Include product filter
	 *
	 * @param array $attr
	 *
	 * @return array
	 */
	public function filter_wc_post_attribute( $attr ) {
		$attr['post_type']   = 'product';
		$attr['post_status'] = 'publish';
		$attr['fields']      = 'ids';
		$attr['taxonomy']    = array();

		if ( ! empty( $attr['wc_include_post'] ) ) {
			if ( ! isset( $attr['include_post'] ) && ! empty( $attr['include_post'] ) ) {
				$attr['include_post'] .= ',' . $attr['wc_include_post'];
			} else {
				$attr['include_post'] = $attr['wc_include_post'];
			}
		}

		if ( ! empty( $attr['wc_exclude_post'] ) ) {
			if ( ! isset( $attr['exclude_post'] ) && ! empty( $attr['exclude_post'] ) ) {
				$attr['exclude_post'] .= ',' . $attr['wc_exclude_post'];
			} else {
				$attr['exclude_post'] = $attr['wc_exclude_post'];
			}
		}

		if ( ! empty( $attr['wc_include_category'] ) ) {
			$attr['taxonomy'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => explode( ',', $attr['wc_include_category'] ),
				'operator' => 'IN',
			);
		}

		if ( ! empty( $attr['wc_exclude_category'] ) ) {
			$attr['taxonomy'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => explode( ',', $attr['wc_exclude_category'] ),
				'operator' => 'NOT IN',
			);
		}

		if ( ! empty( $attr['wc_include_tag'] ) ) {
			$attr['taxonomy'][] = array(
				'taxonomy' => 'product_tag',
				'field'    => 'term_id',
				'terms'    => explode( ',', $attr['wc_include_tag'] ),
				'operator' => 'IN',
			);
		}

		if ( ! empty( $attr['wc_exclude_tag'] ) ) {
			$wc_exclude_tag     = array(
				'taxonomy' => 'product_tag',
				'field'    => 'term_id',
				'terms'    => explode( ',', $attr['wc_exclude_tag'] ),
				'operator' => 'NOT IN',
			);
			$attr['taxonomy'][] = $wc_exclude_tag;
		}

		$orderby = $attr['sort_by'];
		$order   = null;

		if ( false !== strpos( $attr['sort_by'], 'price' ) ) {
			$orderby = 'price';
			if ( false !== strpos( $attr['sort_by'], 'low' ) ) {
				$order = 'DESC';
			} elseif ( false !== strpos( $attr['sort_by'], 'high' ) ) {
				$order = 'ASC';
			}
		}

		$this->wc_query->get_catalog_ordering_args( $orderby, $order );

		return $attr;
	}
}
