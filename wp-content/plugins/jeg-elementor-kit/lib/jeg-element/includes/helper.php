<?php
/**
 * Jeg News Element Helper
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

/**
 * Filter prepare field for custom term
 */
if ( ! function_exists( 'jeg_prepare_field_custom_term' ) ) {

	add_filter( 'jeg_prepare_field', 'jeg_prepare_field_custom_term', 10, 2 );

	function jeg_prepare_field_custom_term( $setting, $field ) {
		if ( isset( $field['options'] ) && 'jeg_get_custom_term_option' === $field['options'] ) {
			$setting['options'] = call_user_func_array( $field['options'], array( $setting['value'], $field['slug'] ) );
		}

		return $setting;
	}
}

/**
 * Filter accepted query for custom term
 */
if ( ! function_exists( 'jeg_accept_query_attr_custom_term' ) ) {

	add_filter( 'jeg_accept_query_attribute', 'jeg_accept_query_attr_custom_term', 10, 2 );

	function jeg_accept_query_attr_custom_term( $accepted, $attr ) {
		$taxonomies = get_object_taxonomies( $attr['post_type'] );

		if ( $taxonomies ) {
			$accepted = array_merge( $taxonomies, $accepted );
		}

		return $accepted;
	}
}

/**
 * Filter default query for custom term
 */
if ( ! function_exists( 'jeg_default_query_custom_term' ) ) {

	add_filter( 'jeg_default_query_args', 'jeg_default_query_custom_term', 10, 2 );

	function jeg_default_query_custom_term( $args, $attr ) {

		$taxonomies = jeg_get_enabled_custom_taxonomy();
		$taxonomies = array_keys( $taxonomies );

		foreach ( $taxonomies as $taxonomy ) {

			if ( ! empty( $attr[ $taxonomy ] ) ) {

				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => explode( ',', $attr[ $taxonomy ] ),
						'operator' => 'IN',
					),
				);
			}
		}

		return $args;
	}
}

/**
 * All Function right here need to be cached.
 * Populate all excluded post type
 *
 * @return array
 */
if ( ! function_exists( 'jeg_exclude_post_type' ) ) {
	function jeg_exclude_post_type() {
		$result     = array();
		$post_types = get_post_types(
			array(
				'public'  => true,
				'show_ui' => true,
			)
		);

		$exclude_post_type = apply_filters(
			'jeg_excluded_post_type',
			array(
				'attachment',
				'custom-post-template',
				'archive-template',
				'elementor_library',
			)
		);

		foreach ( $post_types as $type ) {
			if ( ! in_array( $type, $exclude_post_type, true ) ) {
				$result[ $type ] = get_post_type_object( $type )->label;
			}
		}

		return $result;
	}
}

/**
 * Get all author
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_all_author' ) ) {
	function jeg_get_all_author() {
		$result = array();

		if ( is_admin() ) {
			$count = count_users();
			$limit = jeg_load_resource_limit();

			if ( (int) $count['total_users'] <= $limit ) {
				$users = get_users();

				foreach ( $users as $user ) {
					$result[ $user->display_name ] = $user->ID;
				}
			}
		}

		return $result;
	}
}

/**
 * Limit of resource loaded.
 *
 * @return integer
 */
if ( ! function_exists( 'jeg_load_resource_limit' ) ) {
	function jeg_load_resource_limit() {
		return apply_filters( 'jeg_load_resource_limit', 25 );
	}
}

/**
 * Get Option Value
 *
 * @param string $setting Value of option.
 * @param mixed $default Default value for option.
 *
 * @return mixed
 */
