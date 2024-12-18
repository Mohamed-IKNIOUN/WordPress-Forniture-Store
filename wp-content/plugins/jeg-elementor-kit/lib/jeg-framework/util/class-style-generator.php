<?php
/**
 * Style Generator
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Util;

use Jeg\Customizer\Customizer;
use Jeg\Customizer\Active_Callback;

/**
 * Class Style_Generator
 *
 * @package Jeg\Util
 */
class Style_Generator {
	/**
	 * Instance of Style Generator
	 *
	 * @var Style_Generator
	 */
	private static $instance;

	/**
	 * Instance of active callback
	 *
	 * @var \Jeg\Customizer\Active_Callback
	 */
	private $active_callback;

	/**
	 * Extension for css
	 *
	 * @var string
	 */
	private $extension = 'css';

	/**
	 * File name prefix
	 *
	 * @var string
	 */
	private $prefix_file = 'jeg-';

	/**
	 * Option name saved on database
	 *
	 * @var string
	 */
	private $file_hash = 'jeg-style-hash';

	/**
	 * Folder name to save file
	 *
	 * @var string
	 */
	private $folder_name = 'jeg';

	/**
	 * Prefix for inline css (customizer)
	 *
	 * @var string
	 */
	public static $inline_prefix = 'jeg_style_';

