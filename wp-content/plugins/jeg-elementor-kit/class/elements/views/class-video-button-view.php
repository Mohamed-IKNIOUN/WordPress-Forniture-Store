<?php
/**
 * Video Button View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Video_Button_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Video_Button_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$is_self_hosted = ( 'self_hosted' === $this->attribute['sg_video_type'] );
		$url            = $is_self_hosted ? esc_url( '#jkit_video_button_' . $this->unique_id ) : esc_url( $this->attribute['sg_video_url'] );
		$class          = 'jkit-video-popup-btn';

		if ( 'yes' === $this->attribute['sg_video_glow_enable'] ) {
			$class .= ' glow-enable';
		}

		$content = $this->render_content();

		if ( 'gradient' === $this->attribute['st_button_normal_background_background_background'] || 'gradient' === $this->attribute['st_button_hover_background_background_background'] ) {
			$class  .= ' hover-gradient';
			$content = '<span>' . $content . '</span>';
		}

		$content = $this->render_url_element(
			array(
				'url'               => $url,
				'is_external'       => 'off',
				'nofollow'          => 'off',
				'custom_attributes' => '',
			),
			null,
			$class,
			$content,
			'aria-label="video-button"'
		);

		$data_attr = $this->render_data();

		if ( $is_self_hosted ) {
			$content .= $this->render_self_hosted_video( $data_attr );
		}

		return $this->render_wrapper( 'video-button', $content, array(), $data_attr );
	}

	/**
	 * Render self hosted video
	 *
	 * @return mixed
	 */
	private function render_self_hosted_video( $data_attr ) {
		$video_metadata = wp_get_attachment_metadata( $this->attribute['sg_video_hosted']['id'] );
		$video_attr     = sprintf(
			'%s %s %s %s %s %s %s %s',
			$data_attr['autoplay'] ? 'autoplay' : '',
			$data_attr['controls'] ? 'controls' : '',
			$data_attr['loop'] ? 'loop' : '',
			$data_attr['mute'] ? 'muted' : '',
			isset( $video_metadata['height'] ) ? 'height=' . esc_attr( $video_metadata['height'] ) : '',
			isset( $video_metadata['width'] ) ? 'width=' . esc_attr( $video_metadata['width'] ) : '',
			( isset( $this->attribute['sg_video_hosted']['url'] ) && ! empty( $this->attribute['sg_video_hosted']['url'] ) ) ? 'src=' . esc_url( $this->attribute['sg_video_hosted']['url'] ) : '',
			( isset( $this->attribute['sg_video_hosted_poster']['url'] ) && ! empty( $this->attribute['sg_video_hosted_poster']['url'] ) ) ? 'poster=' . esc_attr( $this->attribute['sg_video_hosted_poster']['url'] ) : ''
		);

		$video   = '<video ' . esc_attr( $video_attr ) . '></video>';
		$content = '<template id="jkit_video_button_' . $this->unique_id . '" class="jkit-video-self-hosted mfp-hide">' . $video . '</template>';

		return $content;
	}

	/**
	 * Render content
	 *
	 * @return mixed
	 */
	private function render_content() {
		$icon    = null;
		$text    = null;
		$content = null;

		$button_type = $this->attribute['sg_video_button_style'];
		$icon_enable = $this->attribute['sg_video_button_icon_enable'];
		$position    = $this->attribute['sg_video_button_icon_position'];

		if ( ( 'icon' === $button_type || 'both' === $button_type ) && 'yes' === $icon_enable ) {
			$icon = $this->render_icon_element( $this->attribute['sg_video_button_icon'] );
		}

		if ( ( 'text' === $button_type || 'both' === $button_type ) ) {
			$text = '<span>' . esc_attr( $this->attribute['sg_video_button_title'] ) . '</span>';
		}

		if ( 'both' === $button_type && 'before' === $position ) {
			$content = $icon . $text;
		} else {
			$content = $text . $icon;
		}

		$content = '<span class="icon-position-' . $position . '">' . $content . '</span>';

		return $content;
	}

	/**
	 * Get URL with parameters
	 *
	 * @return string
	 */
	private function render_data() {
		$type = $this->attribute['sg_video_type'];
		$data = array(
			'autoplay' => 'yes' === $this->attribute['sg_video_auto_play'] ? '1' : '0',
			'loop'     => 'yes' === $this->attribute['sg_video_loop'] ? '1' : '0',
			'controls' => 'yes' === $this->attribute['sg_video_player_control'] ? '1' : '0',
			'type'     => $type,
			'mute'     => 'yes' === $this->attribute['sg_video_mute'] ? '1' : '0',
		);

		if ( 'youtube' === $type ) {
			$data['start'] = esc_attr( $this->attribute['sg_video_start_time'] ) ? '1' : '0';
			$data['end']   = esc_attr( $this->attribute['sg_video_end_time'] ) ? '1' : '0';
		} else {
			$data['title']     = 'yes' === $this->attribute['sg_video_intro_title'] ? '1' : '0';
			$data['portrait']  = 'yes' === $this->attribute['sg_video_intro_portrait'] ? '1' : '0';
			$data['byline']    = 'yes' === $this->attribute['sg_video_intro_byline'] ? '1' : '0';
			$data['unique-id'] = 'jkit_video_button_' . esc_attr( $this->unique_id );
		}

		return $data;
	}
}
