<?php
/**
 * Jeg News Element Ajax Handler
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
class Ajax {
	/**
	 * Ajax constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_jeg_get_category_option', array( $this, 'category_option' ) );
		add_action( 'wp_ajax_jeg_get_author_option', array( $this, 'author_option' ) );
		add_action( 'wp_ajax_jeg_get_tag_option', array( $this, 'tag_option' ) );
		add_action( 'wp_ajax_jeg_get_post_option', array( $this, 'post_option' ) );
		add_action( 'wp_ajax_jeg_get_cpt_option', array( $this, 'cpt_option' ) );
		add_action( 'wp_ajax_jeg_get_custom_term_option', array( $this, 'custom_term_option' ) );

		add_action( 'wp_ajax_jeg_find_custom_term', array( $this, 'find_ajax_custom_term' ) );
		add_action( 'wp_ajax_jeg_find_cpt', array( $this, 'find_ajax_cpt' ) );
		add_action( 'wp_ajax_jeg_find_post', array( $this, 'find_ajax_post' ) );
		add_action( 'wp_ajax_jeg_find_author', array( $this, 'find_ajax_author' ) );
		add_action( 'wp_ajax_jeg_find_tag', array( $this, 'find_ajax_tag' ) );
		add_action( 'wp_ajax_jeg_find_category', array( $this, 'find_ajax_category' ) );
		add_action( 'wp_ajax_jeg_find_post_tag', array( $this, 'find_ajax_post_tag' ) );
	}

	/**
	 * Ajax Request for retrieve category
	 */
	public function category_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_category' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_category_option( $value ) );
		}
	}

	/**
	 * Ajax request for retrieve author
	 */
	public function author_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_author' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_author_option( $value ) );
		}
	}

	/**
	 * Ajax request for retrieve tag
	 */
	public function tag_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_tag' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_tag_option( $value ) );
		}
	}

	/**
	 * Ajax request for retrieve custom term
	 */
	public function custom_term_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_custom_term' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_custom_term_option( $value, $_REQUEST['slug'] ) );
		}
	}

	/**
	 * Ajax request for retrieve post
	 */
	public function post_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_post' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_post_option( $value ) );
		}
	}

	/**
	 * Ajax request for retrieve custom post type
	 */
	public function cpt_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_cpt' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_post_option( $value ) );
		}
	}

	/**
	 * Find Author
	 */
	public function find_ajax_author() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_author' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$users = new \WP_User_Query(
				array(
					'search'         => "*{$query}*",
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
						'user_url',
					),
				)
			);

			$users_found = $users->get_results();

			$result = array();

			if ( count( $users_found ) > 0 ) {
				foreach ( $users_found as $user ) {
					$result[] = array(
						'value' => $user->ID,
						'text'  => $user->display_name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	/**
	 * Find Tag
	 */
	public function find_ajax_tag() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_tag' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'post_tag' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	/**
	 * Find custom term
	 */
	public function find_ajax_custom_term() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_custom_term' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( $_REQUEST['slug'] ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	/**
	 * Find Post
	 */
	public function find_ajax_post() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_post' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			add_filter(
				'posts_where',
				function ( $where ) use ( $query ) {
					global $wpdb;
					$where .= $wpdb->prepare( "AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $query ) . '%' );

					return $where;
				}
			);

			$query = new \WP_Query(
				array(
					'post_type'      => array_keys( jeg_exclude_post_type() ),
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title(),
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}

	/**
	 * Find custom post type
	 */
	public function find_ajax_cpt() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_cpt' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			add_filter(
				'posts_where',
				function ( $where ) use ( $query ) {
					global $wpdb;
					$where .= $wpdb->prepare( "AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $query ) . '%' );

					return $where;
				}
			);

			$query = new \WP_Query(
				array(
					'post_type'      => array( $_REQUEST['slug'] ),
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title(),
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}

	/**
	 * Find Category
	 */
	public function find_ajax_category() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_category' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'category' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
				'number'     => 50,
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	/**
	 * Find Post Tag
	 */
	public function find_ajax_post_tag() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_post_tag' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'post_tag' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => $query,
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json( $result );
		}
	}
}
