<?php
/**
 * Collection of helper for Jeg Framework
 *
 * @author Jegtheme
 * @since 1.1.0
 * @package jeg-framework
 */

/**
 * Get version of Jeg Framework. Can be overridden by plugin or theme.
 *
 * @return string
 */
if ( ! function_exists( 'jeg_get_version' ) ) {
	function jeg_get_version() {
		return apply_filters( 'jeg_framework_version', JEG_VERSION );
	}
}

if ( ! function_exists( 'jeg_is_json' ) ) {
	/**
	 * Check if string is json
	 *
	 * @param string $string string to check.
	 *
	 * @return bool
	 */
	function jeg_is_json( $string ) {
		if ( ! is_string( $string ) ) {
			return false;
		}

		json_decode( urldecode( $string ) );

		return ( JSON_ERROR_NONE == json_last_error() );
	}
}

if ( ! function_exists( 'jeg_sanitize_input_field' ) ) {
	/**
	 * Recursively Sanitize Input Field
	 *
	 * @param mixed $values Value to be sanitized.
	 *
	 * @return mixed
	 */
	function jeg_sanitize_input_field( $values ) {

		foreach ( $values as $key => $value ) {
			if ( jeg_is_json( $value ) ) {
				$value = json_decode( urldecode( $value ) );
			}

			if ( is_object( $value ) ) {
				$value = (array) $value;
			}

			if ( is_array( $value ) ) {
				$values[ $key ] = jeg_sanitize_input_field( $value );
			} else {
				$values[ $key ] = sanitize_text_field( $value );
			}
		}

		return $values;
	}
}

/**
 * Get Meta box value
 *
 * @param string $name Metabox Name.
 * @param mixed  $default Default Value for Metabox.
 * @param int    $post_id Post ID.
 *
 * @return mixed
 */
if ( ! function_exists( 'jeg_metabox' ) ) {
	function jeg_metabox( $name, $default = null, $post_id = null ) {
		global $post;

		if ( ! is_null( $post_id ) ) {
			$the_post = get_post( $post_id );
			if ( empty( $the_post ) ) {
				$post_id = null;
			}
		}

		if ( is_null( $post ) && is_null( $post_id ) ) {
			return apply_filters( 'jeg_metabox', $default, $name );
		}

		if ( is_null( $post_id ) ) {
			$post_id = $post->ID;
		}

		$keys = explode( '.', $name );
		$temp = null;

		foreach ( $keys as $index => $key ) {
			if ( 0 === $index ) {
				$meta_values = get_post_meta( $post_id, $key, true );
				if ( ! empty( $meta_values ) ) {
					$temp = $meta_values;
				} else {
					return apply_filters( 'jeg_metabox', $default, $name );
				}
			} else {
				if ( is_array( $temp ) ) {
					if ( isset( $temp[ $key ] ) ) {
						$temp = $temp[ $key ];
					} else {
						$temp = $default;
					}
				}
			}
		}

		return apply_filters( 'jeg_metabox', $temp, $name );
	}
}

if ( ! function_exists( 'jeg_allowed_protocols' ) ) {

	add_filter( 'kses_allowed_protocols', 'jeg_allowed_protocols' );

	/**
	 * Extend Allowed Protocol WP KSES.
	 *
	 * @param array $allowed_protocols Allowed Protocols.
	 *
	 * @return array
	 */
	function jeg_allowed_protocols( $allowed_protocols ) {
		$allowed_protocols = array_merge( $allowed_protocols, array( 'data' ) );

		return $allowed_protocols;
	}
}

if ( ! function_exists( 'jeg_allowed_html' ) ) {

	add_filter( 'wp_kses_allowed_html', 'jeg_allowed_html' );

	/**
	 * Extend Allowed HTML WP KSES.
	 *
	 * @param array $allowedtags Allowed Tag.
	 *
	 * @return array
	 */
	function jeg_allowed_html( $allowedtags ) {
		$allowedtags['br']   = array_merge( isset( $allowedtags['br'] ) ? $allowedtags['br'] : array(), array() );
		$allowedtags['ul']   = array_merge(
			isset( $allowedtags['ul'] ) ? $allowedtags['ul'] : array(),
			array(
				'class' => true,
				'style' => true,
			)
		);
		$allowedtags['ol']   = array_merge( isset( $allowedtags['ol'] ) ? $allowedtags['ol'] : array(), array() );
		$allowedtags['li']   = array_merge( isset( $allowedtags['li'] ) ? $allowedtags['li'] : array(), array() );
		$allowedtags['a']    = array_merge(
			isset( $allowedtags['a'] ) ? $allowedtags['a'] : array(),
			array(
				'href'   => true,
				'title'  => true,
				'target' => true,
				'class'  => true,
				'style'  => true,
			)
		);
		$allowedtags['span'] = array_merge(
			isset( $allowedtags['span'] ) ? $allowedtags['span'] : array(),
			array(
				'class'       => true,
				'style'       => true,
				'data-*'      => true,
				'aria-hidden' => true,
			)
		);
		$allowedtags['i']    = array_merge(
			isset( $allowedtags['i'] ) ? $allowedtags['i'] : array(),
			array(
				'class' => true,
			)
		);
		$allowedtags['div']  = array_merge(
			isset( $allowedtags['div'] ) ? $allowedtags['div'] : array(),
			array(
				'id'         => true,
				'class'      => true,
				'data-id'    => true,
				'data-video' => true,
				'style'      => true,
			)
		);
		$allowedtags['img']  = array_merge(
			isset( $allowedtags['img'] ) ? $allowedtags['img'] : array(),
			array(
				'class'  => true,
				'src'    => true,
				'alt'    => true,
				'srcset' => true,
				'width'  => true,
				'height' => true,
			)
		);

		return $allowedtags;
	}
}

if ( ! function_exists( 'jeg_check_video_source' ) ) {
	/**
	 * Check video source
	 */
	function jeg_check_video_source( $url ) {
		$source = '';

		// check if the value contain html tag
		if ( $url != strip_tags( $url ) ) {
			return $source;
		}

		if ( strpos( $url, 'youtube' ) > 0 || strpos( $url, 'youtu.be' ) > 0 ) {
			$source = 'youtube';
		} elseif ( strpos( $url, 'vimeo' ) > 0 ) {
			$source = 'vimeo';
		} else {
			$format = strtolower( pathinfo( $url, PATHINFO_EXTENSION ) );

			if ( 'mp4' === $format ) {
				$source = 'mp4';
			}
		}

		return $source;
	}
}

if ( ! function_exists( 'jeg_get_option' ) ) {
	/**
	 * Get Jeg option
	 */
	function jeg_get_option( $setting, $default = null ) {
		$options = get_option( 'jeg', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return $value;
	}
}

if ( ! function_exists( 'jeg_sanitize_array' ) ) {
	/**
	 * Sanitizing Array recursively
	 *
	 * @param array $data The data to be sanitized.
	 *
	 * @return array sanitized array
	 */
	function jeg_sanitize_array( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$data[ $key ] = jeg_sanitize_array( $value );
			}
			return $data;
		}
		return sanitize_text_field( $data );
	}
}

