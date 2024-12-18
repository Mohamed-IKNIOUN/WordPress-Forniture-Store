<?php
/**
 * @author      Jegtheme
 * @license     https://opensource.org/licenses/MIT
 */

namespace Jeg\Customizer\Partial;

/**
 * Default Settings
 */
class Lazy_Partial extends \WP_Customize_Partial {

	/**
	 * Pattern : partial(section)(id)
	 *
	 * @var string pattern
	 */
	public static $pattern = '/^partial\((?P<section>[^\)]+)\)\((?P<id>[^\)]+)\)$/';

	/**
	 * Pattern to be replaced in javascript
	 */
	public static function js_pattern_template() {
		return 'partial({section})({id})';
	}
}
