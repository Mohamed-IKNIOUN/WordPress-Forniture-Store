<?php
/**
 * Jeg Element Query
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element;

/**
 * Class Ajax
 *
 * @package Jeg\Element
 */
class Query {
	/**
	 * Hold Thumbnail Cache
	 *
	 * @var array
	 */
	private static $thumbnail = array();

	/**
	 * Retrieve Query from defined Attribute
	 *
	 * @param array $attr Attribute.
	 *
	 * @return array
	 */
	public static function get( $attr ) {
		$attr = self::filter_attribute( $attr );

		if ( self::is_jetpack_query( $attr ) ) {
			$result = self::jetpack_query( $attr );
		} else {
			$result = self::default_query( $attr );
		}

		self::optimize_query( $result );

		return $result;
	}

	/**
	 * Check if is jetpack query
	 *
	 * @param array $attr WordPress Jetpack Query.
	 *
	 * @return boolean
	 */
	public static function is_jetpack_query( $attr ) {
		return 'popular_post_jetpack_day' === $attr['sort_by'] || 'popular_post_jetpack_week' === $attr['sort_by'] || 'popular_post_jetpack_month' === $attr['sort_by'] || 'popular_post_jetpack_all' === $attr['sort_by'];
	}

	/**
	 * Build Query of WordPress Default
	 *
	 * @param array $attr Attribute.
	 *
	 * @return array
	 */
	private static function default_query( $attr ) {
		$include_category = array();
		$exclude_category = array();
		$result           = array();
		$args             = array();

		$args['post_type']           = $attr['post_type'];
		$args['paged']               = isset( $attr['paged'] ) ? $attr['paged'] : 1;
		$args['offset']              = self::calculate_offset( $args['paged'], $attr['post_offset'], $attr['number_post'], $attr['pagination_number_post'] );
		$args['posts_per_page']      = ( $args['paged'] > 1 ) ? $attr['pagination_number_post'] : $attr['number_post'];
		$args['no_found_rows']       = ! isset( $attr['pagination_mode'] ) || 'disable' === $attr['pagination_mode'];
		$args['ignore_sticky_posts'] = 1;
		$args['tax_query']           = isset( $attr['taxonomy'] ) && ! empty( $attr['taxonomy'] ) ? $attr['taxonomy'] : array();

		if ( ! empty( $attr['include_post'] ) ) {
			$args['post__in'] = explode( ',', $attr['include_post'] );
		}

		if ( ! empty( $attr['exclude_post'] ) ) {
			$args['post__not_in'] = explode( ',', $attr['exclude_post'] );
		}

		if ( ! empty( $attr['include_category'] ) ) {
			$categories = explode( ',', $attr['include_category'] );
			self::recursive_category( $categories, $include_category );
			$args['category__in'] = $include_category;
		}

		if ( ! empty( $attr['exclude_category'] ) ) {
			$categories = explode( ',', $attr['exclude_category'] );
			self::recursive_category( $categories, $exclude_category );
			$args['category__not_in'] = $exclude_category;
		}

		if ( ! empty( $attr['include_author'] ) ) {
			$args['author__in'] = explode( ',', $attr['include_author'] );
		}

		if ( ! empty( $attr['include_tag'] ) ) {
			$args['tag__in'] = explode( ',', $attr['include_tag'] );
		}

		if ( ! empty( $attr['exclude_tag'] ) ) {
			$args['tag__not_in'] = explode( ',', $attr['exclude_tag'] );
		}

		// order.
		if ( 'latest' === $attr['sort_by'] ) {
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
		}

		if ( 'oldest' === $attr['sort_by'] ) {
			$args['orderby'] = 'date';
			$args['order']   = 'ASC';
		}

		if ( 'alphabet_asc' === $attr['sort_by'] ) {
			$args['orderby'] = 'title';
			$args['order']   = 'ASC';
		}

		if ( 'alphabet_desc' === $attr['sort_by'] ) {
			$args['orderby'] = 'title';
			$args['order']   = 'DESC';
		}

		if ( 'random' === $attr['sort_by'] ) {
			$args['orderby'] = 'rand';
		}

		if ( 'random_week' === $attr['sort_by'] ) {
			$args['orderby']    = 'rand';
			$args['date_query'] = array(
				array(
					'after' => '1 week ago',
				),
			);
		}

		if ( 'random_month' === $attr['sort_by'] ) {
			$args['orderby']    = 'rand';
			$args['date_query'] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}

		if ( 'most_comment' === $attr['sort_by'] ) {
			$args['orderby'] = 'comment_count';
			$args['order']   = 'DESC';
		}

		if ( isset( $attr['video_only'] ) && true === $attr['video_only'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array(
						'post-format-video',
					),
					'operator' => 'IN',
				),
			);
		}

