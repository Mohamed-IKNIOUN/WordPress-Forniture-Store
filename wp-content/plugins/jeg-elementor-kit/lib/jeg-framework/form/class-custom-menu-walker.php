<?php
/**
 * Customizer Custom Menu Walker
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

/**
 * Copied from Walker_Nav_Menu_Edit class in core
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Custom_Menu_Walker extends \Walker_Nav_Menu_Edit {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
	}


	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int $_wp_nav_menu_max_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args, $id );

		if ( ! empty( $item->menu_item_parent ) ) {
			$pattern_search = '/(?:(<li[\s\S]+?(?:id="menu-item-' . $item->menu_item_parent . '")+[\s\S]+?class=")([\s\S]+?)(">))/';
			$regex_search   = preg_match_all( $pattern_search, $output, $matches );

			if ( $regex_search > 0 && is_array( $matches[0] ) ) {
				$search_class_pattern = '/(class=")([\s\S]*)(")/';

				foreach ( $matches[0] as $key => $match ) {
					$selector       = array( 'have-child' );
					$exploded_class = explode( ' ', $matches[2][ $key ] );
					$merge          = array_unique( array_merge( $exploded_class, $selector ) );
					$new_class      = implode( ' ', $merge );

					preg_match( $search_class_pattern, $match, $tag_match );

					$output = preg_replace( $pattern_search, '$1' . $new_class . '$3', $output );
				}
			}
		}

		$output .= preg_replace(
			'/(?=<(fieldset|p)[^>]+class="[^"]*field-move)/',
			$this->get_fields( $item ),
			$item_output
		);
	}

	/**
	 * Get additional option rendered on Menu
	 *
	 * @return string
	 */
	public function get_fields() {
		ob_start();
		?>
		<div class='jeg-clearfix'></div>
		<div class='jeg-form-wrapper'>
			<div class='jeg-form-loader'>
				<?php esc_html_e( 'Loading Option', 'jeg-elementor-kit' ); ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
