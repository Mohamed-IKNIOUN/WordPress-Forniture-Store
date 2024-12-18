<?php
/**
 * Progress Bar View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Progress_Bar_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Progress_Bar_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$output             = null;
		$progress_bar       = null;
		$title              = esc_attr( $this->attribute['sg_progress_title'] );
		$percentage         = esc_attr( $this->attribute['sg_progress_percentage']['size'] );
		$animation_duration = esc_attr( $this->attribute['sg_progress_duration']['size'] );

		if ( 'switch' === $this->attribute['sg_progress_style'] ) {
			$progress_bar =
				'<div class="content-group">
                    <div class="skill-bar-content"><span class="skill-title">' . $title . '</span></div>
                    <div class="skill-bar"><div class="skill-track"></div></div>
                </div>
                <div class="number-percentage-wrapper">
                    <span class="number-percentage" data-value="' . $percentage . '" data-animation-duration="' . $animation_duration . '">' . $percentage . '%</span>
                </div>';
		} else {
			$progress_bar =
			'<div class="skill-bar-content"><span class="skill-title">' . $title . '</span></div>
                <div class="skill-bar">
                    <div class="skill-track">
                        ' . $this->render_icon() . '
                        <div class="number-percentage-wrapper">
                            <span class="number-percentage" data-value="' . $percentage . '" data-animation-duration="' . $animation_duration . '">' . $percentage . '%</span>
                        </div>
                    </div>
                </div>';
		}

		$output =
		'<div class="progress-group ' . esc_attr( $this->attribute['sg_progress_style'] ) . '">
            <div class="progress-skill-bar">' . $progress_bar . '</div>
        </div>';

		return $this->render_wrapper( 'progress-bar', $output );
	}

	/**
	 * Render Icon
	 */
	private function render_icon() {
		$icon      = null;
		$icon_html = $this->render_icon_element( $this->attribute['sg_progress_icon'] );

		if ( 'inner-content' === $this->attribute['sg_progress_style'] && ! empty( $icon_html ) ) {
			$icon = '<span class="skill-track-icon">' . $icon_html . '</span>';
		}

		return $icon;
	}
}
