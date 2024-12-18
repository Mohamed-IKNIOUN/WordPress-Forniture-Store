<?php
/**
 * Pie Chart Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Pie_Chart_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Pie_Chart_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_pie_chart';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-piechart', 'chartjs' );
	}
}