		// date.
		if ( isset( $attr['date_query'] ) ) {
			$args['date_query'] = $attr['date_query'];
		}
		if ( isset( $attr['year'] ) ) {
			$args['year'] = $attr['year'];
		}
		if ( isset( $attr['day'] ) ) {
			$args['day'] = $attr['day'];
		}
		if ( isset( $attr['monthnum'] ) ) {
			$args['monthnum'] = $attr['monthnum'];
		}

		if ( isset( $attr['lang'] ) ) {
			$args['lang'] = $attr['lang'];
		}

		$args['post_status'] = 'publish';

		$args = apply_filters( 'jeg_default_query_args', $args, $attr );

		// Query.
		$query = new \WP_Query( $args );

		foreach ( $query->posts as $post ) {
			$result[] = $post;
		}

		wp_reset_postdata();

		return array(
			'result'     => $result,
			'next'       => self::has_next_page( $query->found_posts, $args['paged'], $args['offset'], $attr['number_post'], $attr['pagination_number_post'] ),
			'prev'       => self::has_prev_page( $args['paged'] ),
			'total_page' => self::count_total_page( $query->found_posts, $args['paged'], $args['offset'], $attr['number_post'], $attr['pagination_number_post'] ),
		);
	}

	/**
	 * Jetpack Query
	 *
	 * @param array $attr Attribute.
	 *
	 * @return array
	 */
	private static function jetpack_query( $attr ) {
		$result = array();

		if ( function_exists( 'stats_get_csv' ) ) {
			switch ( $attr['sort_by'] ) {
				case 'popular_post_jetpack_week':
					$days = 7;
					break;
				case 'popular_post_jetpack_month':
					$days = 30;
					break;
				case 'popular_post_jetpack_day':
					$days = 2;
					break;
				case 'popular_post_jetpack_all':
				default:
					$days = - 1;
					break;
			}

			$top_posts = stats_get_csv(
				'postviews',
				array(
					'days'  => $days,
					'limit' => $attr['number_post'] + 5,
				)
			);

			if ( ! $top_posts ) {
				return array();
			}

			$counter = 0;
			foreach ( $top_posts as $post ) {
				$the_post = get_post( $post['post_id'] );

				if ( ! $the_post ) {
					continue;
				}

				if ( 'post' !== $the_post->post_type ) {
					continue;
				}

				$counter ++;
				$result[] = get_post( $post['post_id'] );

				if ( $counter === $attr['number_post'] ) {
					break;
				}
			}
		}

		return array(
			'result'     => $result,
			'next'       => false,
			'prev'       => false,
			'total_page' => 1,
		);
	}


	/**
	 * Optimize query
	 *
	 * @param array $results array of query result.
	 */
	private static function optimize_query( $results ) {
		self::cache_thumbnail( $results );
	}

	/**
	 * Cache thumbnail so it won't retrieve another on other query.
	 *
	 * @param array $results array of query result.
	 */
	public static function cache_thumbnail( $results ) {
		$thumbnails = array();

		foreach ( $results['result'] as $result ) {
			if ( ! in_array( $result->ID, self::$thumbnail, true ) ) {
				$thumbnails[]      = get_post_thumbnail_id( $result->ID );
				self::$thumbnail[] = $result->ID;
			}
		}

		if ( ! empty( $thumbnails ) ) {
			$query = array(
				'post__in'  => $thumbnails,
				'post_type' => 'attachment',
				'showposts' => count( $thumbnails ),
			);

			get_posts( $query );
		}
	}

	/**
	 * Filter Attribute to only include what necessary.
	 *
	 * @param array $attr Filter Attribute.
	 *
	 * @return array
	 */
	public static function filter_attribute( $attr ) {
		$accepted = array(
			'post_type',
			'number_post',
			'post_offset',
			'include_post',
			'exclude_post',
			'include_category',
			'exclude_category',
			'include_author',
			'include_tag',
			'exclude_tag',
			'sort_by',
			'paged',
			'video_only',
			'pagination_number_post',
			'pagination_mode',
			'date_query',
			'year',
			'monthnum',
			'day',
			'taxonomy',
			'lang',
		);

		$accepted = apply_filters( 'jeg_accept_query_attribute', $accepted, $attr );

		foreach ( $attr as $key => $value ) {
			if ( ! in_array( $key, $accepted, true ) ) {
				unset( $attr[ $key ] );
			}
		}

		if ( isset( $attr['pagination_number_post'] ) ) {
			$attr['pagination_number_post'] = intval( $attr['pagination_number_post'] );
		}

		if ( isset( $attr['paged'] ) ) {
			$attr['paged'] = intval( $attr['paged'] );
		}

		if ( isset( $attr['number_post']['size'] ) ) {
			$attr['number_post'] = $attr['number_post']['size'];
		}

		if ( ! isset( $attr['pagination_number_post'] ) ) {
			$attr['pagination_number_post'] = $attr['number_post'];
		}

		return $attr;
	}

	/**
	 * Get category to its child.
	 *
	 * @param array $categories Category to be checked.
	 * @param array $result Result for recursive category.
	 */
	private static function recursive_category( $categories, &$result ) {
		foreach ( $categories as $category ) {
			if ( ! in_array( $category, $result, true ) ) {
				$result[] = $category;
				$children = get_categories( array( 'parent' => $category ) );

				if ( ! empty( $children ) ) {
					$child_id = array();
					foreach ( $children as $child ) {
						$child_id[] = $child->term_id;
					}
					self::recursive_category( $child_id, $result );
				}
			}
		}
	}

	/**
	 * Calculate Offset
	 *
	 * @param int $paged Current Page.
	 * @param int $offset Offset post.
	 * @param int $number_post Number post for first page.
	 * @param int $number_post_ajax Number post for ajax request.
	 *
	 * @return int
	 */
	private static function calculate_offset( $paged, $offset, $number_post, $number_post_ajax ) {
		$new_offset = 0;

		if ( isset( $offset['size'] ) ) {
			$offset = $offset['size'];
		}

		$paged = (int) $paged;

		if ( 1 === $paged ) {
			$new_offset = (int) $offset;
		}

		if ( 2 === $paged ) {
			$new_offset = $number_post + (int) $offset;
		}

		if ( 3 <= $paged ) {
			$new_offset = $number_post + (int) $offset + ( $number_post_ajax * ( $paged - 2 ) );
		}

		return $new_offset;
	}

	/**
	 * Check if we have next page
	 *
	 * @param int $total Total number of query result.
	 * @param int $curpage Current Page.
	 * @param int $offset Offset post.
	 * @param int $perpage Number post for first page.
	 * @param int $perpage_ajax Number post for ajax request.
	 *
	 * @return bool
	 */
	private static function has_next_page( $total, $curpage = 1, $offset = 0, $perpage = 0, $perpage_ajax = 0 ) {
		$curpage = (int) $curpage;

		if ( 1 === $curpage ) {
			return (int) $total > (int) $offset + (int) $perpage;
		}

		if ( $curpage > 1 ) {
			return (int) $total > (int) $offset + (int) $perpage_ajax;
		}

		return false;
	}

	/**
	 * Check if we have previous page
	 *
	 * @param int $curpage Current Page.
	 *
	 * @return bool
	 */
	private static function has_prev_page( $curpage = 1 ) {
		if ( $curpage <= 1 ) {
			return false;
		}

		return true;
	}

	/**
	 * Get total count of total page
	 *
	 * @param int $total Total number of query result.
	 * @param int $curpage Current Page.
	 * @param int $offset Offset post.
	 * @param int $perpage Number post for first page.
	 * @param int $perpage_ajax Number post for ajax request.
	 *
	 * @return int
	 */
	private static function count_total_page( $total, $curpage = 1, $offset = 0, $perpage = 0, $perpage_ajax = 0 ) {
		$remain = (int) $total - ( (int) $offset + (int) $perpage );

		if ( $remain > 0 ) {
			while ( $remain > 0 ) {
				$remain -= $perpage_ajax;
				$curpage ++;
			}
		}

		return $curpage;
	}
}
