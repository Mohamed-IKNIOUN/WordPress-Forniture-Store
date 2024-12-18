<?php
/**
 * Client Logo View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Client_Logo_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Client_Logo_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$arrow_position = esc_attr( $this->attribute['sg_setting_arrow_position'] );
		$output         = '<div class="client-list"><div class="client-track">' . $this->render_logo() . '</div></div>';

		return $this->render_wrapper(
			'client-logo',
			$output,
			array( 'arrow-' . $arrow_position ),
			array(
				'id'       => $this->unique_id,
				'settings' => $this->render_option(),
			)
		);
	}

	/**
	 * Render Logo
	 */
	private function render_logo() {
		$list_logo  = '';
		$image_size = $this->attribute['sg_logo_image_size_imagesize_size'];

		foreach ( $this->attribute['sg_logo_list'] as $logo ) {
			$hover_image = 'yes' === $logo['sg_logo_list_hover_enable'] ? $this->render_image_element( $logo['sg_logo_list_hover_logo'], $image_size, null, 'hover-image', esc_attr( $logo['sg_logo_list_title'] ) ) : '';
			$logo_image  = $this->render_image_element( $logo['sg_logo_list_image'], $image_size, null, 'main-image', esc_attr( $logo['sg_logo_list_title'] ) );
			$logo_url    = $logo['sg_logo_list_link_enable'];

			if ( 'yes' === $logo_url ) {
				$content_image = $this->render_url_element( $logo['sg_logo_list_link'], null, 'client-logo-link', '<div class="content-image">' . $logo_image . $hover_image . '</div>' );
			} else {
				$content_image = '<div class="content-image">' . $logo_image . $hover_image . '</div>';
			}

			$hover_class = ! empty( $hover_image ) ? 'hover-enable' : '';
			$list_logo   = $list_logo . '<div class="client-slider item ' . $hover_class . '"><div class="image-list">' . $content_image . '</div></div>';
		}

		return $list_logo;
	}

	/**
	 * Render Option
	 */
	private function render_option() {
		$default    = array(
			'dekstop' => array(
				'items'  => 3,
				'margin' => 10,
			),
		);
		$responsive = array();
		$nav_left   = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_setting_arrow_left'] ) );
		$nav_right  = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_setting_arrow_right'] ) );
		$items      = ! empty( $this->attribute['sg_setting_slide_show_responsive']['size'] ) ? $this->attribute['sg_setting_slide_show_responsive']['size'] : $default['dekstop']['items'];
		$margin     = ! empty( $this->attribute['sg_setting_margin_responsive']['size'] ) ? $this->attribute['sg_setting_margin_responsive']['size'] : $default['dekstop']['margin'];

		if ( 'gradient' === $this->attribute['st_arrow_normal_background_background_background'] || 'gradient' === $this->attribute['st_arrow_hover_background_background_background'] ) {
			$icon_class = 'hover-gradient';
			$nav_left   = '<span class="' . $icon_class . '">' . $nav_left . '</span>';
			$nav_right  = '<span class="' . $icon_class . '">' . $nav_right . '</span>';
		} else {
			$nav_left  = '<span>' . $nav_left . '</span>';
			$nav_right = '<span>' . $nav_right . '</span>';
		}

		$prev_key              = 'desktop';
		$responsive['desktop'] = array(
			'items'      => $items,
			'margin'     => $margin,
			'breakpoint' => 0,
		);

		foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
			$responsive[ $breakpoint['key'] ]      = array(
				'items'      => $items,
				'margin'     => $margin,
				'breakpoint' => 0,
			);
			$responsive[ $prev_key ]['breakpoint'] = $breakpoint['value'] + 1;

			if ( isset( $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['items'] = ! empty( $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ]['size'] : $items;
			}

			if ( isset( $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['margin'] = ! empty( $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ]['size'] : $margin;
			}

			$prev_key = $breakpoint['key'];
		}

		$options = array(
			'autoplay'             => 'yes' === $this->attribute['sg_setting_autoplay'],
			'autoplay_speed'       => intval( $this->attribute['sg_setting_autoplay_speed']['size'] ),
			'autoplay_hover_pause' => 'yes' === $this->attribute['sg_setting_autoplay_pause'],
			'show_navigation'      => 'yes' === $this->attribute['sg_setting_arrow'],
			'navigation_left'      => $nav_left,
			'navigation_right'     => $nav_right,
			'show_dots'            => 'yes' === $this->attribute['sg_setting_dots'],
			'arrow_position'       => 'top-left' === $this->attribute['sg_setting_arrow_position'] || 'top-right' === $this->attribute['sg_setting_arrow_position'] ? 'top' : 'bottom',
			'responsive'           => $responsive,
		);

		return htmlspecialchars( wp_json_encode( $options ), ENT_QUOTES, 'UTF-8' );
	}
}
