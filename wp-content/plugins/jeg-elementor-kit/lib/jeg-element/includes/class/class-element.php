<?php
/**
 * Jeg News Element Initialization
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element;

use Jeg\Element\Beaver\Beaver_Builder_Manager;
use Jeg\Element\Divi\Divi_Builder_Manager;
use Jeg\Element\Elementor\Elementor_Manager;
use Jeg\Element\Elements\Elements_Manager;
use Jeg\Element\Image\Image;
use Jeg\Element\Option\Option_Manager;
use Jeg\Element\Shortcode\Shortcode_Generator;
use Jeg\Element\Widget\Widget_Manager;
use Jeg\Element\Wpbakery\Wpbakery_Integration;

/**
 * Class Init
 *
 * @package jeg-news-element
 */
class Element {
	/**
	 * Instance of Init.
	 *
	 * @var Element
	 */
	private static $instance;

	/**
	 * Image Instance
	 *
	 * @var Image
	 */
	public $image;

	/**
	 * Shortcode Generator Instance
	 *
	 * @var Shortcode_Generator
	 */
	public $shortcode;

	/**
	 * Element Manager Instance
	 *
	 * @var Elements_Manager
	 */
	public $manager;

	/**
	 * Ajax Request Handler
	 *
	 * @var Ajax
	 */
	public $ajax;

	/**
	 * Widget Manager
	 *
	 * @var Widget_Manager
	 */
	public $widget;

	/**
	 * WPBakery Page Builder Integration
	 *
	 * @var Wpbakery_Integration
	 */
	public $wpbakery;

	/**
	 * Elementor Page Builder Integration
	 *
	 * @var Elementor_Manager
	 */
	public $elementor;

	/**
	 * Option Manager
	 *
	 * @var Option_Manager
	 */
	public $option;

	/**
	 * Beaver Builder Manager
	 *
	 * @var Beaver_Builder_Manager
	 */
	public $beaver;

	/**
	 * Divi Builder Manager
	 *
	 * @var Divi_Builder_Manager
	 */
	public $divi;

	/**
	 * Singleton page for Init Class
	 *
	 * @return Element
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Init constructor.
	 */
	private function __construct() {
		$this->load_helper();
		$this->element_instance();
		$this->setup_hook();
	}

	/**
	 * Setup hook for element
	 */
	public function setup_hook() {
		add_action( 'after_setup_theme', array( $this, 'initialize_page_builder' ), 9 );
		add_action( 'et_builder_ready', array( $this, 'initialize_page_builder_on_init' ) );
		add_action( 'admin_head', array( $this, 'remove_from_local_storage' ) );

		add_filter( 'jeg_load_element_option', array( $this, 'flag_load_element_option' ) );
		add_filter( 'jeg_render_shortcode', array( $this, 'flag_load_element_view' ) );
	}

	/**
	 * Remove Divi Local Storage
	 */
	public function remove_from_local_storage() {
		if ( defined( 'ET_BUILDER_VERSION' ) ) {
			if ( apply_filters( 'jeg_element_clear_divi_cache', false ) ) {
				?>
				<script>
					for (var prop in localStorage) {
						localStorage.removeItem(prop)
					}
				</script>
				<?php
			}
		}
	}

	/**
	 * Flag Module
	 *
	 * @param boolean $flag Flag for load element option.
	 *
	 * @return bool
	 */
	public function flag_load_element_option( $flag ) {
		if ( is_admin() ) {
			return true;
		}

		return $flag;
	}

	/**
	 * Flag Element View.
	 *
	 * @param boolean $flag Flag for load element option.
	 *
	 * @return bool
	 */
	public function flag_load_element_view( $flag ) {
		if ( ! is_admin() ) {
			return true;
		}

		return $flag;
	}

	/**
	 * Create Element Instance
	 */
	public function element_instance() {
		$this->image     = new Image();
		$this->shortcode = new Shortcode_Generator();
		$this->manager   = new Elements_Manager();
		$this->ajax      = new Ajax();
		$this->widget    = new Widget_Manager();
		$this->option    = new Option_Manager();
	}

	/**
	 * Initialize Page Builder
	 */
	public function initialize_page_builder() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			$this->wpbakery = new Wpbakery_Integration();
		}

		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$this->elementor = new Elementor_Manager();
		}

		if ( defined( 'FL_BUILDER_VERSION' ) ) {
			$this->beaver = new Beaver_Builder_Manager();
		}
	}

	/**
	 * Initialize Page Builder
	 */
	public function initialize_page_builder_on_init() {
		if ( defined( 'ET_BUILDER_VERSION' ) ) {
			$this->divi = new Divi_Builder_Manager();
		}
	}

	/**
	 * Load Helper
	 */
	public function load_helper() {
		require_once JEG_ELEMENT_DIR . '/includes/helper.php';
	}
}