if ( ! function_exists( 'jeg_get_option' ) ) {
	function jeg_get_option( $setting, $default = null ) {
		$options = get_option( 'jeg', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return apply_filters( "jeg_get_option_{$setting}", $value );
	}
}

/**
 * Get all enabled post type
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_enable_post_type' ) ) {
	function jeg_get_enable_post_type() {
		$post_types = jeg_exclude_post_type();

		if ( ! empty( $post_types ) && is_array( $post_types ) ) {
			foreach ( $post_types as $key => $label ) {
				if ( ! in_array( $key, array( 'post', 'page' ), true ) ) {
					if ( ! jeg_get_option( 'enable_cpt_' . $key, true ) ) {
						unset( $post_types[ $key ] );
					}
				}
			}
		}

		return $post_types;
	}
}

/**
 * Get enabled custom taxonomy
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_enabled_custom_taxonomy' ) ) {
	function jeg_get_enabled_custom_taxonomy() {
		$result     = array();
		$post_types = jeg_get_enable_post_type();

		unset( $post_types['post'] );
		unset( $post_types['page'] );

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type => $label ) {
				$taxonomies = get_object_taxonomies( $post_type );
				if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
					foreach ( $taxonomies as $taxonomy ) {
						$taxonomy_data = get_taxonomy( $taxonomy );
						if ( $taxonomy_data->show_in_menu ) {
							$result[ $taxonomy ] = array(
								'name'       => $taxonomy_data->labels->name,
								'post_types' => $taxonomy_data->object_type,
							);
						}
					}
				}
			}
		}

		return $result;
	}
}

/**
 * Get post title by ID
 *
 * @param string $value ID separated with comma.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_post_option' ) ) {
	function jeg_get_post_option( $value = null ) {
		$result = array();

		if ( ! empty( $value ) ) {
			$values = explode( ',', $value );

			foreach ( $values as $val ) {
				$result[] = array(
					'value' => $val,
					'text'  => get_the_title( $val ),
				);
			}
		}

		return $result;
	}
}

/**
 * Get category by ID
 *
 * @param string $value ID separated with comma.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_category_option' ) ) {
	function jeg_get_category_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'category' );

		if ( (int) $count <= jeg_load_resource_limit() ) {
			$terms = get_categories( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name,
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_categories(
					array(
						'hide_empty'   => false,
						'hierarchical' => true,
						'include'      => $selected,
					)
				);

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}
		}

		return $result;
	}
}

/**
 * Get author option
 *
 * @param string $value ID separated with comma.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_author_option' ) ) {
	function jeg_get_author_option( $value = '' ) {
		$result  = array();
		$options = array_flip( jeg_get_all_author() );

		if ( empty( $options ) ) {
			$values = explode( ',', $value );
			foreach ( $values as $val ) {
				if ( ! empty( $val ) ) {
					$user     = get_userdata( $val );
					$result[] = array(
						'value' => $val,
						'text'  => $user->display_name,
					);
				}
			}
		} else {
			foreach ( $options as $key => $label ) {
				$result[] = array(
					'value' => $key,
					'text'  => $label,
				);
			}
		}

		return $result;
	}
}

/**
 * Get tag option
 *
 * @param string $value ID separated with comma.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_get_tag_option' ) ) {
	function jeg_get_tag_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'post_tag' );

		if ( (int) $count <= jeg_load_resource_limit() ) {
			$terms = get_tags( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name,
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_tags(
					array(
						'hide_empty'   => false,
						'hierarchical' => true,
						'include'      => $selected,
					)
				);

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'jeg_get_custom_term_option' ) ) {

	/**
	 * Get custom term option
	 *
	 * @param null $value
	 * @param null $slug
	 *
	 * @return array
	 */
	function jeg_get_custom_term_option( $value = null, $slug = null ) {
		if ( $slug ) {
			$result = array();
			$count  = wp_count_terms( $slug );

			if ( (int) $count <= jeg_load_resource_limit() ) {
				$terms = get_terms(
					array(
						'taxonomy'   => $slug,
						'hide_empty' => 0,
					)
				);
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			} else {
				$selected = $value;

				if ( ! empty( $selected ) ) {
					$terms = get_terms(
						array(
							'taxonomy'     => $slug,
							'hide_empty'   => false,
							'hierarchical' => true,
							'include'      => $selected,
						)
					);

					foreach ( $terms as $term ) {
						$result[] = array(
							'value' => $term->term_id,
							'text'  => $term->name,
						);
					}
				}
			}

			return $result;
		}
	}
}

/**
 * Get menu default value
 *
 * @param string $id Key of field option.
 * @param array $value Array of value.
 * @param mixed $default Default value for this item.
 *
 * @return mixed
 */
if ( ! function_exists( 'jeg_field_get_value' ) ) {
	function jeg_field_get_value( $id, $value, $default ) {
		if ( isset( $value[ $id ] ) ) {
			return $value[ $id ];
		} else {
			return $default;
		}
	}
}


