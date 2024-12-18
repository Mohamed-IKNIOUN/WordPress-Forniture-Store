<?php
/**
 * Customizer Control: password.
 *
 * Creates a password
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Customizer\Control;

/**
 * Password control.
 */
class Password extends Text {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jeg-password';

	/**
	 * The input type.
	 *
	 * @access public
	 * @var string
	 */
	public $input_type = 'password';
}
