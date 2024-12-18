<?php
/**
 * Jeg Elementor Kit Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Ajax;

use Jeg\Element\Element as Jeg_Element;
use Jeg\Elementor_Kit\Dashboard\Dashboard;
use Jeg\Elementor_Kit\Dashboard\Template\Template_Dashboard_Abstract;
use Jeg\Elementor_Kit\Elements\Views\View_Abstract;
use Jeg\Elementor_Kit\Elements\Element;

/**
 * Class Ajax
 *
 * @package Jeg\Elementor_Kit
 */
class Ajax {
	/**
	 * Frontend ajax endpoint
	 *
	 * @var string
	 */
	private $endpoint = 'jkit-ajax-request';

	/**
	 * Block ajax prefix
	 *
	 * @var string
	 */
	public static $element_ajax_prefix = 'jkit_element_ajax_';

	/**
	 * Element Manager
	 *
	 * @var Elements_Manager
	 */
	public $manager;

	/**
	 * Class instance
	 *
	 * @var Element
	 */
	private static $instance;

	/**
	 * Module constructor.
	 */
	private function __construct() {
		$this->setup_init();
		$this->setup_hook();
	}

	/**
	 * Setup Classes
	 */
	private function setup_init() {
		$this->manager = Jeg_Element::instance()->manager;
	}

	/**
	 * Setup Hooks
	 */
	private function setup_hook() {
		add_action( 'parse_request', array( $this, 'element_ajax_parse_request' ) );
		add_filter( 'query_vars', array( $this, 'ajax_query_vars' ) );

		add_action( 'parse_request', array( $this, 'admin_ajax_parse_request' ) );

		add_action( 'wp_ajax_jkit_create_element', array( $this, 'create_element' ) );
		add_action( 'wp_ajax_jkit_delete_element', array( $this, 'delete_element' ) );
		add_action( 'wp_ajax_jkit_update_sequence', array( $this, 'update_sequence' ) );
		add_action( 'wp_ajax_jkit_clone_element', array( $this, 'clone_element' ) );
		add_action( 'wp_ajax_jkit_detail_element', array( $this, 'detail_element' ) );
		add_action( 'wp_ajax_jkit_update_element', array( $this, 'update_element' ) );

		add_action( 'wp_ajax_jkit_find_taxonomy', array( $this, 'find_taxonomy' ) );
		add_action( 'wp_ajax_jkit_find_author', array( $this, 'find_author' ) );
		add_action( 'wp_ajax_jkit_find_posts_object', array( $this, 'find_posts' ) );
	}

	/**
	 * Get class instance
	 *
	 * @return Ajax
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Parse ajax request handler
	 *
	 * @param WP $wp Current WordPress environment instance (passed by reference).
	 */
	public function element_ajax_parse_request( $wp ) {
		if ( array_key_exists( $this->endpoint, $wp->query_vars ) ) {
			add_filter( 'wp_doing_ajax', array( $this, 'is_doing_ajax' ) );

			$action         = $wp->query_vars['action'];
			$element_prefix = self::$element_ajax_prefix;

			if ( 0 === strpos( $action, $element_prefix ) ) {
				$element_name = str_replace( $element_prefix, '', $action );
				$this->element_ajax( $element_name );
			}

			do_action( 'jkit_elements_ajax_' . $action );
		}
	}

