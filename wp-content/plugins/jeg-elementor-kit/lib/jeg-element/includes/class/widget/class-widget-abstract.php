<?php
/**
 * Jeg News Element Widget Abstract
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Widget;

use Jeg\Element\Element;
use Jeg\Element\Elements\Elements_Option_Abstract;
use Jeg\Element\Elements\Elements_View_Abstract;
use Jeg\Form\Form_Widget;

/**
 * Class Widget_Abstract
 *
 * @package Jeg\Element\Widget
 */
abstract class Widget_Abstract extends \WP_Widget {
	/**
	 * Widget_Abstract constructor.
	 */
	public function __construct() {
		$widget_options['customize_selective_refresh'] = true;

		if ( apply_filters( 'jeg_widget_backend_script', is_admin() ) ) {
			$instance = $this->get_option_instance();
			parent::__construct(
				$this->get_widget_id(),
				$instance->get_element_name(),
				array(
					'description' => $instance->get_element_name(),
				)
			);
		} else {
			parent::__construct( $this->get_widget_id(), null, null );
		}
	}

	/**
	 * Get Element Option Instance
	 *
	 * @return Elements_Option_Abstract
	 */
	public function get_option_instance() {
		return Element::instance()->manager->get_element_option( $this->get_widget_id() );
	}

	/**
	 * Get element view instance
	 *
	 * @return Elements_View_Abstract
	 */
	public function get_view_instance() {
		return Element::instance()->manager->get_element_view( $this->get_widget_id() );
	}

	/**
	 * Compatible column Warning
	 */
	public function compatible_column() {
		?>
		<div class="alert-element alert-info" style='margin-top: 15px;'>
			<strong>Compatible
				Column: <?php echo esc_html( implode( ', ', $this->get_option_instance()->compatible_column() ) ); ?></strong>
			<div class="alert-description"><?php esc_html_e( 'Please check style / design tab to change Module / Block width and make it fit with your current column width', 'jeg-elementor-kit' ); ?></div>
		</div>
		<?php
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 *
	 * @return string Default return is 'noform'.
	 */
	public function form( $instance ) {
		$id       = $this->get_field_id( 'widget_element' );
		$segments = $this->prepare_segments( $this->get_option_instance()->get_segments() );
		$fields   = $this->prepare_fields( $instance, $this->get_option_instance()->get_options() );

		$this->compatible_column();
		Form_Widget::render_form( $id, $segments, $fields );

		// TODO: currently, need to disable because Saved button on the widget doesn't show
		// return 'noform';
	}

	/**
	 * Prepare segment for shortcode generator
	 *
	 * @param array $segments Collection of segments.
	 *
	 * @return array
	 */
	public function prepare_segments( $segments ) {
		$results = array();

		foreach ( $segments as $key => $segment ) {
			$results[ $key ] = jeg_prepare_segment( $key, $segment );
		}

		return $results;
	}

	/**
	 * Prepare Fields
	 *
	 * @param array $instance Value of this widget.
	 * @param array $fields collection of control / field.
	 *
	 * @return array
	 */
	public function prepare_fields( $instance, $fields ) {
		$setting = array();

		foreach ( $fields as $key => $field ) {
			if ( 'compatible_column_notice' === $key ) {
				continue;
			}

			$setting[ $key ] = jeg_prepare_field(
				$key,
				$field,
				$instance,
				array(
					'fieldName' => $this->get_field_name( $key ),
					'fieldID'   => $this->get_field_id( $key ),
				)
			);
		}

		return $setting;
	}

	/**
	 * Echoes the widget content.
	 *
	 * Sub-classes should over-ride this function to generate their widget code.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );

		echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) );

		if ( ! empty( $title ) ) {
			echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ) . esc_html( $title ) . $args['after_title'];
		}

		echo wp_kses( $this->get_view_instance()->render_widget( $instance ), wp_kses_allowed_html( 'post' ) );

		echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) );
	}

	/**
	 * Get ID of this widget
	 *
	 * @return string
	 */
	abstract public function get_widget_id();
}
