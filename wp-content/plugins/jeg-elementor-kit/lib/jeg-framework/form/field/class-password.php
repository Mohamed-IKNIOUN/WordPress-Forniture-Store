<?php
/**
 * Customizer Control: Password.
 *
 * Creates a password
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Password control.
 */
class Password extends Text {

	/**
	 * Form Password Template
	 *
	 * @var string
	 */
	protected $type = 'password';

	/**
	 * Input Type
	 *
	 * @var string
	 */
	protected $input_type = 'password';
}
