<?php
/**
 * This customizer plugin branch of Kirki Customizer Plugin.
 * https://github.com/aristath/kirki
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Customizer;

use Jeg\Customizer\Partial\Lazy_Partial;
use Jeg\Customizer\Setting\Default_Setting;
use Jeg\Util\Font;
use Jeg\Util\Sanitize;
use Jeg\Util\Style_Generator;

/**
 * Class Customizer
 *
 * @package Jeg
 */
class Customizer {

	/**
	 * Customizer
	 *
	 * @var Customizer Customizer Instance
	 */
	private static $instance;

	/**
	 * An array containing all panels.
	 *
	 * @access private
	 * @var array
	 */
	private $panels = array();

	/**
	 * An array containing all sections.
	 *
	 * @access private
	 * @var array
	 */
	private $sections = array();

	/**
	 * An array containing all fields.
	 *
	 * @access private
	 * @var array
	 */
	private $fields = array();

	/**
	 * Cached Array for faster access
	 *
	 * @var array
	 */
	private $cache_fields = array();

	/**
	 * An array containing partial refresh
	 *
	 * @access private
	 * @var array
	 */
	private $partial_refresh = array();

	/**
	 * Version of Customizer
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Endpoint used for ajax request
	 *
	 * @var string
	 */
	public $endpoint = 'customizer';

	/**
	 * Get Instance of Customizer
	 *
	 * @return Customizer
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Init constructor.
	 */
	private function __construct() {
		$this->set_version();

		add_action( 'customize_register', array( $this, 'register_control_types' ) );
		add_action( 'customize_register', array( $this, 'register_section_types' ) );
		add_action( 'customize_register', array( $this, 'register_panel_types' ) );
		add_action( 'customize_register', array( $this, 'deploy_panels' ), 97 );
		add_action( 'customize_register', array( $this, 'deploy_sections' ), 98 );
		add_action( 'customize_register', array( $this, 'deploy_fields' ), 96 );
		add_action( 'customize_register', array( $this, 'register_customizer' ) );
		add_action( 'customize_preview_init', array( $this, 'preview_init' ), 99 );
		add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ), 99 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_script' ), 11 );
		add_action( 'upload_mimes', array( $this, 'allow_mime' ) );

		// Partial Refresh.
		add_filter( 'customize_partial_render', array( $this, 'partial_render' ), null, 3 );
		add_filter( 'customize_dynamic_partial_args', array( $this, 'filter_dynamic_partial_args' ), 10, 2 );
		add_filter( 'customize_dynamic_partial_class', array( $this, 'filter_dynamic_partial_class' ), 10, 2 );

		// Handle dynamic setting save.
		add_filter( 'customize_dynamic_setting_args', array( $this, 'filter_dynamic_setting_args' ), 10, 2 );
		add_filter( 'customize_dynamic_setting_class', array( $this, 'filter_dynamic_setting_class' ), 10, 2 );
		add_filter( 'query_vars', array( $this, 'ajax_query_vars' ) );
		add_action( 'parse_request', array( $this, 'ajax_parse_request' ) );

