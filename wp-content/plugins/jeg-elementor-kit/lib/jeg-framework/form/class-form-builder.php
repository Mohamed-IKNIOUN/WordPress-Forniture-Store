<?php
/**
 * Form Control Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

use Jeg\Form\Field\Field_Abstract;
use Jeg\Form\Segment\Segment_Abstract;

/**
 * Form Control Class
 */
class Form_Builder {
	/**
	 * Form Control
	 *
	 * @var Form_Builder Customizer Instance
	 */
	private static $instance;

	/**
	 * Form Menu Instance
	 *
	 * @var Form_Menu
	 */
	private $menu;

	/**
	 * Form Widget Instance
	 *
	 * @var Form_Widget
	 */
	private $widget;

	/**
	 * Form Archive Instance
	 *
	 * @var Form_Archive
	 */
	private $archive;

	/**
	 * Singleton instance of form control
	 *
	 * @return Form_Builder
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Form_Control constructor.
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_action( 'admin_footer', array( $this, 'print_admin_footer' ) );
		add_action( 'wp_footer', array( $this, 'print_beaver_admin_footer' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'print_admin_footer' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_admin_footer' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'form_control_script' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'form_control_script' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'form_control_script' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'beaver_hack_load_script' ), 99 );
	}

	/**
	 * Force to Load Script for Beaver Builder on Frontend
	 */
	public function beaver_hack_load_script() {
		if ( class_exists( '\FLBuilderModel' ) && \FLBuilderModel::is_builder_active() ) {
			wp_enqueue_style( 'beaver-widget', JEG_URL . '/assets/css/beaver-widget.css', null, jeg_get_version() );
			$this->form_control_script();
			$this->frontend_color_picker();
			wp_enqueue_script( 'jeg-form-widget-script', JEG_URL . '/assets/js/form/widget-container.js', array( 'jeg-form-builder-script' ), jeg_get_version(), true );
		}
	}

	/**
	 * Force WordPress to load color picker on frontend
	 */
	public function frontend_color_picker() {
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script(
			'iris',
			admin_url( 'js/iris.min.js' ),
			array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
			),
			jeg_get_version(),
			1
		);

		wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), jeg_get_version(), 1 );

		$colorpicker_l10n = array(
			'clear'         => esc_html__( 'Clear', 'jeg-elementor-kit' ),
			'defaultString' => esc_html__( 'Default', 'jeg-elementor-kit' ),
			'pick'          => esc_html__( 'Select Color', 'jeg-elementor-kit' ),
			'current'       => esc_html__( 'Current Color', 'jeg-elementor-kit' ),
		);

		wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			$colorpicker_l10n
		);
	}

	/**
	 * Load control builder script
	 */
	public function form_control_script() {
		// Style.
		wp_enqueue_style( 'selectize', JEG_URL . '/assets/css/selectize.default.css', null, '0.14.0' );
		wp_enqueue_style( 'jeg-form-builder', JEG_URL . '/assets/css/form-builder.css', array( 'wp-color-picker' ), jeg_get_version() );
		// fontawesome 6
		wp_enqueue_style( 'font-awesome', JEG_URL . '/assets/font/font-awesome/css/fontawesome.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-solid', JEG_URL . '/assets/font/font-awesome/css/solid.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-brands', JEG_URL . '/assets/font/font-awesome/css/brands.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-regular', JEG_URL . '/assets/font/font-awesome/css/regular.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-v4-font-face', JEG_URL . '/assets/font/font-awesome/css/v4-font-face.min.css', null, '6.2.0' );

		// Script.
		wp_enqueue_script( 'selectize', JEG_URL . '/assets/js/vendor/selectize.min.js', null, '0.14.0', true );
		// wp_enqueue_script( 'bootstrap', JEG_URL . '/assets/js/vendor/bootstrap.bundle.min.js', null, '5.2.2', true );
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_script( 'jeg-fontawesome6-iconset', JEG_URL . '/assets/js/vendor/jeg-iconpicker/jeg-fontawesome6-iconset.js', null, '1.0.0', true );
			wp_enqueue_script( 'jeg-iconpicker', JEG_URL . '/assets/js/vendor/jeg-iconpicker/jeg-iconpicker.js', null, '1.0.0', true );
		} else {
			wp_enqueue_script( 'jeg-fontawesome6-iconset', JEG_URL . '/assets/js/vendor/jeg-iconpicker/jeg-fontawesome6-iconset.min.js', null, '1.0.0', true );
			wp_enqueue_script( 'jeg-iconpicker', JEG_URL . '/assets/js/vendor/jeg-iconpicker/jeg-iconpicker.min.js', null, '1.0.0', true );
		}
		wp_enqueue_script(
			'jeg-form-builder-script',
			JEG_URL . '/assets/js/form/form-builder.js',
			array(
				'jquery',
				'underscore',
				'wp-util',
				'customize-controls',
				'customize-base',
				'wp-color-picker',
				'jquery-ui-spinner',
				'selectize',
			),
			jeg_get_version(),
			true
		);
	}

	/**
	 * Initialize admin form
	 */
	public function admin_init() {
		if ( apply_filters( 'jeg_load_form_menu', false ) ) {
			$this->menu = new Form_Menu();
		}

		$this->widget  = new Form_Widget();
		$this->archive = new Form_Archive();
	}

	/**
	 * Register control type
	 *
	 * @return array
	 */
	public function control_form_type() {
		$type = array(
			'standart'   => 'Jeg\Form\Field\Standart',
			'text'       => 'Jeg\Form\Field\Text',
			'password'   => 'Jeg\Form\Field\Password',
			'color'      => 'Jeg\Form\Field\Color',
			'select'     => 'Jeg\Form\Field\Select',
			'checkbox'   => 'Jeg\Form\Field\Checkbox',
			'radioimage' => 'Jeg\Form\Field\Radioimage',
			'slider'     => 'Jeg\Form\Field\Slider',
			'iconpicker' => 'Jeg\Form\Field\Iconpicker',
			'heading'    => 'Jeg\Form\Field\Heading',
			'alert'      => 'Jeg\Form\Field\Alert',
			'textarea'   => 'Jeg\Form\Field\Textarea',
			'number'     => 'Jeg\Form\Field\Number',
			'image'      => 'Jeg\Form\Field\Image',
			'upload'     => 'Jeg\Form\Field\Upload',
			'repeater'   => 'Jeg\Form\Field\Repeater',
		);

		return apply_filters( 'jeg_register_control_form_type', $type );
	}

	/**
	 * Register section type
	 *
	 * @return array
	 */
	public function segment_form_type() {
		$type = array(
			'normal' => 'Jeg\Form\Segment\Normal_Segment',
			'nowrap' => 'Jeg\Form\Segment\Nowrap_Segment',
			'tabbed' => 'Jeg\Form\Segment\Tabbed_Segment',
		);

		return apply_filters( 'jeg_register_segment_form_type', $type );
	}

	/**
	 * Print template on admin footer
	 */
	public function print_admin_footer() {
		$sections = $this->segment_form_type();

		foreach ( $sections as $type => $class ) {
			/** @var Segment_Abstract $section */
			$section = new $class();
			$section->render_template();
		}

		$controls = $this->control_form_type();

		foreach ( $controls as $type => $class ) {
			/** @var Field_Abstract $control */
			$control = new $class();
			$control->render_template();
		}
	}

	/**
	 * Beaver builder footer
	 */
	public function print_beaver_admin_footer() {
		if ( class_exists( '\FLBuilderModel' ) && \FLBuilderModel::is_builder_active() ) {
			$this->print_admin_footer();
		}
	}
}
