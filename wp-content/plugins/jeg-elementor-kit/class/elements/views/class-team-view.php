<?php
/**
 * Team View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Team_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Team_View extends View_Abstract {
	/**
	 * Build team element
	 */
	public function build_content() {
		$output                = null;
		$style                 = esc_attr( $this->attribute['sg_member_style'] );
		$overlay_style         = 'overlay' === $style ? 'overlay-' . esc_attr( $this->attribute['sg_member_overlay_style'] ) : '';
		$border_bottom         = $this->render_border_bottom();
		$image_size            = $this->attribute['sg_member_image_size_imagesize_size'];
		$image                 = $this->render_image_element( $this->attribute['sg_member_image'], $image_size, null, null, esc_attr( $this->attribute['sg_member_name'] ) );
		$image                 = 'yes' === $this->attribute['st_image_overlay_enable'] && ( 'default' === $style || 'hover-social' === $style || 'title-horizontal' === $style ) ? $image . '<div class="image-hover-bg"></div>' : $image;
		$hover_animation       = ! empty( $this->attribute['st_content_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_content_hover_animation'] ) : '';
		$image_hover_animation = ! empty( $this->attribute['st_image_hover_animation'] ) ? 'elementor-animation-' . esc_attr( $this->attribute['st_image_hover_animation'] ) : '';

		$profile_card_class = 'profile-card';

		if ( 'gradient' === $this->attribute['st_content_normal_background_background_background'] || 'gradient' === $this->attribute['st_content_hover_background_background_background'] ) {
			$profile_card_class .= ' hover-gradient';
		}

		if ( 'overlay' === $style ) {
			$overlay_alignment = esc_attr( $this->attribute['sg_member_overlay_content_alignment'] );

			$profile_card_class .= ' ' . $hover_animation;

			$output =
			'<div class="' . $profile_card_class . '">' . $image . '
                <div class="hover-area alignment-' . $overlay_alignment . '">' . $this->render_team() . '</div>
            </div>';
		} elseif ( 'title-horizontal' === $style ) {
			$output = '<div class="' . $profile_card_class . '">' . $image . $this->render_team() . '</div>';
		} else {
			$image       = 'yes' === $this->attribute['sg_popup_show'] ? '<a href="#jkit-team-modal-' . $this->unique_id . '" class="jkit-team-modal" data-effect="mfp-move-horizontal">' . $image . '</a>' : $image;
			$image_class = 'yes' === $this->attribute['sg_popup_show'] ? 'data-toggle="modal" data-target="jkit-team-modal-' . $this->unique_id . '"' : '';

			$profile_card_class .= ' ' . $hover_animation;

			$output =
			'<div class="profile-box">
                <div class="' . $profile_card_class . '">
                    <div class="profile-header jkit-team-img ' . $image_hover_animation . '"' . $image_class . '>' . $image . '</div>
                    ' . $this->render_team() . '
                    ' . $border_bottom . '
                </div>
            </div>';
		}

		return $this->render_wrapper( 'team', $output . $this->render_popup(), array( 'style-' . $style, $overlay_style ) );
	}

	/**
	 * Render content
	 *
	 * @return string
	 */
	private function render_team() {
		$name        = 'yes' === $this->attribute['sg_popup_show'] ? '<a href="#jkit-team-modal-' . $this->unique_id . '" class="jkit-team-modal" data-effect="mfp-move-horizontal">' . esc_attr( $this->attribute['sg_member_name'] ) . '</a>' : esc_attr( $this->attribute['sg_member_name'] );
		$description = 'yes' === $this->attribute['sg_member_show_description'] ? '<p class="profile-content">' . esc_attr( $this->attribute['sg_member_description'] ) . '</p>' : '';
		$position    = esc_attr( $this->attribute['sg_member_position'] );
		$html_tag    = esc_attr( $this->attribute['sg_member_html_tag'] );
		$style       = esc_attr( $this->attribute['sg_member_style'] );
		$html_tag    = isset( $html_tag ) ? $html_tag : 'h2';
		$html_tag    = \Elementor\Utils::validate_html_tag( $html_tag );
		$social_list = $this->render_social();

		if ( 'default' === $style ) {
			$content =
			'<div class="profile-body">
                <' . $html_tag . ' class="profile-title">' . $name . '</' . $html_tag . '>
                <p class="profile-designation">' . $position . '</p>
                ' . $description . '
            </div>
            <div class="profile-footer">
                <ul class="social-list">' . $social_list . '</ul>
            </div>';
		} elseif ( 'title-horizontal' === $style ) {
			$break   = 'yes' === $this->attribute['st_position_text_break'] && '180' === $this->attribute['st_position_text_direction'] ? 'break-up' : '';
			$content =
			'<div class="profile-body">
                <div class="title-wrapper">
					<p class="profile-designation ' . $break . '">' . $position . '</p>
					' . $description . '
				</div>
				<div class="name-wrapper">
					<' . $html_tag . ' class="profile-title">' . $name . '</' . $html_tag . '>
					<ul class="social-list">' . $social_list . '</ul>
				</div>
            </div>';
		} else {
			$content =
			'<div class="profile-body">
                <' . $html_tag . ' class="profile-title">' . $name . '</' . $html_tag . '>
                <p class="profile-designation">' . $position . '</p>
                ' . $description . '
                <ul class="social-list">' . $social_list . '</ul>
            </div>';
		}

		return $content;
	}

	/**
	 * Render pop up
	 */
	private function render_popup() {
		$popup = null;

		if ( 'yes' === $this->attribute['sg_popup_show'] ) {
			$image_size  = $this->attribute['sg_member_image_size_imagesize_size'];
			$image       = $this->render_image_element( $this->attribute['sg_member_image'], $image_size, null, null, esc_attr( $this->attribute['sg_member_name'] ) );
			$has_img     = ! empty( $image ) ? 'has-img' : '';
			$phone       = ! empty( $this->attribute['sg_popup_phone'] ) ? '<li><strong>' . esc_html__( 'Phone', 'jeg-elementor-kit' ) . ':</strong><a href="tel:' . preg_replace( '/[^0-9\-\_\+]*/', '', $this->attribute['sg_popup_phone'] ) . '"> ' . esc_attr( $this->attribute['sg_popup_phone'] ) . '</a></li>' : '';
			$email       = ! empty( $this->attribute['sg_popup_email'] ) ? '<li><strong>' . esc_html__( 'Email', 'jeg-elementor-kit' ) . ':</strong><a href="mailto:' . esc_attr( $this->attribute['sg_popup_email'] ) . '"> ' . esc_attr( $this->attribute['sg_popup_email'] ) . '</a></li>' : '';
			$description = 'yes' === $this->attribute['sg_member_show_description'] ? '<div class="team-modal-description">' . esc_attr( $this->attribute['sg_member_description'] ) . '</div>' : '';
			$name        = esc_attr( $this->attribute['sg_member_name'] );
			$position    = esc_attr( $this->attribute['sg_member_position'] );
			$html_tag    = \Elementor\Utils::validate_html_tag( $this->attribute['sg_member_html_tag'] );
			$close_icon  = $this->render_icon_element( $this->attribute['sg_popup_close_icon'] );
			$social_list = $this->render_social();

			$popup =
			'<div class="jkit-modal-popup content mfp-hide" id="jkit-team-modal-' . $this->unique_id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="jkit-modal-dialog">
                    <div class="team-modal-content">
                        <button type="button" class="team-modal-close">' . $close_icon . '</button>
                        <div class="team-modal-body">
                            <div class="team-modal-img">' . $image . ' </div>
                            <div class="team-modal-info ' . $has_img . '">
                                <' . $html_tag . ' class="team-modal-title">' . $name . '</' . $html_tag . '>
                                <p class="team-modal-position">' . $position . '</p>
                                ' . $description . '
                                <ul class="team-modal-list">
                                    ' . $phone . '
                                    ' . $email . '
                                </ul>
                                <ul class="social-list">' . $social_list . '</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div id="jkit-team-swal-modal-' . $this->unique_id . '" class="jkit-team-swal-modal"></div>';
		}

		return $popup;
	}

	/**
	 * Render social icon profiles
	 */
	private function render_social() {
		$social_list = '';

		if ( 'yes' === $this->attribute['sg_social_show'] ) {
			foreach ( $this->attribute['sg_social_icon'] as $social ) {
				$id          = 'elementor-repeater-item-' . esc_attr( $social['_id'] );
				$class       = 'social-icon ' . $id;
				$social_icon = $this->render_icon_element( $social['sg_social_icon'] );
				$social_url  = $this->render_url_element( $social['sg_social_link'], null, null, $social_icon, 'aria-label="social-icon"' );

				if ( 'gradient' === $social['sg_social_normal_background_background_background'] || 'gradient' === $social['sg_social_hover_background_background_background'] ) {
					$class .= ' hover-gradient';
				}

				$social_list = $social_list . '<li class="' . $class . '">' . $social_url . '</li>';
			}
		}

		return $social_list;
	}

	/**
	 * Render Border Bottom
	 *
	 * @return mixed
	 */
	private function render_border_bottom() {
		$border_bottom = null;

		if ( 'yes' === $this->attribute['sg_member_enable_hover_border_bottom'] ) {
			$border_bottom = '<div class="border-bottom ' . esc_attr( $this->attribute['sg_member_hover_direction'] ) . '"></div>';
		}

		return $border_bottom;
	}
}