/**
 * Get field option
 *
 * @param array $field Array of Fields.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_field_select_option' ) ) {
	function jeg_field_select_option( $field ) {
		$option = array();

		if ( isset( $field['options'] ) ) {
			if ( is_callable( $field['options'] ) ) {
				return call_user_func( $field['options'] );
			} elseif ( is_array( $field['options'] ) ) {
				return $field['options'];
			}
		}

		return $option;
	}
}

/**
 * Prepare Field for Jeg Field
 *
 * @param string $key key of this field.
 * @param array $field Field content.
 * @param array $instance Value of instance.
 * @param array $additional Additonal Parameter.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_prepare_field' ) ) {
	function jeg_prepare_field( $key, $field, $instance = null, $additional = array() ) {
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value   = jeg_field_get_value( $key, $instance, $default );

		$setting                = array();
		$setting['id']          = $key;
		$setting['fieldName']   = isset( $additional['fieldName'] ) ? $additional['fieldName'] : $key;
		$setting['fieldID']     = isset( $additional['fieldID'] ) ? $additional['fieldID'] : $key;
		$setting['options']     = jeg_field_select_option( $field );
		$setting['value']       = $value;
		$setting['type']        = $field['type'];
		$setting['title']       = isset( $field['title'] ) ? $field['title'] : '';
		$setting['description'] = isset( $field['description'] ) ? $field['description'] : '';
		$setting['segment']     = isset( $field['segment'] ) ? $field['segment'] : '';
		$setting['default']     = isset( $field['default'] ) ? $field['default'] : '';
		$setting['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
		$setting['multiple']    = isset( $field['multiple'] ) ? $field['multiple'] : 1;
		$setting['ajax']        = isset( $field['ajax'] ) ? $field['ajax'] : '';
		$setting['ajaxoptions'] = isset( $field['ajaxoptions'] ) ? $field['ajaxoptions'] : '';
		$setting['slug']        = isset( $field['slug'] ) ? $field['slug'] : '';
		$setting['nonce']       = isset( $field['nonce'] ) ? $field['nonce'] : '';
		$setting['fields']      = isset( $field['fields'] ) ? $field['fields'] : array();
		$setting['row_label']   = isset( $field['row_label'] ) ? $field['row_label'] : array();
		$setting['dependency']  = isset( $field['dependency'] ) ? $field['dependency'] : array();

		// only for image type.
		if ( 'image' === $setting['type'] ) {
			$image = wp_get_attachment_image_src( $setting['value'], 'full' );
			if ( isset( $image[0] ) ) {
				$setting['imageUrl'] = $image[0];
			}
		}

		return apply_filters( 'jeg_prepare_field', $setting, $field );
	}
}

/**
 * Prepare Segment
 *
 * @param string $key key of this field.
 * @param array $segment Single Segment content.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_prepare_segment' ) ) {
	function jeg_prepare_segment( $key, $segment ) {
		return array(
			'id'       => $key,
			'type'     => 'widget',
			'name'     => $segment['name'],
			'priority' => $segment['priority'],
		);
	}
}

/**
 * Convert vc type
 *
 * @param string $type Type of field.
 *
 * @return string
 */
if ( ! function_exists( 'jeg_vc_convert_type' ) ) {
	function jeg_vc_convert_type( $type, $multiple = 1 ) {
		if ( 'text' === $type ) {
			return 'textfield';
		}

		if ( 'color' === $type ) {
			return 'colorpicker';
		}

		if ( 'textarea' === $type ) {
			return 'textarea_html';
		}

		if ( 'image' === $type ) {
			if ( $multiple === 1 ) {
				return 'attach_image';
			} else {
				return 'attach_images';
			}
		}

		if ( 'repeater' === $type ) {
			return 'param_group';
		}

		return $type;
	}
}

