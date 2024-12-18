<?php
/**
 * Heading View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Heading_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Heading_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$content = '';
		$class   = '';

		$title              = $this->render_title();
		$subtitle           = $this->render_subtitle();
		$separator          = $this->render_separator();
		$shadow             = $this->render_shadow();
		$description        = $this->render_description();
		$float_left         = 'yes' === $this->attribute['sg_title_float_left'];
		$separator_position = $this->attribute['sg_separator_position'];
		$desktop_alignment  = isset( $this->attribute['st_general_alignment_responsive'] ) ? esc_attr( $this->attribute['st_general_alignment_responsive'] ) : '';
		$tablet_alignment   = isset( $this->attribute['st_general_alignment_responsive_tablet'] ) ? esc_attr( $this->attribute['st_general_alignment_responsive_tablet'] ) : '';
		$mobile_alignment   = isset( $this->attribute['st_general_alignment_responsive_mobile'] ) ? esc_attr( $this->attribute['st_general_alignment_responsive_mobile'] ) : '';

		if ( $float_left ) {
			$class = 'title-float-left';

			if ( 'top' === $separator_position || 'before' === $separator_position ) {
				$title = $separator . $title;
			} else {
				$title = $title . $separator;
			}

			$content = '<div class="jkit-heading-title-wrapper">' . $title . '</div><div class="jkit-heading-content-wrapper">' . $subtitle . $description . '</div>';
		} else {
			$subtitle_position = $this->attribute['sg_subtitle_position'];

			if ( 'before' === $separator_position || 'after' === $separator_position ) {
				if ( 'before' === $separator_position ) {
					$title = $separator . $title;
				} else {
					$title = $title . $separator;
				}

				if ( 'before' === $subtitle_position ) {
					$title = $subtitle . $title;
				} else {
					$title = $title . $subtitle;
				}

				$content = $title . $description;
			} else {
				if ( 'before' === $subtitle_position ) {
					$title = $subtitle . $title;
				} else {
					$title = $title . $subtitle;
				}

				if ( 'top' === $separator_position ) {
					$content = $separator . $title . $description;
				} else {
					$content = $title . $description . $separator;
				}
			}
		}

		return $this->render_wrapper( 'heading', $shadow . $content, array( $class, 'align-' . $desktop_alignment, 'align-tablet-' . $tablet_alignment, 'align-mobile-' . $mobile_alignment ) );
	}

	/**
	 * Render Title
	 *
	 * @return mixed
	 */
	private function render_title() {
		$title   = '';
		$class   = '';
		$content = '';

		if ( 'highlight' === $this->attribute['sg_title_concept'] ) {
			$title         = esc_attr( $this->attribute['sg_title_text'] );
			$focused_class = 'style-' . esc_attr( $this->attribute['st_focused_color_style'] );

			$title = str_replace( '{{', '<span class="' . $focused_class . '"><span>', $title );
			$title = str_replace( '}}', '</span></span>', $title );

			$content = $title;
		} else {
			$before  = esc_attr( $this->attribute['sg_title_before'] );
			$focused = esc_attr( $this->attribute['sg_title_focused'] );
			$after   = esc_attr( $this->attribute['sg_title_after'] );

			if ( ! empty( $focused ) ) {
				$focused_class = 'style-' . esc_attr( $this->attribute['st_focused_color_style'] );
				$focused       = '<span class="' . $focused_class . '"><span>' . $focused . '</span></span>';
			}

			$content = $before . $focused . $after;
		}

		$html_tag      = \Elementor\Utils::validate_html_tag( $this->attribute['sg_title_html_tag'] );
		$border_enable = 'yes' === $this->attribute['sg_title_border_enable'];

		if ( $border_enable ) {
			$position = esc_attr( $this->attribute['sg_title_border_position'] );
			$class    = 'border-enable ' . $position;
		}

		$focused_title_display = $this->attribute['sg_title_focused_title_display'];

		if ( ! empty( $focused_title_display ) ) {
			$class .= ' display-' . $focused_title_display;
		}

		$title = '<div class="heading-section-title ' . $class . '"><' . $html_tag . ' class="heading-title">' . $content . '</' . $html_tag . '></div>';

		return wp_kses_post( $title );
	}

	/**
	 * Render Subtitle
	 *
	 * @return mixed
	 */
	private function render_subtitle() {
		$content = '';
		$class   = '';

		$enable = 'yes' === $this->attribute['sg_subtitle_enable'];

		if ( $enable ) {
			$html_tag       = \Elementor\Utils::validate_html_tag( $this->attribute['sg_subtitle_html_tag'] );
			$subtitle       = esc_attr( $this->attribute['sg_subtitle_heading'] );
			$color_style    = esc_attr( $this->attribute['st_subtitle_color_style'] );
			$outline_enable = 'yes' === $this->attribute['sg_subtitle_outline_enable'];
			$border_enable  = 'yes' === $this->attribute['sg_subtitle_border_enable'];

			if ( $outline_enable ) {
				$class = 'outline-enable';
			}

			if ( $border_enable ) {
				$class = 'border-enable';
			}

			$class .= ' style-' . $color_style;

			if ( ! empty( $subtitle ) ) {
				$content = '<' . $html_tag . ' class="heading-section-subtitle ' . $class . '">' . $subtitle . '</' . $html_tag . '>';
			}
		}

		return $content;
	}

	/**
	 * Render Description
	 *
	 * @return mixed
	 */
	private function render_description() {
		$content = '';
		$enable  = 'yes' === $this->attribute['sg_description_enable'];

		if ( $enable ) {
			$description = wp_kses_post( $this->attribute['sg_description'] );
			$content     = '<div class="heading-section-description">' . $description . '</div>';
		}

		return $content;
	}

	/**
	 * Render Separator
	 *
	 * @return mixed
	 */
	private function render_separator() {
		$content = '';
		$enable  = 'yes' === $this->attribute['sg_separator_enable'];

		if ( $enable ) {
			$image_separator = null;
			$style           = esc_attr( $this->attribute['sg_separator_style'] );

			if ( 'custom' === $style ) {
				$image_size      = $this->attribute['sg_separator_image_size_imagesize_size'];
				$image_separator = $this->render_image_element( $this->attribute['sg_separator_image'], $image_size );
			}

			$content = '<div class="heading-section-separator"><div class="separator-wrapper style-' . $style . '">' . $image_separator . '</div></div>';
		}

		return $content;
	}

	/**
	 * Render Shadow
	 *
	 * @return mixed
	 */
	private function render_shadow() {
		$content = '';
		$enable  = 'yes' === $this->attribute['sg_shadow_enable'];

		if ( $enable ) {
			$shadow  = esc_attr( $this->attribute['sg_shadow_content'] );
			$content = '<span class="shadow-text">' . $shadow . '</span>';
		}

		return $content;
	}
}
