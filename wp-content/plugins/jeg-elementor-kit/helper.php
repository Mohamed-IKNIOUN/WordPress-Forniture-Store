<?php
/**
 * Jeg Elementor Kit Helper
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

if ( ! function_exists( 'jkit_get_menu_option' ) ) {
	/**
	 * Get menu list using cache
	 *
	 * @return array
	 */
	function jkit_get_menu_option() {
		$menus = wp_cache_get( 'menu', 'jeg-elementor-kit' );

		if ( ! $menus ) {
			$menus = wp_get_nav_menus();
			wp_cache_set( 'menu', $menus, 'jeg-elementor-kit' );
		}

		$menus = array_combine( wp_list_pluck( $menus, 'slug' ), wp_list_pluck( $menus, 'name' ) );

		return $menus;
	}
}


if ( ! function_exists( 'jkit_edit_post' ) ) {
	/**
	 * Get post edit link
	 *
	 * @param  int    $post_id  Post ID.
	 * @param  string $position Link position.
	 * @return bool|string
	 */
	function jkit_edit_post( $post_id, $position = 'left' ) {
		if ( current_user_can( 'edit_posts' ) ) {
			$url = get_edit_post_link( $post_id );

			return '<a class="jkit-edit-post ' . $position . '" href="' . $url . '" target="_blank">
				<i class="fas fa-pencil-alt"></i>
				<span>' . esc_html__( 'edit post', 'jeg-elementor-kit' ) . '</span>
			</a>';
		}

		return false;
	}
}

if ( ! function_exists( 'jkit_get_post_date' ) ) {
	/**
	 * Get post date
	 *
	 * @param  string       $format Get post format.
	 * @param  int|\WP_Post $post   Optional. Post ID or post object.
	 * @param  string       $type Date type.
	 * @return false|string
	 */
	function jkit_get_post_date( $format = '', $post = null, $type = '' ) {
		if ( 'published' === $type ) {
			return get_the_date( $format, $post );
		}

		return get_the_modified_date( $format, $post );
	}
}

if ( ! function_exists( 'jkit_get_post_ago_time' ) ) {
	/**
	 * Get time in ago format
	 *
	 * @param string       $type Date type.
	 * @param int|\WP_Post $post Optional. Post ID or post object.
	 * @return string
	 */
	function jkit_get_post_ago_time( $type, $post ) {
		if ( 'published' === $type ) {
			$output = jkit_ago_time( human_time_diff( get_the_time( 'U', $post ), time() ) );
		} else {
			$output = jkit_ago_time( human_time_diff( get_the_modified_time( 'U', $post ), time() ) );
		}

		return $output;
	}
}

if ( ! function_exists( 'jkit_ago_time' ) ) {
	/**
	 * Format Time ago string.
	 *
	 * @param  string $time time ago from now.
	 * @return string
	 */
	function jkit_ago_time( $time ) {
		return esc_html(
			sprintf(
				/* translators: 1: Time from now. */
				esc_html__( '%s ago', 'jeg-elementor-kit' ),
				$time
			)
		);
	}
}

if ( ! function_exists( 'jkit_get_comments_number' ) ) {
	/**
	 * Get comment number
	 *
	 * @param  int $post_id Post ID.
	 * @return mixed
	 */
	function jkit_get_comments_number( $post_id = 0 ) {
		$comments_number = get_comments_number( $post_id );

		return apply_filters( 'jkit_get_comments_number', $comments_number, $post_id );
	}
}

if ( ! function_exists( 'jkit_get_respond_link' ) ) {
	/**
	 * Get respond link
	 *
	 * @param  null $post_id Post ID.
	 * @return string
	 */
	function jkit_get_respond_link( $post_id = null ) {
		return esc_url( get_the_permalink( $post_id ) ) . '#respond';
	}
}

/** Start custom template directory */
if ( ! function_exists( 'jkit_get_template_part' ) ) {
	/**
	 * Get custom tempate directory
	 *
	 * @param string      $slug Template slug.
	 * @param string|null $name Template name.
	 * @param bool        $dir Template directory.
	 */
	function jkit_get_template_part( $slug, $name = null, $dir = JEG_ELEMENTOR_KIT_DIR ) {
		do_action( "jkit_get_template_part_{$slug}", $slug, $name, $dir );
		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
		if ( ! $dir ) {
			$dir = get_template_directory();
		}

		jkit_get_template_path( $templates, true, false, $dir );
	}
}

