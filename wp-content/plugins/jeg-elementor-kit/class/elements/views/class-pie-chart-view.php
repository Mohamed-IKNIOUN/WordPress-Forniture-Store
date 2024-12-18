<?php
/**
 * Pie Chart View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Pie_Chart_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Pie_Chart_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$output               = null;
		$enable_content       = 'yes' === $this->attribute['sg_content_enable'];
		$style                = $this->attribute['sg_content_pie_chart_type'];
		$hover_animation      = ! empty( $this->attribute['st_content_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_content_hover_animation'] ) : '';
		$cutout               = esc_attr( $this->attribute['st_chart_cutout']['size'] );
		$percent              = esc_attr( $this->attribute['sg_content_percentage']['size'] );
		$color_type           = esc_attr( $this->attribute['st_chart_bar_color_type'] );
		$bar_color            = esc_attr( $this->attribute['st_chart_bar_color'] );
		$bar_background_color = esc_attr( $this->attribute['st_chart_bar_background'] );
		$bar_gradient1        = esc_attr( $this->attribute['st_chart_bar_gradient_color1'] );
		$bar_gradient2        = esc_attr( $this->attribute['st_chart_bar_gradient_color2'] );
		$animation_duration   = esc_attr( $this->attribute['sg_content_animation_duration']['size'] );
		$content_type         = esc_attr( $this->attribute['sg_content_chart'] );

		if ( $enable_content ) {
			if ( 'static' === $style ) {
				$output = $this->render_chart();
				$output = $output . $this->render_content();
			} elseif ( 'flip' === $style ) {
				$output =
				'<div class="chart-front">
                    <div class="chart-in">' . $this->render_chart() . '</div>
                </div>
                <div class="content-back">' . $this->render_content() . '</div>';
			} elseif ( 'float_right' === $style ) {
				$output =
				'<div class="chart-float content-right">
                    <div class="chart-diagram">' . $this->render_chart() . '</div>
                    <div class="chart-content">' . $this->render_content() . '</div>
                </div>';
			} elseif ( 'float_left' === $style ) {
				$output =
				'<div class="chart-float content-left">
                    <div class="chart-content">' . $this->render_content() . '</div>
                    <div class="chart-diagram">' . $this->render_chart() . '</div>
                </div>';
			}
		} else {
			$output = $this->render_chart();
		}

		return $this->render_wrapper(
			'pie-chart',
			$output,
			array( 'style-' . $style, $hover_animation ),
			array(
				'cutout'             => $cutout,
				'percent'            => $percent,
				'color-type'         => $color_type,
				'color'              => $bar_color,
				'bg-color'           => $bar_background_color,
				'gradient1'          => $bar_gradient1,
				'gradient2'          => $bar_gradient2,
				'animation-duration' => $animation_duration,
				'content-type'       => $content_type,
			)
		);
	}

	/**
	 * Render chart
	 */
	private function render_chart() {
		$content      = null;
		$size         = esc_attr( $this->attribute['st_chart_size']['size'] );
		$content_type = esc_attr( $this->attribute['sg_content_chart'] );

		if ( 'yes' === $this->attribute['st_chart_size_responsive_enable'] ) {
			$size = esc_attr( $this->attribute['st_chart_size_enable_responsive']['size'] );
		}

		if ( 'percentage' === $content_type ) {
			$content = '0%';
		} elseif ( 'icon' === $content_type ) {
			$icon_type = esc_attr( $this->attribute['sg_content_icon_type'] );

			if ( 'icon' === $icon_type ) {
				$content = $this->render_icon_element( $this->attribute['sg_content_icon_icon'] );
			} elseif ( 'image' === $icon_type ) {
				$image_size = $this->attribute['sg_content_image_size_imagesize_size'];
				$content    = $this->render_image_element( $this->attribute['sg_content_icon_image'], $image_size );
			}
		}

		$chart =
		'<div class="pie-chart-wrapper">
            <span class="pie-chart-content">' . $content . '</span>
            <canvas class="main-canvas" height="' . $size . '" width="' . $size . '"></canvas>
            <canvas class="background-canvas" height="' . $size . '" width="' . $size . '"></canvas>
        </div>';

		return $chart;
	}

	/**
	 * Render content
	 */
	private function render_content() {
		$title       = esc_attr( $this->attribute['sg_content_title'] );
		$description = esc_attr( $this->attribute['sg_content_description'] );
		$html_tag    = \Elementor\Utils::validate_html_tag( $this->attribute['sg_content_title_html_tag'] );
		$html_tag    = isset( $html_tag ) ? $html_tag : 'h2';

		$content = '<' . $html_tag . ' class="pie-chart-title">' . $title . '</' . $html_tag . '><div class="pie-chart-description"><p>' . $description . '</p></div>';

		return $content;
	}
}