	/**
	 * Singleton function for Style Generator
	 *
	 * @return Style_Generator
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Style_Generator constructor
	 */
	private function __construct() {
		add_action( 'wp_head', array( $this, 'inline_dynamic_css' ), 99 );
		add_filter( 'wp_resource_hints', array( $this, 'resource_hints' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_google_font' ) );
		add_action( 'customize_save_after', array( $this, 'remove_css_option' ) );
	}

	/**
	 * Get active callback
	 *
	 * @return Active_Callback
	 */
	public function get_active_callback() {
		if ( null === $this->active_callback ) {
			$this->active_callback = Active_Callback::get_instance();
		}

		return $this->active_callback;
	}

	/**
	 * Generate Google Font Index,
	 * Selalu update saat update webfonts
	 * Panggil fungsi ini kalau ada update di webfonts
	 */
	public function generate_google_font_index() {
		$google_font = Font::get_google_fonts();
		$google_font = array_keys( $google_font );
		$google_html = '';
		foreach ( $google_font as $font ) {
			$google_html .= "'{$font}',";
		}
		$google_html = "array({$google_html})";
		echo esc_html( $google_html );
	}

	/**
	 * Only return output field
	 *
	 * @param array $field Option field.
	 *
	 * @return null
	 */
	public function extract_outputs( $field ) {
		return isset( $field['output'] ) ? $field['output'] : null;
	}

	/**
	 * Allow style
	 *
	 * @return mixed
	 */
	public function allow_style() {
		$tags['style'] = array( 'id' => true );

		return $tags;
	}

	/**
	 * Build preview style on customizer
	 *
	 * @param string $setting setting ID.
	 * @param array  $field Field Setting.
	 */
	public function build_preview_style( $setting, $field ) {
		$value = Setting::get( $setting );

		if ( ! empty( $value ) ) {
			if ( isset( $field['output'] ) ) {
				$styles    = $field['output'];
				$new_style = '';

				if ( $this->get_active_callback()->evaluate_by_id( $setting ) ) {
					foreach ( $styles as $style ) {
						if ( 'inject-style' === $style['method'] ) {
							$new_style .= $style['element'] . ' { ' . $this->style_parse( $setting, $style ) . ' } ';

							if ( isset( $style['mediaquery'] ) ) {
								$new_style = $style['mediaquery'] . ' { ' . $new_style . ' } ';
							}
						}

						if ( 'typography' === $style['method'] ) {
							$new_style .= $style['element'] . ' { ' . $this->font_parse( $setting, $style ) . ' } ';
						}

						if ( 'gradient' === $style['method'] ) {
							$new_style .= $style['element'] . ' { ' . $this->gradient_style( $setting, $style ) . ' } ';
						}
					}
				}

				if ( ! empty( $new_style ) ) {
					add_filter( 'esc_html', array( $this, 'allow_greater_sign' ) );
					add_filter( 'esc_html', array( $this, 'allow_double_quote' ) );
					?>
					<style id='<?php echo esc_attr( $this->inline_preview_style_id( $setting ) ); ?>'><?php echo esc_html( $new_style ); ?></style>
					<?php
					remove_filter( 'esc_html', array( $this, 'allow_greater_sign' ) );
					remove_filter( 'esc_html', array( $this, 'allow_double_quote' ) );
				}
			}
		}
	}

	/**
	 * Inline preview
	 *
	 * @param string $setting Name of setting.
	 *
	 * @return string
	 */
	public function inline_preview_style_id( $setting ) {
		$setting = str_replace( '[', '_', rtrim( $setting, ']' ) );
		return self::$inline_prefix . $setting;
	}

	/**
	 * Convert back "&gt;" to greater sign text  ">"
	 *
	 * @param string $text Style that need to be converted.
	 *
	 * @return string
	 */
	public function allow_greater_sign( $text ) {
		return str_replace( '&gt;', '>', $text );
	}

	/**
	 * Convert back '&quot;' to double quote sign text '"'
	 *
	 * @param string $text Style that need to be converted.
	 *
	 * @return string
	 */
	public function allow_double_quote( $text ) {
		return str_replace( '&quot;', '"', $text );
	}

	/**
	 * Gradient style generator
	 *
	 * @param string $setting Setting ID.
	 * @param array  $style array of style.
	 *
	 * @return null|string
	 */
	public function gradient_style( $setting, $style ) {
		if ( Setting::get( $setting ) ) {
			$gradient      = Setting::get( $setting );
			$degree        = $gradient['degree'];
			$begincolor    = $gradient['begincolor'];
			$beginlocation = $gradient['beginlocation'];
			$endcolor      = $gradient['endcolor'];
			$endlocation   = $gradient['endlocation'];

			return "background: -moz-linear-gradient({$degree}deg, {$begincolor} {$beginlocation}%, {$endcolor} {$endlocation}%);" .
				   "background: -webkit-linear-gradient({$degree}deg, {$begincolor} {$beginlocation}%, {$endcolor} {$endlocation}%);" .
				   "background: -o-linear-gradient({$degree}deg, {$begincolor} {$beginlocation}%, {$endcolor} {$endlocation}%);" .
				   "background: -ms-linear-gradient({$degree}deg, {$begincolor} {$beginlocation}%, {$endcolor} {$endlocation}%);" .
				   "background: linear-gradient({$degree}deg, {$begincolor} {$beginlocation}%, {$endcolor} {$endlocation}%);";
		}

		return null;
	}

	/**
	 * Create and check folder
	 *
	 * @return bool
	 */
	public function check_folder() {
		$wp_upload_dir = wp_upload_dir();

		if ( ! is_dir( $wp_upload_dir['basedir'] . '/' . $this->folder_name ) ) {
			if ( ! mkdir( $wp_upload_dir['basedir'] . '/' . $this->folder_name, 0777 ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Get CSS File path
	 *
	 * @return string
	 */
	public function get_file_path() {
		$wp_upload_dir = wp_upload_dir();

		return sprintf( '%s/jeg/%s.%s', $wp_upload_dir['basedir'], $this->prefix_file . $this->get_file_hash(), $this->extension );
	}

	/**
	 * Get CSS File URL
	 *
	 * @return string
	 */
	public function get_file_url() {
		$wp_upload_dir = wp_upload_dir();

		return sprintf( '%s/jeg/%s.%s', $wp_upload_dir['baseurl'], $this->prefix_file . $this->get_file_hash(), $this->extension );
	}

	/**
	 * Remove dynamic file
	 */
	public function remove_css_option() {
		update_option( 'jeg-dynamic-css', null );
	}

	/**
	 * Get dynamic file name
	 *
	 * @return mixed
	 */
	public function get_file_hash() {
		$hash = get_option( $this->file_hash );

		if ( ! $hash ) {
			update_option( $this->file_hash, $this->generate_random() );
		}

		return $hash;
	}

	/**
	 * Generate random file name
	 *
	 * @param int $length Length of file name. Default 10.
	 *
	 * @return bool|string
	 */
	public function generate_random( $length = 10 ) {
		$x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr( str_shuffle( str_repeat( $x, ceil( $length / strlen( $x ) ) ) ), 1, $length );
	}

	/**
	 * Remove Generated CSS file
	 */
	public function remove_dynamic_file() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();
		}

		$file_path = $this->get_file_path();

		if ( $this->check_folder() ) {
			$wp_filesystem->delete( $file_path );
		}
	}

	/**
	 * Generate CSS File
	 *
	 * @return bool
	 */
	public function generate_css_file() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();
		}

		$file_path = $this->get_file_path();

		$styles = get_option( 'jeg-dynamic-css' );

		if ( $this->check_folder() ) {
			if ( $wp_filesystem->put_contents( $file_path, $styles, 0777 ) ) {
				return true;
			} else {
				if ( file_put_contents( $file_path, $styles ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Inline dynamic css
	 */
	public function inline_dynamic_css() {
		do_action( 'jeg_before_inline_dynamic_css' );

		wp_enqueue_style( 'jeg-dynamic-style', JEG_URL . '/assets/css/jeg-dynamic-styles.css', null, JEG_VERSION );

		if ( is_customize_preview() ) {
			wp_add_inline_style( 'jeg-dynamic-style', apply_filters( 'jeg_generate_inline_style', '' ) );

			$fields = Customizer::get_instance()->get_all_fields();

			foreach ( $fields as $setting => $field ) {
				$this->build_preview_style( $setting, $field );
			}
		} else {
			$styles = get_option( 'jeg-dynamic-css' );

			if ( null === $styles ) {
				$styles = apply_filters( 'jeg_generate_inline_style', $this->build_inline_style() );

				update_option( 'jeg-dynamic-css', $styles );
			}

			wp_add_inline_style( 'jeg-dynamic-style', $styles );
		}

		do_action( 'jeg_after_inline_dynamic_css' );
	}

	/**
	 * Remove enter or whitespace line for each element
	 *
	 * @param string $element CSS element.
	 *
	 * @return mixed
	 */
	public function concat_element( $element ) {
		return preg_replace( '/\s\s+/', ' ', $element );
	}

	/**
	 * Build Inline Style
	 *
	 * @return string
	 */
	public function build_inline_style() {
		$media_queries = $this->generate_css();
		$media         = '';

		foreach ( $media_queries as $query => $styles ) {
			$style_string = '';

			foreach ( $styles as $element => $style ) {
				$element      = $this->concat_element( $element );
				$style_string = $style_string . $element . ' { ' . implode( ' ', $style ) . ' } ';
			}

			$media = ( 'default' === $query ) ? $media . $style_string : $media . $query . ' { ' . $style_string . ' } ';
		}

		return $media;
	}

	/**
	 * Generate CSS
	 *
	 * @return mixed
	 */
	public function generate_css() {
		$fields = Customizer::get_instance()->get_all_fields( array( $this, 'extract_outputs' ) );

		$generated_style = array();

		foreach ( $fields as $setting => $styles ) {
			// check if dependency is meet.
			if ( $this->get_active_callback()->evaluate_by_id( $setting ) ) {
				foreach ( $styles as $style ) {
					$new_style = '';

					if ( 'inject-style' === $style['method'] ) {
						$new_style = $this->style_parse( $setting, $style );
					}

					if ( 'typography' === $style['method'] ) {
						$new_style = $this->font_parse( $setting, $style );
					}

					if ( 'gradient' === $style['method'] ) {
						$new_style = $this->gradient_style( $setting, $style );
					}

					if ( ! empty( $new_style ) ) {
						$media = isset( $style['mediaquery'] ) ? $style['mediaquery'] : 'default';

						$generated_style[ $media ][ $style['element'] ][] = $new_style;
					}
				}
			}
		}

		return apply_filters( 'jeg_generated_style_array', $generated_style, $fields );
	}

	/**
	 * Load Google Font
	 */
	public function load_google_font() {
		$fonts = $this->get_google_font_setting();

		if ( is_array( $fonts ) ) {
			$this->add_google_font_to_header( $fonts );
		}
	}

	/**
	 * Get google font setting
	 *
	 * @return array|bool
	 */
	public function get_google_font_setting() {
		$settings = apply_filters( 'jeg_fonts_option_setting', '' );
		$fonts    = array();

		if ( $settings ) {
			foreach ( $settings as $setting ) {
				$option = Setting::get( $setting );

				if ( $option ) {
					$fonts[] = array(
						'setting' => $setting,
						'name'    => $option['font-family'],
						'variant' => isset( $option['variant'] ) ? $option['variant'] : '',
						'subsets' => isset( $option['subsets'] ) ? $option['subsets'] : '',
					);
				}
			}

			return $fonts;
		}

		return false;
	}

	/**
	 * Add google font to header
	 *
	 * @param array $fonts Array of font.
	 */
	public function add_google_font_to_header( $fonts ) {
		if ( is_customize_preview() ) {
			foreach ( $fonts as $font ) {
				if ( Font::is_google_font( $font['name'] ) && ! Setting::get( 'jeg_gdpr_google_font_disable', false ) ) {
					$font_detail = array();
					$font_array  = array();

					$variant      = empty( $font['variant'] ) ? array( 'reguler' ) : $font['variant'];
					$font_array[] = $font['name'] . ':' . implode( ',', $variant );

					if ( ! empty( $font['subsets'] ) ) {
						$subsets               = $font['subsets'];
						$font_detail['subset'] = rawurlencode( implode( ',', $subsets ) );
					}

					if ( ! empty( $font_array ) ) {
						$font_detail['family'] = str_replace( '%2B', '+', rawurlencode( implode( '|', $font_array ) ) );
						$font_url              = add_query_arg( $font_detail, '//fonts.googleapis.com/css' );
						wp_enqueue_style( $font['setting'], $font_url, null, JEG_VERSION );
					}
				}
			}
		} else {
			$font_url = $this->generate_font_url( $fonts );

			if ( $font_url ) {
				wp_enqueue_style( 'jeg_customizer_font', $font_url, null, JEG_VERSION );
			}
		}
	}

	/**
	 * Add fonts.gstatic.com
	 */
	public function resource_hints( $urls, $relation_type ) {
		if ( wp_style_is( 'jeg_customizer_font', 'queue' ) ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$urls[] = 'https://fonts.googleapis.com/';
			}
			if ( 'preconnect' === $relation_type ) {
				$urls[] = 'https://fonts.gstatic.com/';
			}
		}

		return $urls;
	}

	/**
	 * Generate Font URL
	 *
	 * @param array $fonts array of font.
	 *
	 * @return bool|string
	 */
	public function generate_font_url( $fonts ) {
		$subsets      = array();
		$font_variant = array();

		foreach ( $fonts as $font ) {
			if ( isset( $font['name'] ) && ! empty( $font['name'] ) ) {
				if ( Font::is_google_font( $font['name'] ) && ! Setting::get( 'jeg_gdpr_google_font_disable', false ) ) {
					if ( isset( $font['subsets'] ) && ! empty( $font['subsets'] ) ) {
						foreach ( $font['subsets'] as $subset ) {
							if ( ! in_array( $subset, $subsets, true ) ) {
								$subsets[] = $subset;
							}
						}
					}

					if ( ! isset( $font_variant[ $font['name'] ] ) ) {
						$font_variant[ $font['name'] ] = array();
					}

					if ( ! in_array( $font['variant'], $font_variant[ $font['name'] ], true ) && ! empty( $font['variant'] ) ) {
						$font_variant[ $font['name'] ][] = $font['variant'];
					}
				}
			}
		}

		$font_array = array();

		foreach ( $font_variant as $font => $variant ) {
			if ( empty( $variant ) ) {
				$variant = array( 'reguler' );
			} else {
				$variant = call_user_func_array( 'array_merge', $variant );
			}
			$font_array[] = $font . ':' . implode( ',', $variant );
		}

		if ( ! empty( $font_array ) ) {
			$font_detail           = array();
			$font_detail['family'] = str_replace( '%2B', '+', rawurlencode( implode( '|', $font_array ) ) );

			if ( ! empty( $subsets ) ) {
				$font_detail['subset'] = rawurlencode( implode( ',', $subsets ) );
			}

			$font_detail['display'] = 'swap';

			$font_url = add_query_arg( $font_detail, '//fonts.googleapis.com/css' );

			return $font_url;
		}

		return false;
	}

	/**
	 * Get list of font variant
	 *
	 * @param string $variant font variant.
	 *
	 * @return array
	 */
	public function get_font_variant( $variant ) {
		if ( '100' === $variant ) {
			return array(
				'weight' => '100',
				'style'  => 'normal',
			);
		}
		if ( '100reguler' === $variant ) {
			return array(
				'weight' => '100',
				'style'  => 'reguler',
			);
		}
		if ( '100italic' === $variant ) {
			return array(
				'weight' => '100',
				'style'  => 'italic',
			);
		}
		if ( '200' === $variant ) {
			return array(
				'weight' => '200',
				'style'  => 'normal',
			);
		}
		if ( '200reguler' === $variant ) {
			return array(
				'weight' => '200',
				'style'  => 'reguler',
			);
		}
		if ( '200italic' === $variant ) {
			return array(
				'weight' => '200',
				'style'  => 'italic',
			);
		}
		if ( '300' === $variant ) {
			return array(
				'weight' => '300',
				'style'  => 'normal',
			);
		}
		if ( '300reguler' === $variant ) {
			return array(
				'weight' => '300',
				'style'  => 'reguler',
			);
		}
		if ( '300italic' === $variant ) {
			return array(
				'weight' => '300',
				'style'  => 'italic',
			);
		}
		if ( 'regular' === $variant ) {
			return array(
				'weight' => '400',
				'style'  => 'normal',
			);
		}
		if ( 'italic' === $variant ) {
			return array(
				'weight' => '400',
				'style'  => 'italic',
			);
		}
		if ( '400reguler' === $variant ) {
			return array(
				'weight' => '400',
				'style'  => 'reguler',
			);
		}
		if ( '400italic' === $variant ) {
			return array(
				'weight' => '400',
				'style'  => 'italic',
			);
		}
		if ( '500' === $variant ) {
			return array(
				'weight' => '500',
				'style'  => 'normal',
			);
		}
		if ( '500reguler' === $variant ) {
			return array(
				'weight' => '500',
				'style'  => 'reguler',
			);
		}
		if ( '500italic' === $variant ) {
			return array(
				'weight' => '500',
				'style'  => 'italic',
			);
		}
		if ( '600' === $variant ) {
			return array(
				'weight' => '600',
				'style'  => 'normal',
			);
		}
		if ( '600reguler' === $variant ) {
			return array(
				'weight' => '600',
				'style'  => 'reguler',
			);
		}
		if ( '600italic' === $variant ) {
			return array(
				'weight' => '600',
				'style'  => 'italic',
			);
		}
		if ( '700' === $variant ) {
			return array(
				'weight' => '700',
				'style'  => 'normal',
			);
		}
		if ( '700reguler' === $variant ) {
			return array(
				'weight' => '700',
				'style'  => 'reguler',
			);
		}
		if ( '700italic' === $variant ) {
			return array(
				'weight' => '700',
				'style'  => 'italic',
			);
		}
		if ( '800' === $variant ) {
			return array(
				'weight' => '800',
				'style'  => 'normal',
			);
		}
		if ( '800reguler' === $variant ) {
			return array(
				'weight' => '800',
				'style'  => 'reguler',
			);
		}
		if ( '800italic' === $variant ) {
			return array(
				'weight' => '800',
				'style'  => 'italic',
			);
		}
		if ( '900' === $variant ) {
			return array(
				'weight' => '900',
				'style'  => 'normal',
			);
		}
		if ( '900reguler' === $variant ) {
			return array(
				'weight' => '900',
				'style'  => 'reguler',
			);
		}
		if ( '900italic' === $variant ) {
			return array(
				'weight' => '900',
				'style'  => 'italic',
			);
		}
	}


	/**
	 * font family add double quote if font family
	 * has space.
	 *
	 * @param string $font_family_list font family lists.
	 *
	 * @param string $fallbacks fallback font family.
	 *
	 * @return string
	 */
	public function font_family_helper( $font_family_list, $fallbacks ) {
		$font_family = explode( ',', $font_family_list );
		$fallback    = explode( ',', $fallbacks );
		foreach ( $font_family as $key => $value ) {
			if ( strpos( $value, ' ' ) ) {
				$font_family[ $key ] = '"' . $value . '"';
			}
		}
		if ( count( $font_family ) === 1 ) {
			$font_family = array_merge( $font_family, $fallback );
		}
		$font_family_list = implode( ',', $font_family );

		return $font_family_list;
	}

	/**
	 * Parse setting to get font style
	 *
	 * @param string $setting name of font option.
	 * @param array  $option array of option.
	 *
	 * @return null|string
	 */
	public function font_parse( $setting, $option ) {
		if ( Setting::get( $setting ) ) {
			$font = Setting::get( $setting );

			$style = '';

			if ( isset( $font['font-family'] ) && ! empty( $font['font-family'] ) ) {
				$style .= 'font-family: ' . $this->font_family_helper( $font['font-family'], 'Helvetica,Arial,sans-serif' ) . ';';

				if ( is_array( $font['variant'] ) && 1 === count( $font['variant'] ) && isset( $font['variant'] ) && ! empty( $font['variant'] ) ) {
					$variant = $this->get_font_variant( $font['variant'][0] );

					$style .= 'font-weight : ' . $variant['weight'] . '; ';
					$style .= 'font-style : ' . $variant['style'] . '; ';
				}
			}

			if ( ! empty( $font['font-size'] ) ) {
				$font_size = Sanitize::css_dimension( $font['font-size'] );
				if ( is_numeric( $font_size ) ) {
					if ( $font['font-size-unit'] && '' !== $font['font-size-unit'] ) {
						$style .= 'font-size: ' . $font_size . $font['font-size-unit'] . '; ';
					} else {
						$style .= 'font-size: ' . $font_size . 'px; ';
					}
				} else {
					$style .= 'font-size: ' . $font['font-size'] . '; ';
				}
			}

			if ( ! empty( $font['letter-spacing'] ) ) {
				$style .= 'letter-spacing: ' . $font['letter-spacing'] . '; ';
			}

			if ( ! empty( $font['line-height'] ) ) {
				$line_height = Sanitize::css_dimension( $font['line-height'] );
				if ( is_numeric( $line_height ) ) {
					if ( $font['line-height-unit'] && '' !== $font['line-height-unit'] && 'none' !== $font['line-height-unit'] ) {
						$style .= 'line-height: ' . $line_height . $font['line-height-unit'] . '; ';
					} else {
						$style .= 'line-height: ' . $line_height . '; ';
					}
				} else {
					$style .= 'line-height: ' . $font['line-height'] . '; ';
				}
			}

			if ( ! empty( $font['color'] ) ) {
				$style .= 'color : ' . $font['color'] . '; ';
			}

			if ( ! empty( $font['text-transform'] ) ) {
				$style .= 'text-transform : ' . $font['text-transform'] . '; ';
			}

			return $style;

		}

		return null;
	}

	/**
	 * Parse style
	 *
	 * @param string $setting Setting ID.
	 * @param array  $option Option parsed.
	 *
	 * @return null|string
	 */
	public function style_parse( $setting, $option ) {
		if ( false !== Setting::get( $setting ) && '' !== Setting::get( $setting ) && null !== Setting::get( $setting ) ) {
			if ( ! isset( $option['property'] ) || empty( $option['property'] ) ) {
				$option['property'] = '';
			}

			if ( ! isset( $option['prefix'] ) || empty( $option['prefix'] ) ) {
				$option['prefix'] = '';
			}

			if ( ! isset( $option['units'] ) || empty( $option['units'] ) ) {
				$option['units'] = '';
			}

			if ( ! isset( $option['suffix'] ) || empty( $option['suffix'] ) ) {
				$option['suffix'] = '';
			}

			$style = $option['property'] . ' : ' . $option['prefix'] . Setting::get( $setting ) . $option['units'] . $option['suffix'] . ';';

			return $style;
		}

		return null;
	}

	/**
	 * Get font URL
	 *
	 * @return bool|string
	 */
	public function get_font_url() {
		$fonts = $this->get_google_font_setting();

		if ( $fonts || is_array( $fonts ) ) {
			return $this->generate_font_url( $fonts );
		}

		return false;
	}
}