if ( ! function_exists( 'jkit_get_template_path' ) ) {
	/**
	 * Get custom template path
	 *
	 * @param array  $template_names Templates.
	 * @param bool   $load Load template.
	 * @param bool   $require_once Require once.
	 *
	 * @param string $dir Template directory.
	 *
	 * @return mixed
	 */
	function jkit_get_template_path( $template_names, $load = false, $require_once = true, $dir = JEG_ELEMENTOR_KIT_DIR ) {
		$located = '';
		if ( $dir ) {
			foreach ( (array) $template_names as $template_name ) {
				if ( ! $template_name ) {
					continue;
				}
				/* search file within the $dir only */
				if ( file_exists( $dir . $template_name ) ) {
					$located = $dir . $template_name;
					break;
				}
			}
			if ( $load && '' !== $located ) {
				load_template( $located, $require_once );
			}
		}

		return $located;
	}
}
/** End custom template directory */

if ( ! function_exists( 'jkit_get_nonce_identifier' ) ) {
	/**
	 * Get nonce identifier
	 *
	 * @return string
	 */
	function jkit_get_nonce_identifier( $slug = '' ) {
		if ( ! is_null( $slug ) ) {
			$slug = '-' . $slug;
		}

		return 'jkit-nonce' . $slug;
	}
}

if ( ! function_exists( 'jkit_create_global_nonce' ) ) {
	/**
	 * Get nonce identifier
	 *
	 * @return string
	 */
	function jkit_create_global_nonce( $slug = '' ) {
		return wp_create_nonce( jkit_get_nonce_identifier( $slug ) );
	}
}

if ( ! function_exists( 'jkit_load_resource_limit' ) ) {
	/**
	 * Number of limit we can load resouce to prevent system crash
	 *
	 * @return int
	 */
	function jkit_load_resource_limit() {
		return apply_filters( 'jkit_load_resource_limit', 25 );
	}
}

if ( ! function_exists( 'jkit_get_taxonomies' ) ) {
	/**
	 * Retrieves a list of registered taxonomy names or objects.
	 *
	 * @return array
	 */
	function jkit_get_taxonomies( $label = true ) {
		$taxonomies = get_taxonomies(
			array(
				'public'  => true,
				'show_ui' => true,
			)
		);

		if ( $label ) {
			foreach ( $taxonomies as $taxonomy ) {
				$object                  = get_taxonomy( $taxonomy );
				$taxonomies[ $taxonomy ] = $object->labels->name;
			}
		} else {
			$taxonomies = array_keys( $taxonomies );
		}

		return $taxonomies;
	}
}

if ( ! function_exists( 'jkit_get_public_post_type' ) ) {
	/**
	 * Get public post type with label
	 *
	 * @return array
	 */
	function jkit_get_public_post_type() {
		$types = get_post_types(
			array(
				'public'  => true,
				'show_ui' => true,
			)
		);

		$exclude = \Jeg\Elementor_Kit\Dashboard\Dashboard::post_type_list();

		foreach ( $types as $type => $data ) {
			if ( in_array( $type, $exclude ) ) {
				unset( $types[ $type ] );
			} else {
				$object         = get_post_type_object( $type );
				$types[ $type ] = $object->labels->singular_name;
			}
		}

		return $types;
	}
}

if ( ! function_exists( 'jkit_get_public_post_type_array' ) ) {
	/**
	 * Get public post type
	 *
	 * @return array
	 */
	function jkit_get_public_post_type_array() {
		$types = get_post_types(
			array(
				'public'  => true,
				'show_ui' => true,
			)
		);

		/** Remove header builder post type */
		foreach ( \Jeg\Elementor_Kit\Dashboard\Dashboard::post_type_list() as $list => $data ) {
			unset( $types[ $list ] );
		}

		return array_keys( $types );
	}
}

