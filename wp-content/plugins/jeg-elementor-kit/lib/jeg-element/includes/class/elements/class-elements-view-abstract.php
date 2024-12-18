<?php
/**
 * Jeg News Element Background Load Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Elements;

use Jeg\Element\Element;
use Jeg\Element\Query;

/**
 * Class Jeg Module
 */
abstract class Elements_View_Abstract {
	/**
	 * ID of this element. also used as shortcode name.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Class path for every element related.
	 *
	 * @var array
	 */
	protected $classes;

	/**
	 * Option Field
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Hold Element Manager
	 *
	 * @var Elements_Manager
	 */
	protected $manager;

	/**
	 * Shortcode Content
	 *
	 * @var String
	 */
	protected $content;

	/**
	 * Shortcode Attribute
	 *
	 * @var array
	 */
	protected $attribute;

	/**
	 * This element Unique ID.
	 *
	 * @var string
	 */
	protected $unique_id;

	/**
	 * Elements_Option_Abstract constructor.
	 *
	 * @param string $id Shortcode name for this instance.
	 * @param string $classes Classes Related To this Instance.
	 */
	public function __construct( $id, $classes ) {
		$this->manager = Element::instance()->manager;
		$this->set_data( $id, $classes );
		$this->set_options();
	}

	/**
	 * Set Option
	 */
	public function set_options() {
		$this->options = $this->manager->get_element_option( $this->id )->get_simple_options();
	}

	/**
	 * Prepare to build query.
	 *
	 * @param array $attr Attribute.
	 *
	 * @return array
	 */
	protected function build_query( $attr ) {
		if ( isset( $attr['unique_content'] ) && 'disable' !== $attr['unique_content'] ) {
			if ( ! empty( $attr['exclude_post'] ) ) {
				$exclude_post = explode( ',', $attr['exclude_post'] );
			} else {
				$exclude_post = array();
			}

			$exclude_post         = array_merge( $this->manager->get_unique_article( $attr['unique_content'] ), $exclude_post );
			$attr['exclude_post'] = implode( ',', $exclude_post );

			// we need to alter attribute here...
			$this->set_attribute( $attr );
		}

		$result = Query::get( $attr );

		if ( isset( $attr['unique_content'] ) && 'disable' !== $attr['unique_content'] ) {
			$this->manager->add_unique_article( $attr['unique_content'], $this->collect_post_id( $result ) );
		}

		if ( isset( $result['result'] ) ) {
			foreach ( $result['result'] as $post ) {
				do_action( 'jeg_json_archive_push', $post->ID );
			}
		}

		return $result;
	}

	/**
	 * Extract post id from result.
	 *
	 * @param array $content Content.
	 *
	 * @return array
	 */
	protected function collect_post_id( $content ) {
		$post_ids = array();
		foreach ( $content['result'] as $result ) {
			$post_ids[] = $result->ID;
		}

		return $post_ids;
	}

	/**
	 * Set shortcode
	 *
	 * @param string $id Shortcode name for this instance.
	 * @param string $classes Classes Related To this Instance.
	 */
	public function set_data( $id, $classes ) {
		$this->id      = $id;
		$this->classes = $classes;
	}

	/**
	 * Build & Render Element.
	 *
	 * @param array  $attr Attribute.
	 * @param string $content Content.
	 *
	 * @return string HTML Tag for this element.
	 */
	public function build_element( $attr, $content = null ) {
		$this->set_attribute( $attr );
		$this->set_content( $content );
		$this->generate_unique_id();

		$column_class = $this->get_element_column_class();
		$output       = $this->render_element( $this->attribute, $column_class );

		do_action( $this->id );

		return $output;
	}

	/**
	 * Build Result Array
	 *
	 * @param array $result
	 */
	public function build_result_element( $result, $attr ) {
		$this->set_attribute( $attr );
		$this->generate_unique_id();
		return $this->render_result_element( $result, $this->attribute );
	}

	/**
	 * Get Post ID of this element
	 *
	 * @return int
	 */
	public function get_post_id() {
		global $wp_query;
		if ( isset( $wp_query->post ) ) {
			return $wp_query->post->ID;
		}

		return null;
	}

	/**
	 * Generate Unique ID For Module
	 */
	public function generate_unique_id() {
		$this->unique_id = 'jeg_module_' . $this->get_post_id() . '_' . $this->manager->get_element_count() . '_' . uniqid();
		$this->manager->increase_element_count();
	}

	/**
	 * Get this element column class
	 *
	 * @param null|array $attr Attribute if necessary.
	 *
	 * @return string
	 */
	public function get_element_column_class( $attr = null ) {
		$attr = is_null( $attr ) ? $this->attribute : $attr;

		if ( isset( $attr['column_width'] ) && 'auto' !== $attr['column_width'] ) {
			switch ( $attr['column_width'] ) {
				case 4:
					$class_name = 'jeg_col_1o3';
					break;
				case 8:
					$class_name = 'jeg_col_2o3';
					break;
				case 12:
					$class_name = 'jeg_col_3o3';
					break;
				default:
					$class_name = 'jeg_col_3o3';
			}

			return $class_name;
		} else {
			return $this->manager->get_column_class();
		}
	}

	/**
	 * Set content
	 *
	 * @param string $content Content String.
	 */
	public function set_content( $content ) {
		$this->content = $content;
	}

	/**
	 * Set Attribute
	 *
	 * @param array $attr store attribute.
	 */
	public function set_attribute( $attr ) {
		$this->attribute = wp_parse_args( $attr, $this->options );
	}

	/**
	 * Additional class for element
	 *
	 * @return string
	 */
	public function additional_class() {
		$classes = array();

		$classes[] = $this->unique_id;
		$classes[] = isset( $this->attribute['scheme'] ) ? $this->attribute['scheme'] : '';

		$classes = apply_filters( 'jeg_element_additional_class', $classes, $this->id, $this->get_post_id(), $this->attribute );

		return join( ' ', $classes );
	}

	/**
	 * Write Element ID.
	 *
	 * @param array $attr Attribute.
	 *
	 * @return null|string
	 */
	public function element_id( $attr ) {
		if ( isset( $attr['el_id'] ) && ! empty( $attr['el_id'] ) ) {
			return "id='{$attr['el_id']}'";
		}

		return null;
	}

	/**
	 * Render Widget
	 *
	 * @param array $instance The settings for the particular instance of the widget.
	 *
	 * @return string
	 */
	public function render_widget( $instance ) {
		return $this->build_element( $instance );
	}

	/**
	 * Render Element
	 *
	 * @param array  $attr Array of attribute.
	 * @param string $column_class Class string.
	 *
	 * @return mixed
	 */
	abstract public function render_element( $attr, $column_class );
	abstract public function render_result_element( $result, $attr );
}
