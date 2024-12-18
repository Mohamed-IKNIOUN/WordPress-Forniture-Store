<?php
/**
 * Jeg News Element Image Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Image;

/**
 * Class Image
 */
class Image {
	/**
	 * Image size prefix
	 *
	 * @var string
	 */
	public static $prefix = 'jeg-';

	/**
	 * Image constructor.
	 */
	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'image_hook' ) );
		add_action( 'after_setup_theme', array( $this, 'generator_mode' ), 99 );
	}

	/**
	 * Generate Image Method
	 */
	public function generator_mode() {
		$generate_image = jeg_get_option( 'image_generator', 'normal' );

		if ( 'dynamic' === $generate_image ) {
			add_filter( 'image_downsize', array( $this, 'image_down_size' ), 99, 3 );
		} else {
			add_action( 'init', array( $this, 'add_image_size' ) );
		}
	}

	/**
	 * Image hook
	 */
	public function image_hook() {
		$mechanism = jeg_get_option( 'image_load', 'lazyload' );

		if ( 'lazyload' === $mechanism ) {
			$image = new Image_Lazy_Load();
		} elseif ( 'background' === $mechanism ) {
			$image = new Image_Background_Load();
		} else {
			$image = new Image_Normal_Load();
		}

		add_filter( 'jeg_image_lazy_owl', array( $image, 'owl_lazy_image' ), null, 2 );
		add_filter( 'jeg_single_image_lazy_owl', array( $image, 'owl_lazy_single_image' ), null, 2 );
		add_filter( 'jeg_image_thumbnail', array( $image, 'image_thumbnail' ), null, 2 );
		add_filter( 'jeg_image_thumbnail_unwrap', array( $image, 'image_thumbnail_unwrap' ), null, 2 );
		add_filter( 'jeg_single_image_unwrap', array( $image, 'single_image_unwrap' ), null, 2 );
		add_filter( 'jeg_single_image_owl', array( $image, 'owl_single_image' ), null, 2 );

		add_filter( 'jeg_single_image', array( $image, 'single_image' ), null, 3 );
		add_filter( 'image_size_names_choose', array( $this, 'custom_size' ) );
		add_filter( 'jeg_has_image_size', array( $this, 'has_image_size' ), null, 2 );
	}

	/**
	 * Has Image Size
	 */
	public function has_image_size( $flag, $size ) {
		$image_sizes = $this->get_image_sizes();

		return isset( $image_sizes[ $size ] );
	}

	/**
	 * Image custom size
	 *
	 * @param array $sizes Image Size.
	 *
	 * @return mixed
	 */
	public function custom_size( $sizes ) {
		$image_sizes = $this->get_image_sizes();
		foreach ( $image_sizes as $key => $size ) {
			$sizes[ $key ] = esc_html__( 'Custom Size', 'jeg-elementor-kit' );
		}

		return $sizes;
	}

	/**
	 * Get image size
	 *
	 * @param string $size Get all image size.
	 *
	 * @return mixed
	 */
	public static function get_image_sizes( $size = null ) {
		$sizes      = apply_filters( 'jeg_add_image_size', array() );
		$image_size = array();

		foreach ( $sizes as $index => $value ) {
			$image_size[ self::$prefix . $index ] = array(
				'width'     => $value[0],
				'height'    => $value[1],
				'crop'      => $value[2],
				'dimension' => $value[3],
			);
		}

		if ( null === $size ) {
			return $image_size;
		} else {
			return $image_size [ $size ];
		}
	}

	/**
	 * Actual function for adding image size
	 */
	public function add_image_size() {
		$image_sizes = $this->get_image_sizes();
		foreach ( $image_sizes as $id => $image ) {
			add_image_size( $id, $image['width'], $image['height'], $image['crop'] );
		}
	}

	/**
	 * Generate tag for retina image
	 *
	 * @param string  $image URL of normal image.
	 * @param string  $imageretina URL of retina image.
	 * @param string  $alt Alternate text.
	 * @param boolean $echo Print output.
	 *
	 * @return string
	 */
	public static function generate_image_retina( $image, $imageretina, $alt, $echo ) {
		$srcset = '';

		if ( ! empty( $imageretina ) ) {
			$srcset = 'srcset="' . esc_url( $image ) . ' 1x, ' . esc_url( $imageretina ) . ' 2x"';
		}

		$header_logo = '<img src="' . esc_url( $image ) . '" ' . $srcset . ' alt="' . esc_attr( $alt ) . '">';

		if ( $echo ) {
			echo wp_kses( $header_logo, self::filter_image() );
		}

		return $header_logo;
	}

	/**
	 * Protocol allowed for image
	 *
	 * @return array
	 */
	public static function filter_image() {
		return array(
			'img' => array(
				'src'    => true,
				'srcset' => true,
				'alt'    => true,
			),
		);
	}

	/**
	 * The image downside filter
	 *
	 * @param bool         $ignore Whether to short-circuit the image downsize. Default false.
	 * @param int          $id Attachment ID for image.
	 * @param array|string $size Size of image. Image size or array of width and height values (in that order). Default 'medium'.
	 *
	 * @return mixed
	 */
	public function image_down_size( $ignore = false, $id = null, $size = 'medium' ) {
		global $_wp_additional_image_sizes;

		$image   = wp_get_attachment_url( $id );
		$meta    = wp_get_attachment_metadata( $id );
		$width   = 0;
		$height  = 0;
		$crop    = false;
		$dynamic = false;

		// return immediately if the size is "thumbnail".
		if ( 'thumbnail' === $size ) {
			return false;
		}

		// return immediately if intermediate image size found.
		if ( image_get_intermediate_size( $id, $size ) || is_array( $size ) ) {
			return false;
		}

		// check if the image size is defined by 'add_image_size()' but not created yet.
		if ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
			$width  = $_wp_additional_image_sizes[ $size ]['width'];
			$height = $_wp_additional_image_sizes[ $size ]['height'];
			$crop   = $_wp_additional_image_sizes[ $size ]['crop'];
		} elseif ( $size_arr = $this->parse_size( $size ) ) {
			$width   = isset( $size_arr['width'] ) ? $size_arr['width'] : 0;
			$height  = isset( $size_arr['height'] ) ? $size_arr['height'] : 999999;
			$crop    = isset( $size_arr['height'] ) ? true : false;
			$dynamic = true;
		}

		// let's continue if original image found, also if width & height are specified.
		if ( $image && $width && $height ) {
			if ( ! $img = $this->make_image( $id, $width, $height, $crop ) ) {
				return false;
			}

			if ( $dynamic ) {
				$img['jeg_dynamic_images'] = true;
			}

			unset( $img['path'] );

			$meta['sizes'][ $size ] = $img;

			// update attachment metadata.
			wp_update_attachment_metadata( $id, $meta );

			// replace original image url with newly created one.
			$image = str_replace( wp_basename( $image ), wp_basename( $img['file'] ), $image );

			// we might need to further constrain it if content_width is narrower.
			list( $width, $height ) = image_constrain_size_for_editor( $width, $height, $size );

			// finally return the result.
			return array( $image, $width, $height, false );
		}

		return false;
	}


	/**
	 * Parse image size.
	 *
	 * @param string $string Parse image size.
	 *
	 * @return array
	 */
	public function parse_size( $string ) {
		$size = array();

		if ( ! is_array( $string ) && substr( $string, 0, strlen( self::$prefix ) ) === self::$prefix ) {
			$string = substr( $string, strlen( self::$prefix ) );
			$array  = explode( 'x', $string );

			foreach ( $array as $key => $value ) {
				$value = absint( trim( $value ) );

				if ( ! $value ) {
					continue;
				}

				if ( 0 === $key ) {
					$size['width'] = $value;
				}

				if ( 1 === $key ) {
					$size['height'] = $value;
				}
			}
		} else {
			return $string;
		}

		return $size;
	}


	/**
	 * Create a new image by cropping the original image based on given size.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param integer $id Image ID.
	 * @param integer $width Width of Image.
	 * @param integer $height Height of Image.
	 * @param boolean $crop Flag for cropping image.
	 *
	 * @return NULL|array
	 */
	public function make_image( $id, $width, $height = 999999, $crop = false ) {
		$image  = get_attached_file( $id );
		$editor = wp_get_image_editor( $image );

		if ( ! is_wp_error( $editor ) ) {
			$editor->resize( $width, $height, $crop );
			$editor->set_quality( 100 );

			$filename = $editor->generate_filename();

			return $editor->save( $filename );
		}

		return null;
	}

}
