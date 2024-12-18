<?php
/**
 * Beaver Builder Abstract Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Beaver;

use Jeg\Element\Element;
use Jeg\Element\Elements\Elements_Option_Abstract;

/**
 * Class Beaver_Builder_Abstract
 *
 * @package Jeg\Element\Beaver
 */
abstract class Beaver_Builder_Abstract extends \FLBuilderModule {

	/**
	 * Beaver_Builder_Abstract constructor.
	 */
	public function __construct() {
		$options = $this->get_option_instance();
		parent::__construct(
			array(
				'name'            => $options->get_element_name(),
				'description'     => $options->get_element_name(),
				'category'        => $options->get_category(),
				'group'           => $this->get_beaver_group(),
				'dir'             => JEG_ELEMENT_DIR . '/beaver/',
				'url'             => JEG_ELEMENT_URL . '/beaver/',
				'editor_export'   => false,
				'partial_refresh' => true,
				'icon'            => 'minus.svg',
			)
		);
	}

	/**
	 * Get Element Option Instance
	 *
	 * @return Elements_Option_Abstract
	 */
	public function get_option_instance() {
		return Element::instance()->manager->get_element_option( $this->get_beaver_id() );
	}

	/**
	 * Get ID of this Element
	 *
	 * @return string
	 */
	abstract public function get_beaver_id();

	/**
	 * Get Group of this Element
	 *
	 * @return string
	 */
	abstract public function get_beaver_group();
}
