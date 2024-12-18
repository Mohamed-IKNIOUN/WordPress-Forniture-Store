<?php
/**
 * Jeg Elementor Kit Class
 *
 * @package jeg-elementor-kit
 *
 * @author Jegtheme
 *
 * @since 2.0.0
 */

namespace Jeg\Elementor_Kit\Templates;

use Jeg\Elementor_Kit\Dashboard\Dashboard;

/**
 * Class Template
 *
 * @package Jeg\Elementor_Kit
 */
class Template {
	/**
	 * Class template instance
	 *
	 * @var Template
	 */
	private static $instance;

	/**
	 * Header template list
	 */
	private $header_template;

	/**
	 * Footer template list
	 */
	private $footer_template;

	/**
	 * Module constructor.
	 */
	private function __construct() {
		$this->setup_hook();
	}

	/**
	 * Setup Hooks
	 */
	private function setup_hook() {
		add_action( 'wp', array( $this, 'header_footer_template' ) );
		if ( class_exists( '\Elementor\Plugin' ) ) {
			add_filter( 'template_include', array( $this, 'custom_template' ), 11 );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Get class template instance
	 *
	 * @return Template
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Enqueue Styles
	 */
	public function enqueue_styles() {
		if ( class_exists( '\Elementor\Plugin' ) && ! empty( \Elementor\Plugin::$instance->frontend ) ) {
			\Elementor\Plugin::$instance->frontend->enqueue_styles();
		}
	}

	/**
	 * Get custom template
	 *
	 * @param string $template Template location.
	 *
	 * @return string
	 */
	public function custom_template( $template ) {
		global $post;

		if ( null !== $post && is_single() && ( 'jkit-header' === $post->post_type || 'jkit-footer' === $post->post_type ) ) {
			if ( file_exists( JEG_ELEMENTOR_KIT_DIR . 'templates/single-template.php' ) ) {
				return JEG_ELEMENTOR_KIT_DIR . 'templates/single-template.php';
			}
		}

		if ( is_404() ) {
			$notfound_template = get_option( 'jkit_notfound_template' );

			if ( $notfound_template && 'publish' === get_post_status( $notfound_template ) ) {
				return JEG_ELEMENTOR_KIT_DIR . 'templates/404-template.php';
			}
		}

		return $template;
	}

	/**
	 * Setup hook for custom header and footer template
	 */
	public function header_footer_template() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		if ( $this->get_header_template() ) {
			add_action( 'get_header', array( $this, 'override_theme_header_template' ), 99 );
			add_action( 'jkit_header', array( $this, 'render_header' ) );
		}

		if ( $this->get_footer_template() ) {
			add_action( 'get_footer', array( $this, 'override_theme_footer_template' ), 99 );
			add_action( 'jkit_footer', array( $this, 'render_footer' ) );
		}
	}

	/**
	 * Get all footer template
	 *
	 * @return array
	 */
	public function get_footer_template() {
		if ( ! $this->footer_template ) {
			$this->footer_template = jkit_get_element( 'publish', Dashboard::$jkit_footer );
		}

		return $this->footer_template;
	}

	/**
	 * Get all header template
	 *
	 * @return array
	 */
	public function get_header_template() {
		if ( ! $this->header_template ) {
			$this->header_template = jkit_get_element( 'publish', Dashboard::$jkit_header );
		}

		return $this->header_template;
	}

	/**
	 * Override footer template from theme
	 */
	public function override_theme_footer_template() {
		load_template( JEG_ELEMENTOR_KIT_DIR . 'templates/footer-template.php' );
		$templates   = array();
		$templates[] = 'footer.php';
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	/**
	 * Override header template from theme
	 */
	public function override_theme_header_template() {
		load_template( JEG_ELEMENTOR_KIT_DIR . 'templates/header-template.php' );
		$templates   = array();
		$templates[] = 'header.php';
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	/**
	 * Render custom footer template
	 */
	public function render_footer() {
		$post_id   = get_the_ID();
		$footers   = $this->get_footer_template();
		$footer_id = null;

		foreach ( $footers as $footer ) {
			$flag = $this->check_conditions( $post_id, $footer['id'] );

			if ( $flag ) {
				$footer_id = $footer['id'];
				break;
			}
		}

		if ( $footer_id ) {
			?>
				<footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">
					<?php $this->get_footer_content( $footer_id ); ?>
				</footer>
			<?php
		}
	}

	/**
	 * Render custom header template
	 */
	public function render_header() {
		$post_id   = get_the_ID();
		$headers   = $this->get_header_template();
		$header_id = null;

		foreach ( $headers as $header ) {
			$flag = $this->check_conditions( $post_id, $header['id'] );

			if ( $flag ) {
				$header_id = $header['id'];
				break;
			}
		}

		if ( $header_id ) {
			?>
				<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
					<?php $this->get_header_content( $header_id ); ?>
				</header>
			<?php
		}
	}

	/**
	 * Get content of custom footer template
	 */
	public function get_footer_content( $footer_id ) {
		/** Handled by Elementor self */
		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_id, true );
	}

	/**
	 * Get content of custom header template
	 */
	public function get_header_content( $header_id ) {
		/** Handled by Elementor self */
		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_id, true );
	}

	/**
	 * Check general condition
	 */
	public function check_conditions( $post_id, $header_id ) {
		$flag       = true;
		$conditions = get_post_meta( $header_id, Dashboard::$jkit_condition, true );
		$conditions = maybe_unserialize( $conditions );

		if ( $conditions ) {
			foreach ( $conditions as $condition ) {
				switch ( $condition['location'] ) {
					case 'singular':
					case 'post_single':
						$flag = $flag && $this->condition_singular( $post_id, $condition );
						break;
					case 'category':
					case 'post_tag':
						$flag = $flag && $this->condition_post_terms( $post_id, $condition, $condition['location'] );
						break;
					case 'archives':
						$flag = $flag && $this->condition_archive( $condition );
						break;
					case 'shop_page':
						$flag = $flag && $this->condition_shop_page( $condition );
						break;
					case 'product_cat':
					case 'product_tag':
						$flag = $flag && $this->condition_product_terms( $post_id, $condition, $condition['location'] );
						break;
					case 'product_single':
						$flag = $flag && $this->condition_product( $post_id, $condition );
						break;
				}
			}

			if ( jkit_is_multilanguage() && ! empty( $condition['language'] ) ) {
				$flag = $flag && $condition['language'] === jkit_get_current_language();
			}
		} else {
			$flag = false;
		}

		return apply_filters( 'jkit_check_template_conditions', $flag, $post_id, $header_id, $conditions );
	}

	/**
	 * Check shop page condition
	 */
	public function condition_shop_page( $condition ) {
		$flag = ( function_exists( 'is_shop' ) && is_shop() );

		if ( 'include' === $condition['enclose'] ) {
			if ( ! $flag ) {
				return false;
			}
		} elseif ( $flag ) {
				return false;
		}

		return true;
	}

	/**
	 * Check single product condition
	 */
	public function condition_product( $post_id, $condition ) {
		$flag = in_array( $post_id, explode( ',', $condition['product'] ) );

		if ( 'include' === $condition['enclose'] ) {
			if ( ! $flag ) {
				return false;
			}
		} elseif ( $flag ) {
				return false;
		}

		return true;
	}

	/**
	 * Check post taxonomy condition
	 */
	public function condition_post_terms( $post_id, $condition, $taxonomy ) {
		$post_terms_ids    = array();
		$post_terms_now    = get_the_terms( $post_id, $taxonomy );
		$post_terms_filter = explode( ',', $condition[ $taxonomy ] );

		if ( $post_terms_now && is_array( $post_terms_now ) ) {
			foreach ( $post_terms_now as $item ) {
				$post_terms_ids[] = $item->term_id;
			}
		}

		$flag = array_intersect( $post_terms_ids, $post_terms_filter );

		if ( 'include' === $condition['enclose'] ) {
			if ( empty( $flag ) ) {
				return false;
			}
		} elseif ( $flag ) {
				return false;
		}

		return true;
	}

	/**
	 * Check product taxonomy condition
	 */
	public function condition_product_terms( $post_id, $condition, $taxonomy ) {
		if ( $condition[ $taxonomy ] ) {
			$product_terms_now    = wc_get_product_term_ids( $post_id, $taxonomy );
			$product_terms_filter = explode( ',', $condition[ $taxonomy ] );
			$flag                 = array_intersect( $product_terms_now, $product_terms_filter );

			if ( 'include' === $condition['enclose'] ) {
				if ( empty( $flag ) ) {
					return false;
				}
			} elseif ( $flag ) {
					return false;
			}
		}

		return true;
	}

	/**
	 * Check singular condition
	 */
	public function condition_singular( $post_id, $condition ) {
		switch ( $condition['singular'] ) {
			case 'notfound':
				$flag = is_404();
				break;
			case 'front':
				$flag = is_front_page();
				break;
			case 'singular':
			default:
				$flag = is_singular() && $this->condition_singular_detail( $post_id, $condition );
		}

		if ( 'include' === $condition['enclose'] ) {
			return $flag;
		} else {
			return ! $flag;
		}
	}

	/**
	 * Check archive condition
	 */
	public function condition_archive( $condition ) {
		$flag = true;

		switch ( $condition['archives'] ) {
			case 'date':
				$flag = is_date();
				break;
			case 'search':
				$flag = is_search();
				break;
			case 'author':
				$object = get_queried_object();
				$flag   = is_author();

				if ( ! empty( $condition['archives_author'] ) ) {
					$authors   = explode( ',', $condition['archives_author'] );
					$author_id = $object->ID;

					if ( in_array( (string) $author_id, $authors, true ) ) {
						$flag = $flag && true;
					} else {
						$flag = $flag && false;
					}
				}
				break;
			case 'taxonomy':
				$object = get_queried_object();
				$flag   = is_archive();

				if ( ! empty( $condition['archive_taxonomy'] ) && $object ) {
					$terms   = explode( ',', $condition['archive_taxonomy'] );
					$term_id = $object->term_id;

					if ( in_array( (string) $term_id, $terms, true ) ) {
						$flag = $flag && true;
					} else {
						$flag = $flag && false;
					}
				}
				break;
		}

		$taxonomies = jkit_get_taxonomies( false );
		$object     = get_queried_object();

		if ( in_array( $condition['archives'], $taxonomies ) && $object ) {

			if ( isset( $object->taxonomy ) && $object->taxonomy === $condition['archives'] ) {
				if ( $condition['archive_taxonomy'] && ! in_array( $object->term_id, explode( ',', $condition['archive_taxonomy'] ) ) ) {
					$flag = false;
				}
			} else {
				$flag = false;
			}
		}

		if ( 'include' === $condition['enclose'] ) {
			return $flag;
		} else {
			return ! $flag;
		}
	}

	/**
	 * Check detail singular condition
	 */
	public function condition_singular_detail( $post_id, $condition ) {
		$flag = true;

		// Check Post Type Condition
		if ( '' === $condition['posttype'] ) {
			$flag = $flag && true;
		} else {
			$post_type_flag = get_post_type( $post_id ) === $condition['posttype'];
			$flag           = $flag && $post_type_flag;
		}

		// Check post ID
		if ( ! empty( $condition['singular_post'] ) ) {
			$posts = explode( ',', $condition['singular_post'] );
			if ( in_array( (string) $post_id, $posts, true ) ) {
				$flag = $flag && true;
			} else {
				$flag = $flag && false;
			}
		}

		// Check taxonomy
		if ( ! empty( $condition['singular_taxonomy'] ) ) {
			$taxonomies = get_taxonomies( '', 'names' );
			$terms      = wp_get_post_terms( $post_id, $taxonomies, array( 'fields' => 'ids' ) );
			$term_flag  = false;

			if ( $terms ) {
				$taxonomies = explode( ',', $condition['singular_taxonomy'] );
				foreach ( $taxonomies as $term ) {
					$term      = (int) $term;
					$term_flag = $term_flag || in_array( $term, $terms, true );
				}
			}

			$flag = $flag && $term_flag;
		}

		// Check Author
		if ( ! empty( $condition['singular_author'] ) ) {
			$authors   = explode( ',', $condition['singular_author'] );
			$author_id = get_post_field( 'post_author', $post_id );

			if ( in_array( $author_id, $authors, true ) ) {
				$flag = $flag && true;
			} else {
				$flag = $flag && false;
			}
		}

		return $flag;
	}
}
