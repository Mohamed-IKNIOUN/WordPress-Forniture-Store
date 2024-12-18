<?php
/**
 * Countdown View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

use Elementor\Plugin;

/**
 * Class Countdown_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Countdown_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$date           = esc_attr( $this->attribute['sg_content_date'] );
		$label_position = esc_attr( $this->attribute['st_content_label_position'] );
		$due_date       = gmdate( 'Y-m-d\TH:i:s', strtotime( $date ) );
		$data           = array_merge( array( 'due-date' => $due_date ), $this->expired_data() );
		$separator      = 'yes' === $this->attribute['sg_content_separator_enable'] ? 'separator-enable' : '';
		$timer          = '';

		if ( 'yes' === $this->attribute['sg_content_day_enable'] ) {
			$content = '<span class="timer-count timer-loading">0 </span>';

			if ( 'top' === $label_position ) {
				$content = '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_day_label'] ) . '</span>' . $content;
			} else {
				$content = $content . '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_day_label'] ) . '</span>';
			}

			$timer = $timer .
			'<div class="timer-container timer-days">
                <div class="timer-inner-container countdown-inner">
                    <div class="timer-content label-' . $label_position . '">' . $content . '</div>
                </div>
            </div>';
		}

		if ( 'yes' === $this->attribute['sg_content_hour_enable'] ) {
			$content = '<span class="timer-count timer-loading">0 </span>';

			if ( 'top' === $label_position ) {
				$content = '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_hour_label'] ) . '</span>' . $content;
			} else {
				$content = $content . '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_hour_label'] ) . '</span>';
			}

			$timer = $timer .
			'<div class="timer-container timer-hours">
                <div class="timer-inner-container countdown-inner">
                    <div class="timer-content label-' . $label_position . '">' . $content . '</div>
                </div>
            </div>';
		}

		if ( 'yes' === $this->attribute['sg_content_minute_enable'] ) {
			$content = '<span class="timer-count timer-loading">0 </span>';

			if ( 'top' === $label_position ) {
				$content = '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_minute_label'] ) . '</span>' . $content;
			} else {
				$content = $content . '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_minute_label'] ) . '</span>';
			}

			$timer = $timer .
			'<div class="timer-container timer-minutes">
                <div class="timer-inner-container countdown-inner">
                    <div class="timer-content label-' . $label_position . '">' . $content . '</div>
                </div>
            </div>';
		}

		if ( 'yes' === $this->attribute['sg_content_second_enable'] ) {
			$content = '<span class="timer-count timer-loading">0 </span>';

			if ( 'top' === $label_position ) {
				$content = '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_second_label'] ) . '</span>' . $content;
			} else {
				$content = $content . '<span class="timer-title">' . esc_attr( $this->attribute['sg_content_second_label'] ) . '</span>';
			}

			$timer = $timer .
			'<div class="timer-container timer-seconds">
                <div class="timer-inner-container countdown-inner">
                    <div class="timer-content label-' . $label_position . '">' . $content . '</div>
                </div>
            </div>';
		}

		return $this->render_wrapper( 'countdown', $timer, array( $separator ), $data );
	}

	/**
	 * Add expired action data
	 *
	 * @return array
	 */
	private function expired_data() {
		$data = array();
		$type = esc_attr( $this->attribute['sg_expire_type'] );

		$data['expired-type'] = $type;

		if ( 'message' === $type ) {
			$data['expired-title']   = esc_attr( $this->attribute['sg_expire_title'] );
			$data['expired-content'] = esc_attr( $this->attribute['sg_expire_content'] );
		} elseif ( 'redirect' === $type ) {
			$data['redirect-link']  = esc_url( $this->attribute['sg_expire_link'] );
			$data['iframe-content'] = esc_html__( 'Your page will be redirected on frontend', 'jeg-elementor-kit' );
		} elseif ( 'template' === $type ) {
			$template         = Plugin::$instance->frontend->get_builder_content( $this->attribute['sg_expire_template'], true );
			$template         = preg_replace( '~[\r\n\s]+~', ' ', $template );
			$data['template'] = esc_attr( $template );
		}

		return $data;
	}
}