if ( ! function_exists( 'jkit_get_element_data' ) ) {
	/**
	 * JKit Get Element Data
	 *
	 * @param $type
	 * @param $meta
	 *
	 * @return array
	 */
	function jkit_get_element_data( $type, $meta = null ) {
		return array(
			'publish' => jkit_get_element( 'publish', $type, $meta ),
			'draft'   => jkit_get_element( 'draft', $type, $meta ),
		);
	}
}

if ( ! function_exists( 'jkit_get_element' ) ) {
	/**
	 * JKit Get Element
	 *
	 * @param $status
	 * @param $type
	 * @param $meta
	 *
	 * @return array
	 */
	function jkit_get_element( $status, $type, $meta = null ) {
		$args = array(
			'post_type'   => $type,
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
			'post_status' => $status,
		);

		if ( jkit_is_multilanguage() ) {
			$args['lang'] = '';
		}

		if ( $meta ) {
			$args['meta_query'] = array(
				array(
					'key'   => 'jkit-template-type',
					'value' => $meta,
				),
			);
		}

		$query  = get_posts( $args );
		$result = array();

		if ( $query ) {
			foreach ( $query as $post ) {
				$result[] = array(
					'id'    => $post->ID,
					'title' => $post->post_title,
					'url'   => \Jeg\Elementor_Kit\Dashboard\Dashboard::editor_url( $post->ID ),
				);
			}
		}

		wp_reset_postdata();

		return $result;
	}
}
if ( ! function_exists( 'get_jkit_template_classes' ) ) {
	/**
	 * Get JKit additional temlpate classes
	 *
	 * @param $template
	 *
	 * @return string
	 */
	function get_jkit_template_classes( $template = 'header' ) {
		$html_classes = '';
		$classes      = array();

		if ( 'header' === $template ) {
			$classes = apply_filters( 'jkit_header_template_classes', array() );
		} elseif ( '404' === $template ) {
			$classes = apply_filters( 'jkit_404_template_classes', array() );
		} elseif ( 'single' === $template ) {
			$classes = apply_filters( 'jkit_single_template_classes', array() );
		}

		$classes = apply_filters( 'jkit_custom_template_classes', $classes, $template );

		if ( $classes && ! empty( $classes ) ) {
			foreach ( $classes as $class ) {
				$html_classes .= sanitize_html_class( $class ) . ' ';
			}
		}

		return $html_classes;
	}
}

if ( ! function_exists( 'jkit_extract_ids' ) ) {
	/**
	 * Extract ID from Query
	 *
	 * @param $items
	 *
	 * @return array
	 */
	function jkit_extract_ids( $items ) {
		$id = array();
		foreach ( $items as $item ) {
			$id[] = $item['id'];
		}

		return $id;
	}
}

if ( ! function_exists( 'jkit_remove_array' ) ) {
	/**
	 * Remove Array from List
	 *
	 * @param $key
	 * @param $array
	 *
	 * @return mixed
	 */
	function jkit_remove_array( $key, $array ) {
		if ( ( $key = array_search( $key, $array ) ) !== false ) {
			unset( $array[ $key ] );
		}

		return $array;
	}
}

if ( ! function_exists( 'jkit_get_elementor_saved_template_option' ) ) {
	/**
	 * Get elementor saved template option
	 *
	 * @param array $args Query args.
	 *
	 * @return array
	 */
	function jkit_get_elementor_saved_template_option( $args = array() ) {
		$options = array();

		$default_args = array(
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		);

		$args           = array_replace( $default_args, $args );
		$page_templates = get_posts( $args );

		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
			foreach ( $page_templates as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}
}

if ( ! function_exists( 'jkit_get_responsive_breakpoints' ) ) {
	/**
	 * Get Elementor responsive breakpoints
	 *
	 * @return array
	 */
	function jkit_get_responsive_breakpoints() {
		$breakpoints = array();

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.2.0', '>=' ) ) {
			$elementor = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

			foreach ( $elementor as $key => $breakpoint ) {
				array_push(
					$breakpoints,
					array(
						'key'   => $key,
						'value' => $breakpoint->get_value(),
					)
				);
			}
		} else {
			$elementor = \Elementor\Core\Responsive\Responsive::get_editable_breakpoints();

			array_push(
				$breakpoints,
				array(
					'key'   => 'tablet',
					'value' => isset( $elementor['lg'] ) ? strval( $elementor['lg'] - 1 ) : 1024,
				)
			);

			array_push(
				$breakpoints,
				array(
					'key'   => 'mobile',
					'value' => isset( $elementor['md'] ) ? strval( $elementor['md'] - 1 ) : 767,
				)
			);
		}

		usort(
			$breakpoints,
			function ( $a, $b ) {
				return $b['value'] - $a['value'];
			}
		);

		return $breakpoints;
	}
}

