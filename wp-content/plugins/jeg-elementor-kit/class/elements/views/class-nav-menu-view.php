<?php
/**
 * Nav Menu View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Nav_Menu_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Nav_Menu_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$menu_direction         = esc_attr( $this->attribute['sg_menu_direction'] );
		$menu_breakpoint        = esc_attr( $this->attribute['sg_menu_breakpoint'] );
		$submenu_position       = esc_attr( $this->attribute['sg_menu_sub_position'] );
		$mobile_logo_size       = esc_attr( $this->attribute['sg_mobile_menu_logo_size_imagesize_size'] );
		$mobile_logo_image      = $this->render_image_element( $this->attribute['sg_mobile_menu_logo'], $mobile_logo_size );
		$submenu_click_on_title = 'yes' === $this->attribute['sg_mobile_menu_submenu_click'] ? 'submenu-click-title' : 'submenu-click-icon';
		$mobile_menu_icon       = $this->render_icon_element( $this->attribute['sg_mobile_menu_icon'] );
		$mobile_close_icon      = $this->render_icon_element( $this->attribute['sg_mobile_close_icon'] );
		$item_indicator         = $this->render_icon_element( $this->attribute['st_submenu_item_indicator'] );
		$item_indicator         = esc_attr( preg_replace( '~[\r\n\s]+~', ' ', $item_indicator ) );

		add_filter( 'nav_menu_item_args', array( $this, 'add_jkit_mega_menu_args' ), 10, 3 );
		add_filter( 'nav_menu_css_class', array( $this, 'add_jkit_mega_menu_class' ), 10, 4 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'add_jkit_mega_menu' ), 10, 4 );

		/**
		 * TODO: must create custom menu walker for jeg elementor kit menu
		 */
		$menu = wp_nav_menu(
			array(
				'menu'            => esc_attr( $this->attribute['sg_menu_choose'] ),
				'menu_class'      => 'jkit-menu jkit-menu-direction-' . $menu_direction . ' jkit-submenu-position-' . $submenu_position,
				'container_class' => 'jkit-menu-container',
				'echo'            => false,
			)
		);

		remove_filter( 'walker_nav_menu_start_el', array( $this, 'add_jkit_mega_menu' ) );
		remove_filter( 'nav_menu_css_class', array( $this, 'add_jkit_mega_menu_class' ) );
		remove_filter( 'nav_menu_item_args', array( $this, 'add_jkit_mega_menu_args' ) );

		if ( 'default' === $this->attribute['sg_mobile_menu_link'] ) {
			$link_attr = array(
				'url'               => home_url(),
				'is_external'       => '',
				'nofollow'          => '',
				'custom_attributes' => 'aria-label|Home Link',
			);

			$mobile_logo_image = $this->render_url_element( $link_attr, null, 'jkit-nav-logo', $mobile_logo_image );
		} else {
			$mobile_logo_image = $this->render_url_element( $this->attribute['sg_mobile_menu_custom_link'], null, 'jkit-nav-logo', $mobile_logo_image );
		}

		$button_open_class  = 'jkit-hamburger-menu';
		$button_close_class = 'jkit-close-menu';

		if ( 'gradient' === $this->attribute['st_hamburger_menu_icon_background_background_background'] || 'gradient' === $this->attribute['st_hamburger_menu_icon_background_hover_background_background'] ) {
			$button_open_class .= ' hover-gradient';
			$mobile_menu_icon   = '<span>' . $mobile_menu_icon . '</span>';
		}

		if ( 'gradient' === $this->attribute['st_hamburger_menu_close_background_background_background'] || 'gradient' === $this->attribute['st_hamburger_menu_close_background_hover_background_background'] ) {
			$button_close_class .= ' hover-gradient';
			$mobile_close_icon   = '<span>' . $mobile_close_icon . '</span>';
		}

		$button_open  = '<button aria-label="open-menu" class="' . $button_open_class . '">' . $mobile_menu_icon . '</button>';
		$button_close = '<button aria-label="close-menu" class="' . $button_close_class . '">' . $mobile_close_icon . '</button>';

		$output =
		$button_open . '
        <div class="jkit-menu-wrapper">' . $menu . '
            <div class="jkit-nav-identity-panel">
                <div class="jkit-nav-site-title">' . $mobile_logo_image . '</div>
                ' . $button_close . '
            </div>
        </div>
        <div class="jkit-overlay"></div>';

		return $this->render_wrapper( 'nav-menu', $output, array( 'break-point-' . $menu_breakpoint, $submenu_click_on_title ), array( 'item-indicator' => $item_indicator ) );
	}

	/**
	 * Filters the arguments for a single nav menu item.
	 *
	 * @since 2.6.6
	 *
	 * @param stdClass $args      An object of wp_nav_menu() arguments.
	 * @param WP_Post  $menu_item Menu item data object.
	 * @param int      $depth     Depth of menu item. Used for padding.
	 */
	public function add_jkit_mega_menu_args( $args, $menu_item, $depth ) {
		$jkit_mega_menu = get_post_meta( $menu_item->ID, 'menu_item_jkit_mega_menu', true );

		if ( isset( $jkit_mega_menu['jkit_mega_menu'] ) ) {
			$args->jkit_mega_menu = $jkit_mega_menu['jkit_mega_menu'];
		} else {
			$args->jkit_mega_menu = '0';
		}

		if ( array_search( 'menu-item-has-children', $menu_item->classes ) ) {
			$args->jkit_mega_menu = '0';
		}

		return $args;
	}

	/**
	 * Filters the CSS classes applied to a menu item's list item element.
	 *
	 * @since 2.6.6
	 *
	 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
	 * @param WP_Post  $menu_item The current menu item object.
	 * @param stdClass $args      An object of wp_nav_menu() arguments.
	 * @param int      $depth     Depth of menu item. Used for padding.
	 */
	public function add_jkit_mega_menu_class( $classes, $menu_item, $args, $depth ) {
		if ( isset( $args->jkit_mega_menu ) && $args->jkit_mega_menu > 0 ) {
			array_push( $classes, 'has-mega-menu' );
		}

		return $classes;
	}

	/**
	 * Filters a menu item's starting output.
	 *
	 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
	 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
	 * no filter for modifying the opening and closing `<li>` for a menu item.
	 *
	 * @since 2.6.6
	 *
	 * @param string   $item_output The menu item's starting HTML output.
	 * @param WP_Post  $menu_item   Menu item data object.
	 * @param int      $depth       Depth of menu item. Used for padding.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function add_jkit_mega_menu( $item_output, $menu_item, $depth, $args ) {
		if ( isset( $args->jkit_mega_menu ) && $args->jkit_mega_menu !== '0' && get_the_ID() != $args->jkit_mega_menu ) {
			$template = \Elementor\Plugin::instance()->frontend->get_builder_content( $args->jkit_mega_menu, true );

			$class = 'jkit-mega-menu-wrapper jkit-mega-menu-' . $args->jkit_mega_menu;

			$template = '<div class="' . $class . '">' . $template . '</div>';

			$item_output .= $template;
		}

		return $item_output;
	}
}