/**
 * Helper to turn Jeg Option to VC Element
 *
 * @param array $options Collection of Options.
 * @param array $segments Collection of Segment.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_options_to_vc' ) ) {

	function jeg_options_to_vc( $options, $segments ) {
		$settings = array();

		foreach ( $options as $key => $field ) {
			$setting = array();

			$setting['param_name']  = $key;
			$setting['heading']     = isset( $field['title'] ) ? $field['title'] : '';
			$setting['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$setting['std']         = isset( $field['default'] ) ? $field['default'] : '';
			$setting['row_label']   = isset( $field['row_label'] ) ? $field['row_label'] : array();
			$setting['fields']      = isset( $field['fields'] ) ? $field['fields'] : array();
			$setting['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
			$setting['group']       = isset( $segments[ $field['segment'] ]['name'] ) ? $segments[ $field['segment'] ]['name'] : '';
			$setting['multiple']    = isset( $field['multiple'] ) ? $field['multiple'] : 1;
			$setting['ajax']        = isset( $field['ajax'] ) ? $field['ajax'] : '';
			$setting['slug']        = isset( $field['slug'] ) ? $field['slug'] : '';
			$setting['nonce']       = isset( $field['nonce'] ) ? $field['nonce'] : '';
			$setting['type']        = jeg_vc_convert_type( $field['type'], $setting['multiple'] );

			if ( 'select' === $setting['type'] ) {
				if ( isset( $field['options'] ) ) {
					if ( is_array( $field['options'] ) ) {
						$setting['type']  = 'dropdown';
						$setting['value'] = array_flip( $field['options'] );
					} elseif ( isset( $field['multiple'] ) && $field['multiple'] > 1 ) {
						$setting['options'] = $field['options'];
					} else {
						$setting['value'] = array_flip( call_user_func( $field['options'] ) );
					}
				}
			}

			if ( 'radioimage' === $setting['type'] ) {
				if ( isset( $field['options'] ) ) {
					$setting['value'] = array_flip( $field['options'] );
				}
			}

			if ( 'slider' === $setting['type'] || 'number' === $setting['type'] ) {
				$setting['min']  = $field['options']['min'];
				$setting['max']  = $field['options']['max'];
				$setting['step'] = $field['options']['step'];
			}

			if ( isset( $field['dependency'] ) ) {
				$value = $field['dependency'][0]['value'];
				if ( is_bool( $value ) ) {
					$value = $value ? 'true' : 'false';
				}

				$setting['dependency'] = array(
					'element' => $field['dependency'][0]['field'],
					'value'   => $value,
				);
			}

			if ( 'checkbox' === $setting['type'] ) {
				if ( $setting['std'] ) {
					$setting['std'] = 'true';
				}
			}

			if ( 'param_group' === $setting['type'] ) {
				$setting['params'] = jeg_options_to_vc( $setting['fields'], $segments );
				$setting['std']    = rawurlencode( wp_json_encode( $setting['std'] ) );
			}

			$settings[] = $setting;
		}

		return $settings;
	}
}

/**
 * Turn Category string into slug.
 *
 * @param string $category Category ID.
 *
 * @return mixed
 */
if ( ! function_exists( 'jeg_slug_category' ) ) {
	function jeg_slug_category( $category ) {
		return sanitize_title( $category );
	}
}


/**
 * Get post class
 *
 * @param string $class User defined class.
 * @param null $post_id Post ID.
 *
 * @return string
 */
if ( ! function_exists( 'jeg_post_class' ) ) {
	function jeg_post_class( $class = '', $post_id = null ) {
		// Separates classes with a single space, collates classes for post DIV.
		return 'class="' . join( ' ', jeg_get_post_class( $class, $post_id ) ) . '"';
	}
}

/**
 * Custom implementation of get_post_class for Jeg Element
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 *
 * @return array Array of classes.
 */