if ( ! function_exists( 'jkit_is_preview_mode' ) ) {
	/**
	 * Check if current page is on the Elementor preview mode
	 *
	 * @return boolean
	 */
	function jkit_is_preview_mode() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		return \Elementor\Plugin::instance()->preview->is_preview_mode();
	}
}

if ( ! function_exists( 'jkit_remove_form_control' ) ) {
	/**
	 * Remove Form Control.
	 * Conditions for not using the Form Control from the Jeg Elementor Kit. Usually used when there is a conflict with another version of Bootstrap.
	 *
	 * @return bool
	 */
	function jkit_remove_form_control() {
		$conditions = false;
		$page       = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

		if ( $page ) {
			$lists = array( 'gf_', 'formidable', 'bookly-', 'vik', 'wpdatatables-' );

			foreach ( $lists as $list ) {
				if ( strpos( $page, $list ) !== false ) {
					$conditions = true;
					break;
				}
			}
		}

		return apply_filters( 'jkit_remove_form_control_conditions', $conditions );
	}
}

if ( ! function_exists( 'jkit_render_guteverse_banner' ) ) {
	/**
	 * Render Gutenverse Banner
	 */
	function jkit_render_guteverse_banner() {
		$fetch = wp_remote_post( 'https://gutenverse.com/wp-json/gutenverse-banner/v1/bannerdata' );
		if ( $fetch ) {
			$data = wp_remote_retrieve_body( $fetch );
			$data = json_decode( $data );
		}

		$banner_assets = JEG_ELEMENTOR_KIT_URL . '/assets/banner/gutenverse/';

		wp_enqueue_style( 'gutenverse-banner', $banner_assets . 'style.css', array(), JEG_ELEMENTOR_KIT_VERSION );
		?>
		<div class="gutenverse-banner <?php echo ( isset( $data->url ) && isset( $data->banner ) ) ? 'fetch' : ''; ?>">
			<?php if ( isset( $data->url ) && isset( $data->banner ) ) : ?>	
				<a href="<?php echo esc_url( $data->url ); ?>" target="_blank">
					<img src="<?php echo esc_url( $data->banner ); ?>" width="300px" height="300px" loading="lazy" alt="Logo"/>
				</a>
			<?php else : ?>
			<div class="banner-content">
				<div class="logo-wrapper"><img class="logo" src="<?php echo esc_url( $banner_assets ); ?>gutenverse-logo.svg" loading="lazy" alt="Logo" /></div>
				<div class="main-content">
					Advanced Addons for Gutenberg Or Fullsite Editing (FSE)
				</div>
				<div class="buttons">
					<div class="plugin-link">
						<a href="<?php echo esc_url( network_admin_url( 'plugin-install.php?s=gutenverse&tab=search&type=term' ) ); ?>" target="_blank" rel="noreferrer">
							Try Gutenverse
						</a>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'jkit_allowed_style_attr' ) ) {

	add_filter( 'safe_style_css', 'jkit_allowed_style_attr' );

	/**
	 * Allowed style attribute
	 *
	 * @param array $styles
	 *
	 * @return array
	 */
	function jkit_allowed_style_attr( $styles ) {
		$styles[] = 'display';

		return $styles;
	}
}