	/**
	 * Parse ajax request handler
	 *
	 * @param WP $wp Current WordPress environment instance (passed by reference).
	 */
	public function admin_ajax_parse_request( $wp ) {
		if ( array_key_exists( $this->endpoint, $wp->query_vars ) ) {
			add_filter( 'wp_doing_ajax', array( $this, 'is_doing_ajax' ) );

			$action = $wp->query_vars['action'];

			if ( isset( $_POST['form_data'], $_POST['nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['nonce'] ), jkit_get_nonce_identifier( 'dashboard' ) ) && current_user_can( 'edit_theme_options' ) ) {
				if ( 'save_user_data' === $action ) {
					// @codingStandardsIgnoreStart sanitize value using jeg_sanitize_array
					$this->save_user_data( jeg_sanitize_array( wp_unslash( $_POST['form_data'] ) ) );
					// @codingStandardsIgnoreEnd
					wp_send_json(
						array(
							'message' => esc_html__( 'Success Save Data', 'jeg-elementor-kit' ),
						),
						200
					);
				} elseif ( 'save_elements_enable' === $action ) {
					// @codingStandardsIgnoreStart sanitize value using jeg_sanitize_array
					$this->save_elements_enable( jeg_sanitize_array( wp_unslash( $_POST['form_data'] ) ) );
					// @codingStandardsIgnoreEnd
					wp_send_json(
						array(
							'message' => esc_html__( 'Success Save Data', 'jeg-elementor-kit' ),
						),
						200
					);
				} elseif ( 'save_settings' === $action ) {
					// @codingStandardsIgnoreStart sanitize value using jeg_sanitize_array
					$this->save_settings( jeg_sanitize_array( wp_unslash( $_POST['form_data'] ) ) );
					// @codingStandardsIgnoreEnd
					wp_send_json(
						array(
							'message' => esc_html__( 'Success Save Data', 'jeg-elementor-kit' ),
						),
						200
					);
				} elseif ( 'save_notfound' === $action ) {
					$this->save_notfound( jeg_sanitize_array( wp_unslash( $_POST['form_data'] ) ) );

					wp_send_json(
						array(
							'message' => esc_html__( 'Success Save Data', 'jeg-elementor-kit' ),
						),
						200
					);
				}
			}

			do_action( 'jkit_elements_ajax_' . $action );
			exit;
		}
	}

	/**
	 * Handle block ajax request
	 *
	 * @param string $element_ajax Element ajax.
	 * @return mixed
	 */
	public function element_ajax( $element_ajax ) {
		$this->element_name_ajax = $element_ajax;
		add_filter( 'jeg_register_elements', array( $this, 'register_ajax_element' ) );
		$instance = $this->manager->get_element_view( $element_ajax );

		if ( $instance instanceof View_Abstract ) {
			$instance->ajax_request();
		} else {
			return null;
		}
	}

	/**
	 * Register module element for ajax
	 *
	 * @param  array $elements Elements.
	 * @return array
	 */
	public function register_ajax_element( $elements ) {
		$name      = str_replace( 'jkit_', '', $this->element_name_ajax );
		$namespace = '\Jeg\Elementor_Kit\Elements';

		$elements[ $this->element_name_ajax ] = array(
			'option' => $namespace . '\Options\\' . ucwords( $name ) . '_Option',
			'view'   => $namespace . '\Views\\' . ucwords( $name ) . '_View',
		);

		return $elements;
	}

	/**
	 * Register ajax query vars
	 *
	 * @param  string[] $vars The array of allowed query variable names.
	 * @return array
	 */
	public function ajax_query_vars( $vars ) {
		$vars[] = $this->endpoint;
		$vars[] = 'action';

		return $vars;
	}

	/**
	 * Doing ajax flag
	 *
	 * @return bool
	 */
	public function is_doing_ajax() {
		return true;
	}

	/**
	 * Save User Data
	 *
	 * @param array $data User data.
	 */
	public function save_user_data( $data ) {
		if ( isset( $data['mailchimp_api_key'] ) ) {
			$save = array(
				'mailchimp' => array(
					'api_key' => $data['mailchimp_api_key'],
				),
			);

			$split = explode( '-', $data['mailchimp_api_key'] );

			if ( '' !== $data['mailchimp_api_key'] && ( ! isset( $split[1] ) || empty( $split[1] ) || preg_match( '/^.*\..+$/', $split[1] ) ) ) {
				wp_send_json(
					array(
						'message' => esc_html__( 'API Key is Invalid.', 'jeg-elementor-kit' ),
					),
					400
				);
			}

			if ( isset( $split[1] ) ) {
				$dc = $split[1];

				$response = wp_remote_request(
					'https://' . $dc . '.api.mailchimp.com/3.0/?fields=account_id',
					array(
						'method'  => 'GET',
						'headers' =>
						array(
							'Authorization' => sprintf( 'Basic %s', base64_encode( 'mc4wp:' . $data['mailchimp_api_key'] ) ),
						),
						'timeout' => 30,
					)
				);

				$mc_response = json_decode( wp_remote_retrieve_body( $response ) );
			}

			if ( '' === $data['mailchimp_api_key'] || is_object( $mc_response ) && property_exists( $mc_response, 'account_id' ) ) {
				update_option( 'jkit_user_data', $save );
			} else {
				wp_send_json(
					array(
						'message' => $mc_response ? $mc_response->detail : 'API Key is Invalid',
					),
					$mc_response ? $mc_response->status : 400
				);
			}
		}
	}

	/**
	 * Save User Data
	 *
	 * @param array $data User data.
	 */
	public function save_settings( $data ) {
		$global_style_id = isset( $data['global_style'] ) ? $data['global_style'] : '';

		update_option( 'elementor_active_kit', $global_style_id );
	}

	/**
	 * Save Notfound Template
	 *
	 * @param array $data Notfound template
	 */
	public function save_notfound( $data ) {
		$notfound_template = isset( $data['notfound_template'] ) ? $data['notfound_template'] : '';

		update_option( 'jkit_notfound_template', $notfound_template );
	}

	/**
	 * Find Taxonomy
	 */
	public function find_taxonomy() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$result = array();
			$query  = sanitize_text_field( wp_unslash( $_POST['query'] ) );
			$slug   = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';

			if ( '' !== $query ) {
				$args = array(
					'name__like' => $query,
				);

				if ( $slug ) {
					$args['taxonomy'] = $slug;
				}

				$terms = get_terms( $args );

				foreach ( $terms as $key => $term ) {
					$label = '';

					if ( ! $slug ) {
						$taxonomy = get_taxonomy( $term->taxonomy );
						$label    = ' - ' . $taxonomy->label;
					}

					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name . $label,
					);
				}
			}

			wp_send_json_success( $result );
		}

