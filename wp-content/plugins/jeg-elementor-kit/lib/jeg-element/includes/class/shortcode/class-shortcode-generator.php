<?php
/**
 * Jeg News Element Background Load Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Shortcode;

/**
 * Class Shortcode_Generator
 *
 * @package Jeg\Element
 */
class Shortcode_Generator {

	/**
	 * Hold element list
	 *
	 * @var array
	 */
	private $elements;

	/**
	 * ShortCodeGenerator constructor.
	 */
	public function __construct() {
		$this->load_hook();
	}

	/**
	 * Load All hook for this shortcode generator
	 */
	public function load_hook() {
		add_action( 'current_screen', array( $this, 'shortcode_button' ) );
	}

	/**
	 * Shortcode generator button hook
	 */
	public function shortcode_button() {
		if ( empty( $this->get_registered_element() ) ) {
			return false;
		}

		$screen = get_current_screen();
		if ( ( 'post' === $screen->post_type || 'page' === $screen->post_type ) && '' !== $screen->post_type ) {
			if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) ) {
				add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'register_button' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
				add_action( 'admin_footer', array( $this, 'template_script' ) );
			}
		}
	}

	/**
	 * Add Javascript for Tiny MCE
	 *
	 * @param array $plugin_array Javascript going to enqueue on frontend.
	 *
	 * @return mixed
	 */
	public function add_tinymce_plugin( $plugin_array ) {
		$plugin_array['jeg-shortcode'] = JEG_ELEMENT_URL . '/assets/js/shortcode.js';

		return $plugin_array;
	}

	/**
	 * Register Shortcode Generator Button
	 *
	 * @param array $buttons Array of button in Shortcode Generator.
	 *
	 * @return array
	 */
	public function register_button( $buttons ) {
		array_push( $buttons, 'jeg-shortcode-generator' );

		return $buttons;
	}

	/**
	 * Get registered element
	 *
	 * @return array
	 */
	public function get_registered_element() {
		if ( null === $this->elements ) {
			$this->elements = apply_filters( 'jeg_shortcode_elements', array() );
		}

		return $this->elements;
	}

	/**
	 * Enqueue script
	 */
	public function enqueue_script() {
		wp_enqueue_style( 'jeg-shortcode-style', JEG_ELEMENT_URL . '/assets/css/shortcode-builder.css', null, JEG_ELEMENT_VERSION );

		wp_enqueue_script(
			'jeg-shortcode-generator',
			JEG_ELEMENT_URL . '/assets/js/shortcode-generator.js',
			array(
				'underscore',
				'wp-util',
				'customize-base',
				'jquery-ui-draggable',
			),
			JEG_ELEMENT_VERSION,
			true
		);

		wp_localize_script(
			'jeg-shortcode-generator',
			'jelement',
			array(
				'nonce'    => wp_create_nonce( 'jeg_element' ),
				'elements' => $this->get_registered_element(),
				'title'    => esc_html__( 'Shortcode Generator', 'jeg-elementor-kit' ),
				'close'    => esc_html__( 'Close', 'jeg-elementor-kit' ),
				'generate' => esc_html__( 'Generate', 'jeg-elementor-kit' ),
			)
		);
	}

	/**
	 * Prepare segment for shortcode generator
	 *
	 * @param array $segments Collection of segments.
	 *
	 * @return array
	 */
	public function prepare_segments( $segments ) {
		$results = array();

		foreach ( $segments as $key => $segment ) {
			$results[ $key ] = jeg_prepare_segment( $key, $segment );
		}

		return $results;
	}

	/**
	 * Prepare option to be loaded on Widget
	 *
	 * @param array $fields collection of control / field.
	 *
	 * @return mixed
	 */
	public function prepare_fields( $fields ) {
		$setting = array();

		foreach ( $fields as $key => $field ) {
			if ( 'compatible_column_notice' === $key ) {
				continue;
			}
			$setting[ $key ] = jeg_prepare_field( $key, $field );
		}

		return $setting;
	}

	/**
	 * Script template for shortcode generator
	 */
	public function template_script() {
		?>
		<div class="shortcode-popup-list-wrapper shortcode-tab" id="shortcode-popup-list-wrapper"></div>
		<div class="shortcode-option-wrapper shortcode-tab" id="shortcode-option-wrapper"></div>
		<script type="text/html" id="tmpl-shortcode-popup">
			<div class="popup-shortcode-list">
				<div class="popup-header">
					<h2>{{ data.header }}</h2>
					<span class="close">
						<i class="fa fa-close"></i>
					</span>
				</div>
				<div class="popup-body">
					<ul class="tabbed-list"></ul>
					<div class="tabbed-body popup-content"></div>
				</div>
			</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-category-list">
			<# var active = ( data.index === 0 ) ? 'active' : ''; #>
				<li href="#{{ data.id }}" class="{{ active }}"><span>{{ data.text }}</span></li>
		</script>
		<script type="text/html" id="tmpl-shortcode-category">
			<# var active = ( data.index === 0 ) ? 'active' : ''; #>
				<div class="jeg_tabbed_body {{ data.id }} {{ active }}" id="{{ data.id }}">
					<div class="jeg_metabox_body"></div>
				</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-item">
			<div class="element">
				<div class="element-wrapper">
					<i class="{{ data.id }}"></i>
				</div>
				<span>{{ data.name }}</span>
			</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-option">
			<div class="popup-shortcode-option">
				<div class="popup-header">
					<h2>{{ data.header }}</h2>
					<span class="close">
						<i class="fa fa-close"></i>
					</span>
				</div>
				<div class="popup-body">
					<ul class="tabbed-list"></ul>
					<div class="tabbed-body popup-content"></div>
				</div>
				<div class="popup-footer">
					<div class="close">{{ data.close }}</div>
					<div class="generate">{{ data.generate }}</div>
				</div>
			</div>
		</script>
		<?php
	}
}