if ( ! function_exists( 'jeg_get_post_class' ) ) {
	function jeg_get_post_class( $class = '', $post_id = null ) {
		$post = get_post( $post_id );

		$classes = array();

		if ( $class ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_map( 'esc_attr', $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		if ( ! $post ) {
			return $classes;
		}

		$classes[] = 'post-' . $post->ID;
		if ( ! is_admin() ) {
			$classes[] = $post->post_type;
		}
		$classes[] = 'type-' . $post->post_type;
		$classes[] = 'status-' . $post->post_status;

		// Post Format.
		if ( post_type_supports( $post->post_type, 'post-formats' ) ) {
			$post_format = get_post_format( $post->ID );

			if ( $post_format && ! is_wp_error( $post_format ) ) {
				$classes[] = 'format-' . sanitize_html_class( $post_format );
			} else {
				$classes[] = 'format-standard';
			}
		}

		$post_password_required = post_password_required( $post->ID );

		// Post requires password.
		if ( $post_password_required ) {
			$classes[] = 'post-password-required';
		} elseif ( ! empty( $post->post_password ) ) {
			$classes[] = 'post-password-protected';
		}

		// Post thumbnails.
		if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) && ! is_attachment( $post ) && ! $post_password_required ) {
			$classes[] = 'has-post-thumbnail';
		}

		// sticky for Sticky Posts.
		if ( is_sticky( $post->ID ) ) {
			if ( is_home() && ! is_paged() ) {
				$classes[] = 'sticky';
			} elseif ( is_admin() ) {
				$classes[] = 'status-sticky';
			}
		}

		// hentry for hAtom compliance.
		$classes[] = 'hentry';

		// All public taxonomies.
		$taxonomies = get_taxonomies( array( 'public' => true ) );
		foreach ( (array) $taxonomies as $taxonomy ) {
			if ( is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
				foreach ( (array) get_the_terms( $post->ID, $taxonomy ) as $term ) {
					if ( empty( $term->slug ) ) {
						continue;
					}

					$term_class = sanitize_html_class( $term->slug, $term->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $term->term_id;
					}

					// 'post_tag' uses the 'tag' prefix for backward compatibility.
					if ( 'post_tag' === $taxonomy ) {
						$classes[] = 'tag-' . $term_class;
					} else {
						$classes[] = sanitize_html_class( $taxonomy . '-' . $term_class, $taxonomy . '-' . $term->term_id );
					}
				}
			}
		}

		$classes = array_map( 'esc_attr', $classes );

		return array_unique( $classes );
	}
}

/**
 * Sort Segment
 *
 * @param array $segments Array of segment.
 *
 * @return array
 */
if ( ! function_exists( 'jeg_sort_segment' ) ) {
	function jeg_sort_segment( $segments ) {
		$groups = array();

		foreach ( $segments as $id => $segment ) {
			$segment['id'] = $id;
			$groups[]      = $segment;
		}

		usort(
			$groups,
			function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			}
		);

		return $groups;
	}
}


if ( ! function_exists( 'jlog' ) ) {

	/**
	 * Jlog
	 *
	 * @param mixed $obj Object Jlog.
	 */
	function jlog( $obj ) {
		echo '<pre>';
		print_r( $obj );
		echo '</pre>';
	}
}

if ( ! function_exists( 'jeg_sanitize' ) ) {

	/**
	 * Sanitize input
	 *
	 * @param  mixed $value
	 *
	 * @return mixed
	 */
	function jeg_sanitize( $value ) {
		return wp_kses( $value, wp_kses_allowed_html( 'post' ) );
	}
}

if ( ! function_exists( 'jeg_get_primary_category' ) ) {

	/**
	 * Return primary category
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return mixed
	 */
	function jeg_get_primary_category( $post_id ) {
		$category_id = null;

		if ( get_post_type( $post_id ) === 'post' ) {
			$categories = array_slice( get_the_category( $post_id ), 0, 1 );
			if ( empty( $categories ) ) {
				return null;
			}
			$category    = array_shift( $categories );
			$category_id = $category->term_id;
		}

		return apply_filters( 'jeg_primary_category', $category_id, $post_id );
	}
}

if ( ! function_exists( 'jeg_is_frontend_vc' ) ) {
	/**
	 * Check if Build using frontend vc
	 *
	 * @return bool
	 */
	function jeg_is_frontend_vc() {
		return function_exists( 'vc_is_page_editable' ) && vc_is_page_editable();
	}
}

if ( ! function_exists( 'jeg_is_frontend_elementor' ) ) {
	/**
	 * Check if frontend elementor enabled
	 *
	 * @return bool
	 */
	function jeg_is_frontend_elementor() {
		if ( defined( 'ELEMENTOR_VERSION' ) && isset( $_REQUEST['elementor-preview'] ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'jeg_is_editor_elementor' ) ) {
	/**
	 * Check if on the elementor editor
	 *
	 * @return bool
	 */
	function jeg_is_editor_elementor() {
		if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return true;
		}

		return false;
	}
}