if ( ! function_exists( 'jkit_allowed_html' ) ) {

	add_filter( 'wp_kses_allowed_html', 'jkit_allowed_html', 99 );

	/**
	 * Allowed HTML List by Jeg Elementor Kit
	 */
	function jkit_allowed_html( $allowedtags = array() ) {
		$allowedtags['img'] = array_merge(
			isset( $allowedtags['img'] ) ? $allowedtags['img'] : array(),
			array(
				'loading'  => true,
				'id'       => true,
				'decoding' => true,
				'sizes'    => true,
			)
		);

		$allowedtags['a'] = array_merge(
			isset( $allowedtags['a'] ) ? $allowedtags['a'] : array(),
			array(
				'aria-label'    => true,
				'rel'           => true,
				'data-*'        => true,
				'aria-expanded' => true,
				'aria-controls' => true,
			)
		);

		$allowedtags['i'] = array_merge(
			isset( $allowedtags['i'] ) ? $allowedtags['i'] : array(),
			array(
				'aria-hidden' => true,
				'class'       => true,
			)
		);

		$allowedtags['link'] = array_merge(
			isset( $allowedtags['link'] ) ? $allowedtags['link'] : array(),
			array(
				'rel'  => true,
				'href' => true,
			)
		);

		$allowedtags['legend'] = array_merge(
			isset( $allowedtags['legend'] ) ? $allowedtags['legend'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['form'] = array_merge(
			isset( $allowedtags['form'] ) ? $allowedtags['form'] : array(),
			array(
				'method'       => true,
				'id'           => true,
				'class'        => true,
				'role'         => true,
				'action'       => true,
				'data-*'       => true,
				'autocomplete' => true,
			)
		);

		$allowedtags['fieldset'] = array_merge(
			isset( $allowedtags['fieldset'] ) ? $allowedtags['fieldset'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['input'] = array_merge(
			isset( $allowedtags['input'] ) ? $allowedtags['input'] : array(),
			array(
				'type'         => true,
				'name'         => true,
				'id'           => true,
				'class'        => true,
				'placeholder'  => true,
				'required'     => true,
				'value'        => true,
				'step'         => true,
				'min'          => true,
				'max'          => true,
				'title'        => true,
				'size'         => true,
				'inputmode'    => true,
				'autocomplete' => true,
			)
		);

		$allowedtags['label'] = array_merge(
			isset( $allowedtags['label'] ) ? $allowedtags['label'] : array(),
			array(
				'id'    => true,
				'class' => true,
				'for'   => true,
			)
		);

		$allowedtags['canvas'] = array_merge(
			isset( $allowedtags['canvas'] ) ? $allowedtags['canvas'] : array(),
			array(
				'height' => true,
				'width'  => true,
				'id'     => true,
				'class'  => true,
			)
		);

		$allowedtags['div'] = array_merge(
			isset( $allowedtags['div'] ) ? $allowedtags['div'] : array(),
			array(
				'style'    => true,
				'data-*'   => true,
				'tabindex' => true,
			)
		);

		$allowedtags['linearGradient'] = array_merge(
			isset( $allowedtags['linearGradient'] ) ? $allowedtags['linearGradient'] : array(),
			array(
				'gradientUnits'     => true,
				'gradientTransform' => true,
				'href'              => true,
				'spreadMethod'      => true,
				'x1'                => true,
				'x2'                => true,
				'y1'                => true,
				'y2'                => true,
				'id'                => true,
				'class'             => true,
				'style'             => true,
			)
		);

		$allowedtags['stop'] = array_merge(
			isset( $allowedtags['stop'] ) ? $allowedtags['stop'] : array(),
			array(
				'offset' => true,
			)
		);

		$allowedtags['svg'] = array_merge(
			isset( $allowedtags['svg'] ) ? $allowedtags['svg'] : array(),
			array(
				'id'                  => true,
				'xmlns'               => true,
				'viewbox'             => true,
				'preserveaspectratio' => true,
			)
		);

		$allowedtags['path'] = array_merge(
			isset( $allowedtags['path'] ) ? $allowedtags['path'] : array(),
			array(
				'd'                   => true,
				'pathLength'          => true,
				'id'                  => true,
				'tabindex'            => true,
				'class'               => true,
				'style'               => true,
				'requiredExtensions'  => true,
				'systemLanguage'      => true,
				'clip-path'           => true,
				'clip-rule'           => true,
				'color'               => true,
				'color-interpolation' => true,
				'color-rendering'     => true,
				'cursor'              => true,
				'display'             => true,
				'fill'                => true,
				'fill-opacity'        => true,
				'fill-rule'           => true,
				'filter'              => true,
				'mask'                => true,
				'opacity'             => true,
				'pointer-events'      => true,
				' shape-rendering'    => true,
				'stroke'              => true,
				'stroke-dasharray'    => true,
				'stroke-dashoffset'   => true,
				'stroke-linecap'      => true,
				'stroke-linejoin'     => true,
				'stroke-miterlimit'   => true,
				'stroke-opacity'      => true,
				'stroke-width'        => true,
				'transform'           => true,
				'vector-effect'       => true,
				'visibility'          => true,
			)
		);

		$allowedtags['select'] = array_merge(
			isset( $allowedtags['select'] ) ? $allowedtags['select'] : array(),
			array(
				'id'     => true,
				'class'  => true,
				'name'   => true,
				'value'  => true,
				'data-*' => true,
			)
		);

		$allowedtags['option'] = array_merge(
			isset( $allowedtags['option'] ) ? $allowedtags['option'] : array(),
			array(
				'id'    => true,
				'class' => true,
				'value' => true,
			)
		);

		$allowedtags['template'] = array_merge(
			isset( $allowedtags['template'] ) ? $allowedtags['template'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['p'] = array_merge(
			isset( $allowedtags['p'] ) ? $allowedtags['p'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['table'] = array_merge(
			isset( $allowedtags['table'] ) ? $allowedtags['table'] : array(),
			array(
				'id'          => true,
				'class'       => true,
				'cellspacing' => true,
				'data-*'      => true,
			)
		);

		$allowedtags['thead'] = array_merge(
			isset( $allowedtags['thead'] ) ? $allowedtags['thead'] : array(),
			array(
				'id'     => true,
				'class'  => true,
				'data-*' => true,
			)
		);

		$allowedtags['th'] = array_merge(
			isset( $allowedtags['th'] ) ? $allowedtags['th'] : array(),
			array(
				'id'      => true,
				'class'   => true,
				'data-*'  => true,
				'colspan' => true,
			)
		);

		$allowedtags['tbody'] = array_merge(
			isset( $allowedtags['tbody'] ) ? $allowedtags['tbody'] : array(),
			array(
				'id'     => true,
				'class'  => true,
				'data-*' => true,
			)
		);

		$allowedtags['tr'] = array_merge(
			isset( $allowedtags['tr'] ) ? $allowedtags['tr'] : array(),
			array(
				'id'     => true,
				'class'  => true,
				'data-*' => true,
			)
		);

		$allowedtags['td'] = array_merge(
			isset( $allowedtags['td'] ) ? $allowedtags['td'] : array(),
			array(
				'id'      => true,
				'class'   => true,
				'data-*'  => true,
				'colspan' => true,
			)
		);

		$allowedtags['button'] = array_merge(
			isset( $allowedtags['button'] ) ? $allowedtags['button'] : array(),
			array(
				'id'    => true,
				'class' => true,
				'type'  => true,
				'name'  => true,
				'value' => true,
			)
		);

		$allowedtags['header'] = array_merge(
			isset( $allowedtags['header'] ) ? $allowedtags['header'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['address'] = array_merge(
			isset( $allowedtags['address'] ) ? $allowedtags['address'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['nav'] = array_merge(
			isset( $allowedtags['nav'] ) ? $allowedtags['nav'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['ul'] = array_merge(
			isset( $allowedtags['ul'] ) ? $allowedtags['ul'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['li'] = array_merge(
			isset( $allowedtags['li'] ) ? $allowedtags['li'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h1'] = array_merge(
			isset( $allowedtags['h1'] ) ? $allowedtags['h1'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h2'] = array_merge(
			isset( $allowedtags['h2'] ) ? $allowedtags['h2'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h3'] = array_merge(
			isset( $allowedtags['h3'] ) ? $allowedtags['h3'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h4'] = array_merge(
			isset( $allowedtags['h4'] ) ? $allowedtags['h4'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h5'] = array_merge(
			isset( $allowedtags['h5'] ) ? $allowedtags['h5'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['h6'] = array_merge(
			isset( $allowedtags['h6'] ) ? $allowedtags['h6'] : array(),
			array(
				'id'    => true,
				'class' => true,
			)
		);

		$allowedtags['del'] = array_merge(
			isset( $allowedtags['del'] ) ? $allowedtags['del'] : array(),
			array(
				'aria-hidden' => true,
			)
		);

		$allowedtags['ins']   = array_merge( isset( $allowedtags['ins'] ) ? $allowedtags['ins'] : array(), array() );
		$allowedtags['style'] = array_merge( isset( $allowedtags['style'] ) ? $allowedtags['style'] : array(), array() );
		$allowedtags['bdi']   = array_merge( isset( $allowedtags['bdi'] ) ? $allowedtags['bdi'] : array(), array() );

		return $allowedtags;
	}
}

if ( ! function_exists( 'jkit_sanitize_array' ) ) {
	/**
	 * Sanitizing Array recursively
	 *
	 * @param array $data The data to be sanitized.
	 *
	 * @return array sanitized array
	 */
	function jkit_sanitize_array( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$data[ $key ] = jkit_sanitize_array( $value );
			}
			return $data;
		}
		return sanitize_text_field( $data );
	}
}

if ( ! function_exists( 'jkit_plugin_row_meta' ) ) {

	add_filter( 'plugin_row_meta', 'jkit_plugin_row_meta', 10, 2 );

	/**
	 * Filters the array of row meta and adds some custom links
	 *
	 * @param array  $plugin_meta
	 * @param string $plugin_file
	 *
	 * @return array
	 */
	function jkit_plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( $plugin_file === JEG_ELEMENTOR_KIT_BASE ) {
			$links = array(
				'<a class="jkit-meta-support" target="_blank" href="https://wordpress.org/support/plugin/jeg-elementor-kit/"><i class="fa fa-solid fa-life-ring"></i>' . esc_html__( 'Need Help?', 'jeg-elementor-kit' ) . '</a>',
				'<a class="jkit-meta-review" target="_blank" href="https://wordpress.org/support/plugin/jeg-elementor-kit/reviews/#new-post">' . esc_html__( 'Rate Us', 'jeg-elementor-kit' ) . '<span>★★★★★</span></a>',
			);

			$plugin_meta = array_merge( $plugin_meta, $links );
		}

		return $plugin_meta;
	}
}

if ( ! function_exists( 'jkit_get_languages' ) ) {
	/**
	 * Get The Available Languages
	 *
	 *  @return array
	 */
	function jkit_get_languages() {
		if ( function_exists( 'pll_the_languages' ) ) {
			return pll_the_languages( array( 'raw' => 1 ) );
		}

		if ( class_exists( 'SitePress' ) ) {
			/**
			 * Get The Active Languages by `wpml_active_languages` hook filters
			 */
			return apply_filters( 'wpml_active_languages', null, '' );
		}

		return array();
	}
}

if ( ! function_exists( 'jkit_get_the_language' ) ) {
	/**
	 * Get The Current Language
	 *
	 *  @return bool|string
	 */
	function jkit_get_current_language() {
		if ( function_exists( 'pll_current_language' ) ) {
			return pll_current_language();
		}

		if ( class_exists( 'SitePress' ) ) {
			/**
			 * Get The Current Language by `wpml_current_language` hook filters
			 */
			return apply_filters( 'wpml_current_language', null );
		}

		return false;
	}
}

if ( ! function_exists( 'jkit_is_multilanguage' ) ) {
	/**
	 * Check If Site Is Multilanguage
	 *
	 * @return bool
	 */
	function jkit_is_multilanguage() {
		if ( function_exists( 'PLL' ) || class_exists( 'SitePress' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'jkit_get_multilanguage_post_id' ) ) {
	/**
	 * Get the Multilanguage Post ID
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return int
	 */
	function jkit_get_multilanguage_post_id( $post_id = null ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$current_language = jkit_get_current_language();

		if ( function_exists( 'PLL' ) ) {
			return PLL()->model->post->get_translation( $post_id, $current_language );
		}

		if ( class_exists( 'SitePress' ) ) {
			$type = apply_filters( 'wpml_element_type', get_post_type( $post_id ) );
			$trid = apply_filters( 'wpml_element_trid', false, $post_id, $type );

			$translations = apply_filters( 'wpml_get_element_translations', array(), $trid, $type );

			if ( isset( $translations[ $current_language ] ) ) {
				$post_id = $translations[ $current_language ]->element_id;
			}
		}

		return $post_id;
	}
}
