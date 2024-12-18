<?php
/**
 * Customizer Form Menu
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

/**
 * Form Menu Class
 */
class Form_Menu {

	/**
	 * Post Meta Name
	 *
	 * @var string
	 */
	public static $meta_name = 'jeg_custom_menu';

	/**
	 * Menu Input Name
	 *
	 * @var string
	 */
	public static $input_name = 'jeg_menu';

	/**
	 * Menu Nonce
	 *
	 * @var string
	 */
	private $nonce = 'jeg_menu_ajax';

	/**
	 * Form_Menu constructor.
	 */
	public function __construct() {
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'custom_walker' ), 10 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'custom_nav_update' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'menu_setting' ), 99 );
		add_action( 'wp_ajax_load_menu', array( $this, 'get_lazy_menu' ) );
		add_action( 'wp_ajax_nopriv_load_menu', array( $this, 'get_lazy_menu' ) );
	}

	/**
	 * Retrieve Segment & Field Menu
	 */
	public function get_lazy_menu() {
		if ( current_user_can( 'edit_theme_options' ) && isset( $_POST['menu'], $_POST['nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['nonce'] ), $this->nonce ) ) {
			$menu = sanitize_text_field( wp_unslash( $_POST['menu'] ) );

			$segments = apply_filters( 'jeg_custom_menu_segment', array() );
			$segments = $this->prepare_segments( $segments );

			$value  = get_post_meta( $menu, $this->get_meta_name(), true );
			$fields = apply_filters( 'jeg_custom_menu_field', array(), $value );
			$fields = $this->prepare_fields( $fields );

			wp_send_json_success(
				array(
					'segments' => $segments,
					'fields'   => $fields,
				)
			);
		}
	}

	/**
	 * Get meta name
	 *
	 * @return string
	 */
	protected function get_meta_name() {
		return apply_filters( 'jeg_form_menu_meta_name', self::$meta_name );
	}

	/**
	 * Update Mega Menu Option
	 *
	 * @param int $menu_id Menu ID.
	 * @param int $menu_item_db_id Menu Item ID.
	 */
	public function custom_nav_update( $menu_id, $menu_item_db_id ) {
		if ( current_user_can( 'edit_theme_options' ) && isset( $_POST[ self::$input_name ] ) && isset( $_POST[ self::$input_name ][ $menu_item_db_id ] ) ) {
			$array_input = jeg_sanitize_array( wp_unslash( $_POST[ self::$input_name ] ) );
			update_post_meta( $menu_item_db_id, $this->get_meta_name(), $array_input[ $menu_item_db_id ] );
		}
	}

	/**
	 * Custom Walker
	 */
	public function custom_walker() {
		return 'Jeg\Form\Custom_Menu_Walker';
	}


	/**
	 * Prepare option to be loaded on Menu
	 *
	 * @param array $fields Collection of option need to be prepared.
	 *
	 * @return mixed
	 */
	public function prepare_fields( $fields ) {
		$setting = array();

		foreach ( $fields as $key => $field ) {
			$setting[ $key ]                = array();
			$setting[ $key ]['id']          = $key;
			$setting[ $key ]['type']        = isset( $field['type'] ) ? $field['type'] : 'text';
			$setting[ $key ]['segment']     = isset( $field['segment'] ) ? $field['segment'] : '';
			$setting[ $key ]['title']       = isset( $field['title'] ) ? $field['title'] : '';
			$setting[ $key ]['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$setting[ $key ]['options']     = isset( $field['options'] ) ? $field['options'] : array();
			$setting[ $key ]['default']     = isset( $field['default'] ) ? $field['default'] : '';
			$setting[ $key ]['fields']      = isset( $field['fields'] ) ? $field['fields'] : array();
			$setting[ $key ]['row_label']   = isset( $field['row_label'] ) ? $field['row_label'] : array();
			$setting[ $key ]['dependency']  = isset( $field['dependency'] ) ? $field['dependency'] : array();
			$setting[ $key ]['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
			$setting[ $key ]['multiple']    = isset( $field['multiple'] ) ? $field['multiple'] : 1;
			$setting[ $key ]['value']       = isset( $field['value'] ) ? $field['value'] : null;
			$setting[ $key ]['ajax']        = isset( $field['ajax'] ) ? $field['ajax'] : '';
			$setting[ $key ]['nonce']       = isset( $field['nonce'] ) ? $field['nonce'] : '';
		}

		return $setting;
	}

	/**
	 * Prepare segment to be loaded on Menu
	 *
	 * @param array $sections Collection of section need to be prepared.
	 *
	 * @return mixed
	 */
	public function prepare_segments( $sections ) {
		$segments = array();

		foreach ( $sections as $section ) {
			$key                          = $section['id'];
			$segments[ $key ]             = array();
			$segments[ $key ]['id']       = $key;
			$segments[ $key ]['type']     = isset( $section['type'] ) ? $section['type'] : 'default';
			$segments[ $key ]['name']     = isset( $section['name'] ) ? $section['name'] : '';
			$segments[ $key ]['priority'] = isset( $section['priority'] ) ? $section['priority'] : 10;
			$segments[ $key ]['type']     = 'menu';
		}

		return $segments;
	}

	/**
	 * Print menu option on bottom of admin page
	 */
	public function menu_setting() {
		wp_enqueue_script( 'jeg-form-menu-script', JEG_URL . '/assets/js/form/menu-container.js', array( 'jeg-form-builder-script' ), jeg_get_version(), true );
		wp_localize_script(
			'jeg-form-menu-script',
			'jegMenuOptions',
			array(
				'fieldIDPattern'   => '{0}-{1}-{2}',
				'fieldNamePattern' => '{0}[{1}][{2}]',
				'inputName'        => self::$input_name,
				'nonce'            => wp_create_nonce( $this->nonce ),
			)
		);
	}
}