		// Javascript Template.
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'search_template' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'widget_template' ) );
	}

	/**
	 * Register query var for lazy section ajax request
	 *
	 * @param array $vars Query var endpoint.
	 *
	 * @return array
	 */
	public function ajax_query_vars( $vars ) {
		$vars[] = $this->endpoint;
		$vars[] = 'sections';
		$vars[] = 'search';
		$vars[] = 'nonce';

		return $vars;
	}

	/**
	 * Handle ajax request for retrieving lazy section
	 *
	 * @param \WP $wp Handle request.
	 */
	public function ajax_parse_request( $wp ) {
		if ( array_key_exists( $this->endpoint, $wp->query_vars ) ) {
			add_filter( 'wp_doing_ajax', '__return_true' );

			if ( current_user_can('customize') && isset( $wp->query_vars['nonce'] ) && wp_verify_nonce( $wp->query_vars['nonce'], $this->endpoint ) ) {
				if ( isset( $wp->query_vars['sections'] ) ) {
					$section = $wp->query_vars['sections'];
					$this->get_lazy_section_control( $section );
				}

				if ( isset( $wp->query_vars['search'] ) ) {
					$search = $wp->query_vars['search'];
					$this->get_search_result( $search );
				}
			}

			die();
		}
	}

	/**
	 * Check total search match
	 *
	 * @param string $keywords Search keyword.
	 * @param string $description Search description.
	 *
	 * @return int
	 */
	public function match_search( $keywords, $description ) {
		preg_match_all( '/\w+/i', $keywords, $words );
		$total = 0;

		foreach ( $words[0] as $search ) {
			$found = preg_match_all( "/($search)/i", $description );

			if ( 0 === $found ) {
				return 0;
			} else {
				$total += $found;
			}
		}

		return $total;
	}

	/**
	 * Return search result
	 *
	 * @param string $search Search keyword.
	 */
	public function get_search_result( $search ) {
		$fields  = $this->get_all_fields();
		$results = array();

		foreach ( $fields as $key => $field ) {
			$field['title']       = isset( $field['title'] ) ? $field['title'] : '';
			$field['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$match                = $this->match_search(
				$search,
				implode(
					' ',
					array(
						$field['title'],
						$field['description'],
					)
				)
			);

			if ( $match > 0 ) {
				$results[ $key ] = array(
					'id'          => $field['id'],
					'label'       => $field['label'],
					'description' => $field['description'],
					'section'     => $field['section'],
					'match'       => $match,
				);
			}
		}

		wp_send_json_success( $results );
	}

	/**
	 * Get file location for lazy section
	 *
	 * @param string $id ID of lazy section to be searched.
	 *
	 * @return mixed
	 */
	public function get_lazy_section_files( $id ) {
		$sections = $this->get_registered_lazy_section();

		if ( isset( $sections[ $id ] ) ) {
			return $sections[ $id ];
		}

		return array();
	}

	/**
	 * Find lazy setting
	 *
	 * @param array  $options Array of lazy option.
	 * @param string $name Name of setting to be searched for.
	 *
	 * @return mixed
	 */
	public function filter_lazy_setting( $options, $name ) {
		foreach ( $options as $key => $option ) {
			if ( $option['id'] === $name ) {
				return $option;
			}
		}

		return null;
	}

	/**
	 * Find partial setting
	 *
	 * @param array  $options Array of partial setting option.
	 * @param string $name Name of setting to be searched for.
	 *
	 * @return mixed
	 */
	public function filter_lazy_partial_setting( $options, $name ) {
		foreach ( $options as $key => $option ) {
			if ( isset( $option['partial_refresh'] ) ) {
				$partials = $option['partial_refresh'];
				if ( array_key_exists( $name, $partials ) ) {
					return array(
						'setting' => $option['id'],
						'partial' => $partials[ $name ],
					);
				}
			}
		}

		return null;
	}

	/**
	 * Get WP Customize Instance. if its empty then we need to create one
	 *
	 * @return \WP_Customize_Manager
	 */
	public function wp_customize() {
		global $wp_customize;

		if ( empty( $wp_customize ) || ! ( $wp_customize instanceof \WP_Customize_Manager ) ) {
			require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
			$wp_customize = new \WP_Customize_Manager();
		}

		return $wp_customize;
	}

	/**
	 * Find setting class for option
	 *
	 * @param string                       $class Class name for setting.
	 * @param \WP_Customize_Setting|string $id Customize Setting object, or ID.
	 *
	 * @return string
	 */
	public function filter_dynamic_setting_class( $class, $id ) {
		if ( preg_match( Default_Setting::$lazy_pattern, $id, $matches ) ) {
			$option = $this->get_lazy_field(
				$matches['section'],
				$matches['id'],
				array(
					$this,
					'filter_lazy_setting',
				)
			);
			$class  = $this->get_setting_class( $option['type'] );
		}

		return $class;
	}

	/**
	 * Find setting arguemnt for option
	 *
	 * @param array                        $setting_args Array of properties for the new WP_Customize_Setting. Default empty array.
	 * @param \WP_Customize_Setting|string $setting_id Customize Setting object, or ID.
	 *
	 * @return mixed
	 */
	public function filter_dynamic_setting_args( $setting_args, $setting_id ) {
		if ( preg_match( Default_Setting::$lazy_pattern, $setting_id, $matches ) ) {
			$option       = $this->get_lazy_field(
				$matches['section'],
				$matches['id'],
				array(
					$this,
					'filter_lazy_setting',
				)
			);
			$field        = $this->filter_field( $option, true );
			$setting_args = $field['setting'];
		}

		return $setting_args;
	}

	/**
	 * Partial render
	 *
	 * @param string|array|false    $rendered The partial value. Default false.
	 * @param \WP_Customize_Partial $partial WP_Customize_Setting instance.
	 * @param array                 $container_context Optional array of context data associated with
	 *                                                                 the target container.
	 *
	 * @return mixed|string
	 */
	public function partial_render( $rendered, \WP_Customize_Partial $partial, $container_context ) {
		if ( preg_match( Lazy_Partial::$pattern, $partial->id, $matches ) ) {
			$option = $this->get_lazy_field(
				$matches['section'],
				$matches['id'],
				array(
					$this,
					'filter_lazy_partial_setting',
				)
			);

			if ( $option ) {
				ob_start();
				$return_render = call_user_func( $option['partial']['render_callback'], $this, $container_context );
				$ob_render     = ob_get_clean();

				if ( null !== $return_render && '' !== $ob_render ) {
					_doing_it_wrong( __FUNCTION__, esc_html__( 'Partial render must echo the content or return the content string (or array), but not both.', 'jeg-elementor-kit' ), '4.5.0' );
				}

				$rendered = null !== $return_render ? $return_render : $ob_render;
			}
		}

		return $rendered;
	}

	/**
	 * Filters a dynamic partial's constructor arguments.
	 *
	 * @param false|array $args The arguments to the WP_Customize_Partial constructor.
	 * @param string      $id ID for dynamic partial.
	 *
	 * @return array
	 */
	public function filter_dynamic_partial_args( $args, $id ) {
		if ( preg_match( Lazy_Partial::$pattern, $id, $matches ) ) {
			$option = $this->get_lazy_field(
				$matches['section'],
				$matches['id'],
				array(
					$this,
					'filter_lazy_partial_setting',
				)
			);
			$args   = array(
				'selector'            => $option['partial']['selector'],
				'settings'            => array( Default_Setting::create_lazy_setting( $matches['section'], $option['setting'] ) ),
				'container_inclusive' => false,
				'fallback_refresh'    => false,
			);
		}

		return $args;
	}

	/**
	 * Filters the class used to construct partials.
	 *
	 * Allow non-statically created partials to be constructed with custom WP_Customize_Partial subclass.
	 *
	 * @param string $class WP_Customize_Partial or a subclass.
	 * @param string $id ID for dynamic partial.
	 *
	 * @return string
	 */
	public function filter_dynamic_partial_class( $class, $id ) {
		if ( preg_match( Lazy_Partial::$pattern, $id, $matches ) ) {
			$class = 'Jeg\Customizer\Partial\Lazy_Partial';
		}

		return $class;
	}

	/**
	 * Get all option
	 *
	 * @param array|callable $file Callback or path to option.
	 *
	 * @return array|mixed
	 */
	public function get_lazy_options( $file ) {
		$options = array();

		if ( is_array( $file ) ) {
			$options = call_user_func_array( $file['function'], $file['parameter'] );
		} elseif ( file_exists( $file ) ) {
			$options = include $file;
		}

		$options = apply_filters( 'jeg_customizer_get_lazy_options', $options );

		return $options;
	}

	/**
	 * Get filtered lazy field
	 *
	 * @param string   $section Section of lazy field.
	 * @param string   $name name of setting or option.
	 * @param callable $callback filtered callback.
	 *
	 * @return mixed
	 */
	public function get_lazy_field( $section, $name, $callback ) {
		$section = $this->get_lazy_section_files( $section );

		if ( ! empty( $section ) ) {
			foreach ( $section as $file ) {
				$options = $this->get_lazy_options( $file );

				return call_user_func_array( $callback, array( $options, $name ) );
			}
		}

		return null;
	}

	/**
	 * Preparing lazy fields
	 *
	 * @param array  $section Array of section.
	 * @param string $section_id Name of section.
	 *
	 * @return array
	 */
	public function compose_lazy_fields( $section, $section_id ) {
		$this->wp_customize();
		$results = array();

		foreach ( $section as $file ) {
			$options = $this->get_lazy_options( $file );

			foreach ( $options as $option ) {
				$results[ $option['id'] ] = $this->compose_lazy_option( $option, $section_id );
			}
		}

		return $results;
	}

	/**
	 * Prepare lazy option to fit with customizer setting
	 *
	 * @param array  $option Raw option.
	 * @param string $section_id Name of section.
	 *
	 * @return array
	 */
	public function compose_lazy_option( $option, $section_id ) {
		$result = array();

		// force assign section & dynamic control.
		$option['section'] = $section_id;
		$option['dynamic'] = true;
		$field             = $this->filter_field( $option, true );

		// Assign Setting ID.
		$setting_id          = Default_Setting::create_lazy_setting( $section_id, $option['id'] );
		$result['settingId'] = $setting_id;

		// assign setting json.
		$setting           = $field['setting'];
		$setting_instance  = $this->do_add_setting( $setting, $setting_id );
		$result['setting'] = $setting_instance->json();

		// assign control json.
		$control           = $field['control'];
		$control_instance  = $this->do_add_control( $control, $setting_instance );
		$result['control'] = $control_instance->json();

		return $result;
	}

	/**
	 * Get lazy section control control
	 *
	 * @param array $sections array of sections.
	 */
	public function get_lazy_section_control( $sections ) {
		$results = array();

		foreach ( $sections as $section_id ) {
			$section = $this->get_lazy_section_files( $section_id );

			if ( ! empty( $section ) ) {
				$results[ $section_id ] = $this->compose_lazy_fields( $section, $section_id );
			}
		}
		wp_send_json_success( $results );
	}

	/**
	 * Get all registered section and their respective file
	 *
	 * @return mixed
	 */
	public function get_registered_lazy_section() {
		$sections = apply_filters( 'jeg_register_lazy_section', array() );

		return $sections;
	}

	/**
	 * Get theme version if using themes
	 */
	public function set_version() {
		$this->version = jeg_get_version();
	}

	/**
	 * Create register customizer hook specifically for Jeg Framework
	 */
	public function register_customizer() {
		do_action( 'jeg_register_customizer_option', $this );
	}

	/**
	 * Allow mime for font
	 *
	 * @param array $mimes List of allowed mime.
	 *
	 * @return array
	 */
	public function allow_mime( $mimes ) {
		return array_merge(
			$mimes,
			array(
				'webm' => 'video/webm',
				'ico'  => 'image/vnd.microsoft.icon',
				'ttf'  => 'application/octet-stream',
				'otf'  => 'application/octet-stream',
				'woff' => 'application/x-font-woff',
				'svg'  => 'image/svg+xml',
				'eot'  => 'application/vnd.ms-fontobject',
				'ogg'  => 'audio/ogg',
				'ogv'  => 'video/ogg',
			)
		);
	}

	/**
	 * Load All font for typography on customizer
	 *
	 * @return mixed
	 */
	public function load_all_font() {
		$standard_fonts = Font::get_standard_fonts();
		$google_fonts   = Font::get_google_fonts();
		$all_variants   = Font::get_all_variants();
		$all_subsets    = Font::get_google_font_subsets();

		$standard_fonts_final = array();
		foreach ( $standard_fonts as $key => $value ) {
			$standard_fonts_final[] = array(
				'family'      => $value['stack'],
				'label'       => $value['label'],
				'subsets'     => array(),
				'is_standard' => true,
				'variants'    => array(
					array(
						'id'    => 'regular',
						'label' => $all_variants['regular'],
					),
					array(
						'id'    => 'italic',
						'label' => $all_variants['italic'],
					),
					array(
						'id'    => '700',
						'label' => $all_variants['700'],
					),
					array(
						'id'    => '700italic',
						'label' => $all_variants['700italic'],
					),
				),
				'type'        => 'native',
			);
		}

		$google_fonts_final = array();
		foreach ( $google_fonts as $family => $args ) {
			$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
			$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
			$subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array();

			$available_variants = array();
			foreach ( $variants as $variant ) {
				if ( array_key_exists( $variant, $all_variants ) ) {
					$available_variants[] = array(
						'id'    => $variant,
						'label' => $all_variants[ $variant ],
					);
				}
			}

			$available_subsets = array();
			foreach ( $subsets as $subset ) {
				if ( array_key_exists( $subset, $all_subsets ) ) {
					$available_subsets[] = array(
						'id'    => $subset,
						'label' => $all_subsets[ $subset ],
					);
				}
			}

			$google_fonts_final[] = array(
				'family'   => $family,
				'label'    => $label,
				'variants' => $available_variants,
				'subsets'  => $available_subsets,
			);
		}

		return apply_filters( 'jeg_font_typography', array_merge( $standard_fonts_final, $google_fonts_final ) );
	}

	/**
	 * Load script for preview init
	 */
	public function preview_init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'previewer_script' ) );
	}

	/**
	 * Add panel functionality exposed to public
	 *
	 * @param array $panel Panel option.
	 */
	public function add_panel( $panel ) {
		$this->panels[ $panel['id'] ] = $panel;
	}

	/**
	 * Section functionality exposed to public
	 *
	 * @param array $section Section option.
	 */
	public function add_section( $section ) {
		$section = apply_filters( 'jeg_customizer_add_section', $section );

		$this->sections[ $section['id'] ] = $section;
	}

	/**
	 * Add field functionality exposed to public
	 *
	 * @param array $field Add option.
	 */
	public function add_field( $field ) {
		$field = apply_filters( 'jeg_customizer_add_field', $field );

		$this->fields[ $field['id'] ] = $field;

		if ( isset( $field['partial_refresh'] ) ) {
			$this->partial_refresh[ $field['id'] ] = $field['partial_refresh'];
		}
	}

	/**
	 * Deploy registered panel
	 */
	public function deploy_panels() {
		$wp_customize          = $this->wp_customize();
		$active_callback_class = Active_Callback::get_instance();

		foreach ( $this->panels as $panel ) {
			$panel['type'] = isset( $panel['type'] ) ? $panel['type'] : 'default';

			switch ( $panel['type'] ) {
				case 'alert':
					$panel_class = 'Jeg\Customizer\Panel\Alert_Panel';
					break;
				default:
					$panel_class = 'WP_Customize_Panel';
					break;
			}

			$wp_customize->add_panel(
				new $panel_class(
					$wp_customize,
					$panel['id'],
					array(
						'title'           => $panel['title'],
						'description'     => $panel['description'],
						'priority'        => $panel['priority'],
						'active_callback' => isset( $panel['active_callback'] ) ? function () use ( $panel, $active_callback_class ) {
							return $active_callback_class->evaluate( $panel['active_callback'] );
						} : '__return_true',
					)
				)
			);
		}
	}

	/**
	 * Deploy registered section
	 */
	public function deploy_sections() {
		$wp_customize          = $this->wp_customize();
		$active_callback_class = Active_Callback::get_instance();

		foreach ( $this->sections as $section ) {
			$section['type'] = isset( $section['type'] ) ? $section['type'] : 'default';

			switch ( $section['type'] ) {
				case 'jeg-helper-section':
					$section_class = 'Jeg\Customizer\Section\Helper_Section';
					break;
				case 'jeg-lazy-section':
					$section_class = 'Jeg\Customizer\Section\Lazy_Section';
					break;
				case 'jeg-link-section':
					$section_class = 'Jeg\Customizer\Section\Link_Section';
					break;
				default:
					$section_class = 'Jeg\Customizer\Section\Default_Section';
					break;
			}

			$wp_customize->add_section(
				new $section_class(
					$wp_customize,
					$section['id'],
					array(
						'title'           => $section['title'],
						'panel'           => isset( $section['panel'] ) ? $section['panel'] : '',
						'priority'        => $section['priority'],
						'dependency'      => isset( $section['dependency'] ) ? $section['dependency'] : array(),
						'url'             => isset( $section['url'] ) ? $section['url'] : '',
						'label'           => isset( $section['label'] ) ? $section['label'] : '',
						'active_callback' => isset( $section['active_callback'] ) ? function () use ( $section, $active_callback_class ) {
							return $active_callback_class->evaluate( $section['active_callback'] );
						} : '__return_true',
					)
				)
			);
		}
	}

	/**
	 * Deploy all registered field
	 */
	public function deploy_fields() {
		foreach ( $this->fields as $field ) {
			$filtered_field = $this->filter_field( $field );
			$this->do_add_setting( $filtered_field['setting'] );
			$this->do_add_control( $filtered_field['control'] );
		}

		$this->register_partial_refresh();
	}

	/**
	 * Setup_partial_refresh
	 */
	public function register_partial_refresh() {
		$wp_customize = $this->wp_customize();

		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		foreach ( $this->fields as $field_id => $args ) {
			if ( isset( $args['partial_refresh'] ) && ! empty( $args['partial_refresh'] ) ) {
				// Start going through each item in the array of partial refreshes.
				foreach ( $args['partial_refresh'] as $partial_refresh => $partial_refresh_args ) {
					// If we have all we need, create the selective refresh call.
					if ( isset( $partial_refresh_args['render_callback'] ) && isset( $partial_refresh_args['selector'] ) ) {
						$wp_customize->selective_refresh->add_partial(
							$partial_refresh,
							array(
								'selector'            => $partial_refresh_args['selector'],
								'settings'            => array( $args['id'] ),
								'render_callback'     => $partial_refresh_args['render_callback'],
								'container_inclusive' => isset( $partial_refresh_args['container_inclusive'] ) ? $partial_refresh_args['container_inclusive'] : false,
								'fallback_refresh'    => false,
							)
						);
					}
				}
			}
		}
	}

	/**
	 * Prepare single setting
	 *
	 * @param array $field Unfiltered setting.
	 *
	 * @return array
	 */
	public function compose_setting( $field ) {
		$setting = array();

		$setting['id']           = $field['id'];
		$setting['type']         = isset( $field['option_type'] ) ? $field['option_type'] : 'theme_mod';
		$setting['default']      = isset( $field['default'] ) ? $field['default'] : '';
		$setting['transport']    = isset( $field['transport'] ) ? $field['transport'] : 'refresh';
		$setting['sanitize']     = isset( $field['sanitize'] ) ? $field['sanitize'] : $this->sanitize_handler( $field['type'] );
		$setting['control_type'] = $field['type'];

		return $setting;
	}

	/**
	 * Prepare single control
	 *
	 * @param array   $field Unfiltered control.
	 * @param boolean $dynamic flag for dynamic control.
	 *
	 * @return array
	 */
	public function compose_control( $field, $dynamic ) {
		$control               = array();
		$active_callback_class = Active_Callback::get_instance();

		$control['id']            = $field['id'];
		$control['type']          = $field['type'];
		$control['label']         = $field['label'];
		$control['section']       = isset( $field['section'] ) ? $field['section'] : '';
		$control['description']   = isset( $field['description'] ) ? $field['description'] : '';
		$control['multiple']      = isset( $field['multiple'] ) ? $field['multiple'] : 0;
		$control['default']       = isset( $field['default'] ) ? $field['default'] : 0;
		$control['choices']       = isset( $field['choices'] ) ? $field['choices'] : array();
		$control['fields']        = isset( $field['fields'] ) ? $field['fields'] : array();
		$control['row_label']     = isset( $field['row_label'] ) ? $field['row_label'] : esc_html__( 'Row', 'jeg-elementor-kit' );
		$control['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : array();
		$control['ajax_action']   = isset( $field['ajax_action'] ) ? $field['ajax_action'] : '';

		// additional control option.
		$control['partial_refresh'] = isset( $field['partial_refresh'] ) ? $field['partial_refresh'] : null;
		$control['active_rule']     = isset( $field['active_callback'] ) ? $field['active_callback'] : null;
		$control['output']          = isset( $field['output'] ) ? $field['output'] : null;
		$control['postvar']         = isset( $field['postvar'] ) ? $field['postvar'] : array();
		$control['dynamic']         = isset( $field['dynamic'] ) ? $field['dynamic'] : false;

		// only load active callback on normal field.
		if ( ! $dynamic ) {
			$control['active_callback'] = isset( $field['active_callback'] ) ? function () use ( $field, $active_callback_class ) {
				return $active_callback_class->evaluate( $field['active_callback'] );
			} : '__return_true';
		}

		// Code Editor
		if ( isset( $field['input_attrs'] ) ) {
			$control['input_attrs'] = $field['input_attrs'];
		}
		if ( isset( $field['code_type'] ) ) {
			$control['code_type'] = $field['code_type'];
		}

		return $control;
	}

	/**
	 * Create Customizer setting, control, and partial refresh
	 *
	 * @param array   $field Unfiltered control.
	 * @param boolean $dynamic flag for dynamic control.
	 *
	 * @return array
	 */
	public function filter_field( $field, $dynamic = false ) {
		$setting = $this->compose_setting( $field );
		$control = $this->compose_control( $field, $dynamic );
		$partial = $this->setup_partial_refresh( $field );

		// Hack transport to have postMessage.
		if ( ! empty( $partial ) ) {
			$setting['transport'] = 'postMessage';
		}

		return array(
			'setting' => $setting,
			'control' => $control,
		);
	}

	/**
	 * Prepare partial refresh
	 *
	 * @param array $field Partial refresh field.
	 *
	 * @return array
	 */
	public function setup_partial_refresh( $field ) {
		if ( ! isset( $field['partial_refresh'] ) ) {
			$field['partial_refresh'] = array();
		}

		foreach ( $field['partial_refresh'] as $id => $args ) {
			if ( ! is_array( $args ) || ! isset( $args['selector'] ) || ! isset( $args['render_callback'] ) || ! is_callable( $args['render_callback'] ) ) {
				unset( $this->partial_refresh[ $id ] );
				continue;
			}
		}

		return $field['partial_refresh'];
	}

	/**
	 * Register control type
	 */
	public function register_control_types() {
		$wp_customize = $this->wp_customize();
		$handler      = $this->get_all_control_class();

		foreach ( $handler as $handle ) {
			$wp_customize->register_control_type( $handle );
		}
	}

	/**
	 * Register Section Type
	 */
	public function register_section_types() {
		$wp_customize = $this->wp_customize();

		$wp_customize->register_section_type( 'Jeg\Customizer\Section\Helper_Section' );
		$wp_customize->register_section_type( 'Jeg\Customizer\Section\Lazy_Section' );
		$wp_customize->register_section_type( 'Jeg\Customizer\Section\Link_Section' );
		$wp_customize->register_section_type( 'Jeg\Customizer\Section\Default_Section' );
	}

	/**
	 * Register Panel Type
	 */
	public function register_panel_types() {
		$wp_customize = $this->wp_customize();

		$wp_customize->register_control_type( 'Jeg\Customizer\Panel\Alert_Panel' );
	}

	/**
	 * Get all Control Class
	 *
	 * @return array
	 */
	public function get_all_control_class() {
		$handler = array(
			'jeg-alert'           => 'Jeg\Customizer\Control\Alert',
			'jeg-header'          => 'Jeg\Customizer\Control\Header',
			'jeg-color'           => 'Jeg\Customizer\Control\Color',
			'jeg-toggle'          => 'Jeg\Customizer\Control\Toggle',
			'jeg-slider'          => 'Jeg\Customizer\Control\Slider',
			'jeg-number'          => 'Jeg\Customizer\Control\Number',
			'jeg-select'          => 'Jeg\Customizer\Control\Select',
			'jeg-ajax-select'     => 'Jeg\Customizer\Control\Ajax_Select',
			'jeg-range-slider'    => 'Jeg\Customizer\Control\Range_Slider',
			'jeg-radio-image'     => 'Jeg\Customizer\Control\Radio_Image',
			'jeg-radio-buttonset' => 'Jeg\Customizer\Control\Radio_Button_Set',
			'jeg-preset'          => 'Jeg\Customizer\Control\Preset',
			'jeg-preset-image'    => 'Jeg\Customizer\Control\Preset_Image',
			'jeg-text'            => 'Jeg\Customizer\Control\Text',
			'jeg-password'        => 'Jeg\Customizer\Control\Password',
			'jeg-textarea'        => 'Jeg\Customizer\Control\Textarea',
			'jeg-code-editor'     => 'Jeg\Customizer\Control\Code_Editor',
			'jeg-radio'           => 'Jeg\Customizer\Control\Radio',
			'jeg-image'           => 'Jeg\Customizer\Control\Image',
			'jeg-upload'          => 'Jeg\Customizer\Control\Upload',
			'jeg-spacing'         => 'Jeg\Customizer\Control\Spacing',
			'jeg-repeater'        => 'Jeg\Customizer\Control\Repeater',
			'jeg-typography'      => 'Jeg\Customizer\Control\Typography',
			'jeg-gradient'        => 'Jeg\Customizer\Control\Gradient',
		);

		return $handler;
	}

	/**
	 * Get control class
	 *
	 * @param string $type Type of control field.
	 *
	 * @return mixed
	 * @throws \InvalidArgumentException Throw if type of customizer have issue.
	 */
	public function get_control_class( $type ) {
		$handler = $this->get_all_control_class();

		if ( array_key_exists( $type, $handler ) ) {
			return $handler[ $type ];
		} else {
			throw new \InvalidArgumentException( 'Unrecognized Type. Please update your plugin to latest version.' );
		}
	}

	/**
	 * Add control to wp customize instance
	 *
	 * @param array                 $field Array of field.
	 * @param \WP_Customize_Setting $setting instance of Setting.
	 *
	 * @return mixed
	 */
	public function do_add_control( $field, $setting = null ) {
		$wp_customize  = $this->wp_customize();
		$control_class = $this->get_control_class( $field['type'] );

		if ( null !== $setting && $setting instanceof \WP_Customize_Setting ) {
			$field['settings'] = $setting->id;
		}

		$control_instance = new $control_class( $wp_customize, $field['id'], $field );
		$wp_customize->add_control( $control_instance );

		return $control_instance;
	}


	/**
	 * Handle input sanitize for every type
	 *
	 * @param string $type Type of control and what kind sanitized to be used.
	 *
	 * @return array|string
	 */
	public function sanitize_handler( $type ) {
		$sanitize_class = Sanitize::get_instance();

		switch ( $type ) {
			case 'checkbox':
			case 'jeg-toggle':
				$sanitize = array( $sanitize_class, 'sanitize_checkbox' );
				break;
			case 'image':
			case 'upload':
				$sanitize = array( $sanitize_class, 'sanitize_url' );
				break;
			case 'jeg-typography':
				$sanitize = array( $sanitize_class, 'sanitize_typography' );
				break;
			case 'jeg-number':
			case 'jeg-slider':
				$sanitize = array( $sanitize_class, 'sanitize_number' );
				break;
			case 'repeater':
			case 'jeg-repeater':
				$sanitize = array( $sanitize_class, 'by_pass' );
				break;
			default:
				$sanitize = array( $sanitize_class, 'sanitize_input' );
				break;
		}

		return $sanitize;
	}

	/**
	 * Get setting class
	 *
	 * @param string $type Type of class for setting option.
	 *
	 * @return string
	 */
	public function get_setting_class( $type ) {
		switch ( $type ) {
			case 'jeg-repeater':
				$setting_class = 'Jeg\Customizer\Setting\Repeater_Setting';
				break;
			case 'jeg-spacing':
				$setting_class = 'Jeg\Customizer\Setting\Spacing_Setting';
				break;
			default:
				$setting_class = 'Jeg\Customizer\Setting\Default_Setting';
				break;
		}

		return $setting_class;
	}

	/**
	 * Add Setting to wp customize instance base on what kind of class instance used
	 *
	 * @param array  $setting Array of setting.
	 * @param string $setting_id Name of setting ID.
	 *
	 * @return \WP_Customize_Setting
	 */
	public function do_add_setting( $setting, $setting_id = null ) {
		$wp_customize = $this->wp_customize();

		if ( null === $setting_id ) {
			$setting_id = $setting['id'];
		}

		$setting_class    = $this->get_setting_class( $setting['control_type'] );
		$setting_instance = new $setting_class( $wp_customize, $setting_id, $setting );
		$wp_customize->add_setting( $setting_instance );

		return $setting_instance;
	}

	/**
	 * Only Normal Field
	 *
	 * @return array
	 */
	public function get_fields() {
		return $this->fields;
	}


	/**
	 * Get all registered lazy fields
	 *
	 * @return array
	 */
	public function get_lazy_fields() {
		$fields   = array();
		$sections = $this->get_registered_lazy_section();

		foreach ( $sections as $key => $section ) {
			foreach ( $section as $file ) {
				$options = $this->get_lazy_options( $file );
				foreach ( $options as $option ) {
					$fields[ $option['id'] ]            = $option;
					$fields[ $option['id'] ]['section'] = $key;
				}
			}
		}

		return $fields;
	}

	/**
	 * Get both normal & lazy loaded fields
	 *
	 * @param array $extract Callable for excluding field.
	 *
	 * @return array
	 */
	public function get_all_fields( $extract = null ) {
		$extract   = is_callable( $extract ) ? $extract : array( $this, 'extract_fields' );
		$cache_key = $extract[1];

		if ( ! isset( $this->cache_fields[ $cache_key ] ) ) {
			$lazy_fields   = $this->get_lazy_fields();
			$normal_fields = $this->get_fields();
			$fields        = array_merge( $normal_fields, $lazy_fields );
			$results       = array();

			foreach ( $fields as $key => $field ) {
				$result = call_user_func_array( $extract, array( $field, $key ) );
				if ( $result ) {
					$results[ $key ] = $result;
				}
			}

			$this->cache_fields[ $cache_key ] = $results;
		}

		return $this->cache_fields[ $cache_key ];
	}

	/**
	 * Return Fields without Partial Refresh
	 *
	 * @param array $field Field.
	 *
	 * @return mixed
	 */
	public function extract_fields( $field ) {
		unset( $field['partial_refresh'] );

		return $field;
	}

	/**
	 * Get all registered section
	 *
	 * @return array
	 */
	public function get_sections() {
		return $this->sections;
	}

	/**
	 * Get all registered panel
	 *
	 * @return array
	 */
	public function get_panels() {
		return $this->panels;
	}

	/**
	 * Build search template
	 */
	public function search_template() {
		?>
		<script type="text/html" id="tmpl-search-wrapper">
			<div class='customizer-search-wrapper'>
				<a href='#' class='customizer-search-toggle'>
					<i class='fa fa-search'></i>
				</a>
				<form class='customizer-form-search'>
					<input type='text' name='customizer-form-input'/>
				</form>
			</div>
			<div class='customizer-search-result'>
				<div class='customizer-search-result-wrapper'></div>
				<div class='search-loader hidden'>
					<div class='loader'></div>
				</div>
			</div>
		</script>

		<script type="text/html" id="tmpl-search-overlay">
			<div class='customizer-search-overlay'></div>
		</script>

		<script type="text/html" id="tmpl-search-control">
			<ul>
				<# for ( key in data ) { #>
				<# var control = data[key]; #>
				<li class='search-li' data-section='{{ control.section }}' data-control='{{ control.id }}'>
					<span>{{ control.path }}</span>
					<h3>{{ control.label }}</h3>
					<em>{{ control.description }}</em>
				</li>
				<# } #>
			</ul>
		</script>
		<?php
	}

	/**
	 * Build widget template
	 */
	public function widget_template() {
		?>
		<script type="text/html" id="tmpl-widget-alert">
			<div class='customize-alert customize-alert-info'>
				<label>
					<strong class='customize-control-title'>{{ data.title }}</strong>
					<div class='description customize-control-description'>
						<ul>
							<# for ( word in data.words ) { #>
							<li>{{ data.words[word] }}</li>
							<# } #>
						</ul>
					</div>
				</label>
			</div>
		</script>
		<?php
	}

	/**
	 * Register scripts for Jeg Customizer.
	 */
	public function register_scripts() {
		$wp_scripts = wp_scripts();

		$handle    = 'jeg-extend-widget';
		$src       = JEG_URL . '/assets/js/customizer/widget-extend.js';
		$deps      = array( 'jquery', 'customize-widgets' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'selectize';
		$src       = JEG_URL . '/assets/js/vendor/selectize.min.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'serialize-js';
		$src       = JEG_URL . '/assets/js/vendor/serialize.js';
		$deps      = array();
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'wp-color-picker-alpha';
		$src       = JEG_URL . '/assets/js/vendor/wp-color-picker-alpha.min.js';
		$deps      = array( 'wp-color-picker' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$wp_scripts->localize(
			'wp-color-picker-alpha',
			'wpColorPickerL10n',
			array(
				'clear'            => esc_html__( 'Clear', 'jeg-elementor-kit' ),
				'clearAriaLabel'   => esc_html__( 'Clear color', 'jeg-elementor-kit' ),
				'defaultString'    => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'defaultAriaLabel' => esc_html__( 'Select default color', 'jeg-elementor-kit' ),
				'pick'             => esc_html__( 'Select color', 'jeg-elementor-kit' ),
				'defaultLabel'     => esc_html__( 'Color value', 'jeg-elementor-kit' ),
			)
		);

		wp_add_inline_script(
			'wp-color-picker-alpha',
			'console.log("find.that");jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
		);

		$handle    = 'codemirror';
		$deps      = array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' );
		$in_footer = 1;
		$wp_scripts->add( $handle, 'wp-codemirror', $deps, $this->version, $in_footer );

		$handle    = 'jeg-validate-css';
		$src       = JEG_URL . '/assets/js/customizer/validate-css-value.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-active-callback';
		$src       = JEG_URL . '/assets/js/customizer/active-callback.js';
		$deps      = array( 'underscore' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-search-customizer';
		$src       = JEG_URL . '/assets/js/customizer/search-control.js';
		$deps      = array( 'jquery', 'underscore' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-customizer-late-init';
		$src       = JEG_URL . '/assets/js/customizer/late-init-customizer.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'ion-range-slider';
		$src       = JEG_URL . '/assets/js/vendor/ion.rangeSlider.min.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-set-setting-value';
		$src       = JEG_URL . '/assets/js/customizer/set-setting-value.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		// ... Control
		$handle    = 'jeg-default-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-default.js';
		$deps      = array( 'customize-controls', 'underscore' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-alert-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-alert.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-header-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-header.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-color-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-color.js';
		$deps      = array(
			'jquery',
			'customize-controls',
			'wp-color-picker-alpha',
			'jeg-default-control',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-toggle-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-toggle.js';
		$deps      = array( 'jquery', 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-slider-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-slider.js';
		$deps      = array( 'jquery', 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-number-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-number.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'jquery-ui-spinner' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-select-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-select.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'selectize' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-ajax-select-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-ajax-select.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'selectize' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-range-slider-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-range-slider.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'ion-range-slider' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-radio-image-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-radio-image.js';
		$deps      = array( 'jquery', 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-radio-buttonset-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-radio-buttonset.js';
		$deps      = array( 'jquery', 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-preset-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-preset.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'jeg-set-setting-value' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-preset-image-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-preset-image.js';
		$deps      = array( 'jquery', 'jeg-default-control', 'selectize' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-text-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-text.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-password-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-text.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-textarea-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-textarea.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-code-editor-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-code-editor.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-radio-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-radio.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-image-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-image.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-upload-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-upload.js';
		$deps      = array( 'jeg-default-control' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-spacing-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-spacing.js';
		$deps      = array( 'jeg-default-control', 'jeg-validate-css' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-repeater-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-repeater.js';
		$deps      = array(
			'jeg-default-control',
			'jquery-ui-sortable',
			'wp-color-picker',
			'selectize',
			'serialize-js',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-typography-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-typography.js';
		$deps      = array( 'jeg-default-control', 'selectize', 'wp-color-picker-alpha' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-gradient-control';
		$src       = JEG_URL . '/assets/js/customizer-control/control-gradient.js';
		$deps      = array( 'jeg-default-control', 'selectize', 'wp-color-picker-alpha' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		// ... Section
		$handle    = 'jeg-default-section';
		$src       = JEG_URL . '/assets/js/customizer-section/default-section.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-link-section';
		$src       = JEG_URL . '/assets/js/customizer-section/link-section.js';
		$deps      = array( 'jquery' );
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-lazy-section';
		$src       = JEG_URL . '/assets/js/customizer-section/lazy-section.js';
		$deps      = array(
			'jquery',
			'underscore',
			'jeg-default-section',
			'jeg-alert-control',
			'jeg-header-control',
			'jeg-color-control',
			'jeg-toggle-control',
			'jeg-slider-control',
			'jeg-number-control',
			'jeg-select-control',
			'jeg-ajax-select-control',
			'jeg-range-slider-control',
			'jeg-radio-image-control',
			'jeg-radio-buttonset-control',
			'jeg-preset-control',
			'jeg-preset-image-control',
			'jeg-text-control',
			'jeg-textarea-control',
			'jeg-code-editor-control',
			'jeg-radio-control',
			'jeg-image-control',
			'jeg-upload-control',
			'jeg-spacing-control',
			'jeg-repeater-control',
			'jeg-typography-control',
			'jeg-gradient-control',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		// ... Connect To Previewer
		$handle    = 'jeg-previewer-sync';
		$src       = JEG_URL . '/assets/js/customizer/previewer-sync.js';
		$deps      = array(
			'underscore',
			'customize-controls',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );
	}

	/**
	 * Load css on Customizer Panel
	 */
	public function customizer_styles() {
		wp_enqueue_style( 'selectize', JEG_URL . '/assets/css/selectize.default.css', null, '0.12.2' );
		wp_enqueue_style( 'jeg-customizer-css', JEG_URL . '/assets/css/customizer.css', array( 'wp-color-picker' ), $this->version );
		wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
		// fontawesome 6
		wp_enqueue_style( 'font-awesome', JEG_URL . '/assets/font/font-awesome/css/fontawesome.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-solid', JEG_URL . '/assets/font/font-awesome/css/solid.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-brands', JEG_URL . '/assets/font/font-awesome/css/brands.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-regular', JEG_URL . '/assets/font/font-awesome/css/regular.min.css', null, '6.2.0' );
		wp_enqueue_style( 'font-awesome-v4-font-face', JEG_URL . '/assets/font/font-awesome/css/v4-font-face.min.css', null, '6.2.0' );

		wp_enqueue_style( 'ion-range-slider', JEG_URL . '/assets/css/ion.rangeSlider.css', null, '2.0.3' );
		wp_enqueue_style( 'ion-range-slider-skin', JEG_URL . '/assets/css/ion.rangeSlider.skinFlat.css', null, '2.0.3' );

		if ( is_rtl() ) {
			wp_enqueue_style( 'jeg-customizer-css-rtl', JEG_URL . '/assets/css/customizer-rtl.css', null, $this->version );
		}
	}

	/**
	 * Load script on Customizer Panel
	 */
	public function enqueue_control_script() {
		wp_enqueue_script( 'jeg-customizer-late-init' );
		wp_enqueue_script( 'jeg-active-callback' );
		wp_enqueue_script( 'jeg-previewer-sync' );
		wp_enqueue_script( 'jeg-lazy-section' );
		wp_enqueue_script( 'jeg-link-section' );
		wp_enqueue_script( 'jeg-search-customizer' );
		wp_enqueue_script( 'jeg-extend-widget' );

		wp_localize_script(
			'jeg-typography-control',
			'jegAllFonts',
			$this->load_all_font()
		);

		wp_localize_script(
			'jeg-lazy-section',
			'lazySetting',
			array(
				'ajaxUrl' => add_query_arg( array( $this->endpoint => 'jeg' ), esc_url( home_url( '/', 'relative' ) ) ),
				'nonce'   => wp_create_nonce( $this->endpoint ),
			)
		);

		wp_localize_script(
			'jeg-search-customizer',
			'searchSetting',
			array(
				'ajaxUrl' => add_query_arg( array( $this->endpoint => 'jeg' ), esc_url( home_url( '/', 'relative' ) ) ),
				'nonce'   => wp_create_nonce( $this->endpoint ),
			)
		);

		wp_localize_script(
			'jeg-previewer-sync',
			'partialSetting',
			array(
				'patternTemplate' => Lazy_Partial::js_pattern_template(),
			)
		);

		wp_localize_script(
			'jeg-extend-widget',
			'widgetLang',
			array(
				'title' => esc_html__( 'Notice', 'jeg-elementor-kit' ),
				'words' => array(
					esc_html__( 'To improve customizer load speed, we disable widget option on customizer for element.', 'jeg-elementor-kit' ),
					esc_html__( 'You can still modify widget content from Widget Panel on Admin Page', 'jeg-elementor-kit' ),
				),
			)
		);
	}

	/**
	 * Get all excluded font
	 *
	 * @return mixed
	 */
	public function get_excluded_font() {
		return apply_filters( 'jeg_not_google_font', array() );
	}

	/**
	 * Load script at Customizer Preview
	 */
	public function previewer_script() {
		$wp_scripts = wp_scripts();

		// ... Customizer Preview Script
		$handle    = 'jeg-customizer-preview';
		$src       = JEG_URL . '/assets/js/customizer/customizer-preview.js';
		$deps      = array(
			'underscore',
			'customize-preview',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-customizer-output-preview';
		$src       = JEG_URL . '/assets/js/customizer/style-output-preview.js';
		$deps      = array(
			'jquery',
			'underscore',
			'customize-preview',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-customizer-partial-preview';
		$src       = JEG_URL . '/assets/js/customizer/partial-refresh-preview.js';
		$deps      = array(
			'jquery',
			'underscore',
			'customize-preview',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'vex';
		$src       = JEG_URL . '/assets/js/customizer/vex.combined.min.js';
		$deps      = array(
			'jquery',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		$handle    = 'jeg-customizer-redirect-tag-preview';
		$src       = JEG_URL . '/assets/js/customizer/redirect-tag-preview.js';
		$deps      = array(
			'vex',
			'jquery',
			'underscore',
			'customize-preview',
		);
		$in_footer = 1;
		$wp_scripts->add( $handle, $src, $deps, $this->version, $in_footer );

		// enqueue script.
		wp_enqueue_script( 'jeg-customizer-preview' );
		wp_enqueue_script( 'jeg-customizer-output-preview' );
		wp_enqueue_script( 'jeg-customizer-partial-preview' );
		wp_enqueue_script( 'jeg-customizer-redirect-tag-preview' );

		wp_localize_script(
			'jeg-customizer-output-preview',
			'outputSetting',
			array(
				'excludeFont'     => $this->get_excluded_font(),
				'settingPattern'  => Default_Setting::$lazy_js_pattern,
				'inlinePrefix'    => Style_Generator::$inline_prefix,
				'redirectTag'     => $this->redirect_tag(),
				'redirectSetting' => array(
					'changeNotice' => wp_kses( __( 'Change you made not showing on this page.<br/> Do you want to be redirected to the appropriate page to see change you just made?', 'jeg-elementor-kit' ), wp_kses_allowed_html() ),
					'yes'          => esc_html__( 'Yes', 'jeg-elementor-kit' ),
				),
			)
		);

		// ... Load style
		wp_enqueue_style( 'vex', JEG_URL . '/assets/css/vex.css', null, $this->version );
		wp_enqueue_style( 'theme-customizer', JEG_URL . '/assets/css/theme-customizer.css', null, $this->version );
	}

	/**
	 * Redirect Tag List
	 *
	 * @return array
	 */
	public function redirect_tag() {
		return apply_filters( 'jeg_redirect_tag', array() );
	}
}