		wp_send_json_error();
	}

	/**
	 * Find all post type
	 */
	public function find_posts() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			add_filter(
				'posts_where',
				function ( $where ) use ( $query ) {
					global $wpdb;
					$where .= $wpdb->prepare( "AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $query ) . '%' );

					return $where;
				}
			);

			$args = array(
				'posts_per_page' => '15',
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			);

			if ( isset( $_REQUEST['slug'] ) && $_REQUEST['slug'] ) {
				$args['post_type'] = array( sanitize_text_field( wp_unslash( $_REQUEST['slug'] ) ) );
			} else {
				$args['post_type'] = jkit_get_public_post_type_array();
			}

			$query = new \WP_Query( $args );

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$post_type = get_post_type_object( get_post_type() );
					$result[]  = array(
						'value' => get_the_ID(),
						'text'  => get_the_title() . ' - ' . $post_type->labels->singular_name,
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
		wp_send_json_error();
	}

	/**
	 * Find Author
	 */
	public function find_author() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$values = '';

			if ( isset( $_POST['value'] ) && $_POST['value'] ) {
				$values = sanitize_text_field( wp_unslash( $_POST['value'] ) );
			}

			wp_send_json_success( $values );
		}
		wp_send_json_error();
	}

	/**
	 * Nonce valid
	 *
	 * @return bool
	 */
	public function is_nonce_valid( $slug = '' ) {
		return isset( $_POST['action'], $_POST['nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['nonce'] ), jkit_get_nonce_identifier( $slug ) );
	}

	/**
	 * Clone
	 */
	public function clone_element() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$data    = jeg_sanitize_array( $_POST );
			$post_id = $this->duplicate_element( $data['id'] );

			$published = jkit_get_element_data( $_POST['type'] )['publish'];
			$keys      = jkit_extract_ids( $published );
			$keys      = jkit_remove_array( $post_id, $keys );
			array_unshift( $keys, $post_id );
			$this->update_post_sequence( $keys );

			$element = apply_filters( 'jkit_element_data_clone', jkit_get_element_data( $_POST['type'] ), $_POST['type'], $_POST['page'] );
			wp_send_json_success( $element );
		}
	}

	/**
	 * JKit Update Sequence
	 *
	 * @param $ids
	 */
	public function update_post_sequence( $ids ) {
		foreach ( $ids as $sequence => $id ) {
			wp_update_post(
				array(
					'ID'         => $id,
					'menu_order' => $sequence,
				)
			);
		}
	}

	/**
	 * Duplicate Element
	 *
	 * @param $post_id
	 *
	 * @return int|\WP_Error
	 */
	public function duplicate_element( $post_id ) {
		$title       = get_the_title( $post_id ) . ' ' . esc_html__( 'Clone', 'jeg-elementor-kit' );
		$oldpost     = get_post( $post_id );
		$post        = array(
			'post_title'  => $title,
			'post_status' => 'publish',
			'post_type'   => $oldpost->post_type,
			'post_author' => 1,
		);
		$new_post_id = wp_insert_post( $post );

		$data = get_post_custom( $post_id );
		foreach ( $data as $key => $values ) {
			$value = get_post_meta( $post_id, $key, true );
			add_post_meta( $new_post_id, $key, $value );
		}

		return $new_post_id;
	}


	/**
	 * Create Element
	 */
	public function create_element() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$post_type = sanitize_key( $_POST['type'] );
			$published = jkit_get_element_data( $post_type )['publish'];
			$keys      = jkit_extract_ids( $published );
			$data      = jeg_sanitize_array( $_POST ['data'] );
			$condition = isset( $data['condition'] ) ? $data['condition'] : '';
			$post_args = array(
				'post_title'  => $data['option']['title'],
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'meta_input'  => array(
					'_elementor_edit_mode'     => 'builder',
					'_elementor_template_type' => 'page',
					'_elementor_data'          => json_encode( array() ),
					'_wp_page_template'        => 'elementor_canvas',
				),
			);
			$meta      = null;

			if ( isset( $post_type ) && 'jkit-template' === $post_type ) {
				$page = sanitize_key( $_POST['page'] );
				$post_args['meta_input']['_wp_page_template']  = 'elementor_header_footer';
				$post_args['meta_input']['jkit-template-type'] = $page;
				$meta = $page;
			}

			$post_id = wp_insert_post( $post_args );

			update_post_meta( $post_id, sanitize_key( Dashboard::$jkit_condition ), $condition );
			array_unshift( $keys, $post_id );
			$this->update_post_sequence( $keys );

			$element = jkit_get_element_data( $post_type, $meta );
			wp_send_json_success( $element );
		}
		wp_send_json_error();
	}

	/**
	 * Detail Element
	 */
	public function detail_element() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$data   = jeg_sanitize_array( $_POST );
			$result = $this->get_fields( $data['id'], $data['page'] );
			wp_send_json_success( $result );
		}
		wp_send_json_error();
	}

	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	public function get_fields( $post_id, $page ) {
		return array(
			'option'    => $this->get_option_fields( $post_id ),
			'condition' => $this->get_condition_fields( $post_id, $page ),
		);
	}

	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	public function get_option_fields( $post_id ) {
		$option = array();
		foreach ( Template_Dashboard_Abstract::main_fields() as $key => $field ) {
			$option[ $key ] = jeg_prepare_field(
				$key,
				$field,
				array(
					'title' => get_the_title( $post_id ),
				)
			);
		}

		return $option;
	}

	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	public function get_condition_fields( $post_id, $page ) {
		$conditions = get_post_meta( $post_id, Dashboard::$jkit_condition, true );
		$result     = array();

		if ( $conditions && ! empty( $conditions ) ) {
			foreach ( $conditions as $idx => $condition ) {
				$result[ $idx ] = array();
				$fields         = Template_Dashboard_Abstract::condition_fields( $condition, $page );

				foreach ( $fields as $key => $field ) {
					$result[ $idx ][ $key ] = jeg_prepare_field( $key, $field, $condition );
				}
			}
		}

		return $result;
	}

	/**
	 * Update Element
	 */
	public function update_element() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$data      = jeg_sanitize_array( $_POST )['data'];
			$condition = isset( $data['condition'] ) ? $data['condition'] : '';
			$post_id   = sanitize_post_field( 'post_id', $_POST['id'], $_POST['id'] );
			wp_update_post(
				array(
					'ID'         => $post_id,
					'post_title' => $data['option']['title'],
				)
			);

			update_post_meta( $post_id, sanitize_key( Dashboard::$jkit_condition ), $condition );
			wp_send_json_success( $condition );
		}
		wp_send_json_error();
	}

	/**
	 * Delete Element
	 */
	public function delete_element() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$data = jeg_sanitize_array( $_POST );
			wp_delete_post( $data['id'], true );
			wp_send_json_success( $data );
		}
		wp_send_json_error();
	}

	/**
	 * Update Sequence
	 */
	public function update_sequence() {
		if ( $this->is_nonce_valid( 'dashboard' ) && current_user_can( 'edit_theme_options' ) ) {
			$data = jeg_sanitize_array( $_POST );

			if ( isset( $data['publish'] ) && count( $data['publish'] ) ) {
				foreach ( $data['publish'] as $key => $id ) {
					wp_update_post(
						array(
							'ID'          => $id,
							'menu_order'  => $key,
							'post_status' => 'publish',
						)
					);
				}
			}

			if ( isset( $data['draft'] ) && count( $data['draft'] ) ) {
				foreach ( $data['draft'] as $key => $id ) {
					wp_update_post(
						array(
							'ID'          => $id,
							'menu_order'  => $key,
							'post_status' => 'draft',
						)
					);
				}
			}

			wp_send_json_success();
		}
	}

	/**
	 * Save Elements Enable Config Option
	 *
	 * @param array $data User data.
	 */
	public function save_elements_enable( $data ) {
		$element_config = get_option( 'jkit_elements_enable', array() );

		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$element_config[ $key ] = $value;
			}
		}

		update_option( 'jkit_elements_enable', $element_config );
	}
}
