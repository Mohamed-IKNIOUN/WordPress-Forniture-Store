<?php
/**
 * Gallery View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Gallery_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Gallery_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$layout_type        = ! empty( $this->attribute['sg_setting_layout'] ) ? 'layout-' . esc_attr( $this->attribute['sg_setting_layout'] ) : esc_attr( $this->attribute['sg_setting_layout'] );
		$item_loadmore      = ! empty( $this->attribute['sg_loadmore_item_show']['size'] ) && 'yes' === $this->attribute['sg_loadmore_enable'] ? esc_attr( $this->attribute['sg_loadmore_item_show']['size'] ) : '0';
		$item_show          = esc_attr( $this->attribute['sg_setting_item_show']['size'] );
		$grid_type          = esc_attr( $this->attribute['sg_setting_grid'] );
		$animation_duration = esc_attr( $this->attribute['sg_setting_duration']['size'] );
		$no_more_text       = esc_attr( $this->attribute['sg_loadmore_nomore_text'] );
		$item_list          = $this->get_item_list();
		$current_loaded     = count( $item_list ) > $item_show ? $item_show : count( $item_list );

		$output =
		$this->render_filter() . '
            <div class="gallery-items">' . $this->render_items( $item_list, $item_show ) . '</div>
            <div class="load-more-items">' . $this->render_load_more() . '</div>';

		return $this->render_wrapper(
			'gallery',
			$output,
			array( $layout_type ),
			array(
				'grid'               => $grid_type,
				'id'                 => $this->unique_id,
				'per-page'           => $item_show,
				'load-more'          => $item_loadmore,
				'current-loaded'     => $current_loaded,
				'count-items'        => count( $item_list ),
				'animation-duration' => $animation_duration,
				'no-more'            => $no_more_text,
				'items'              => $this->convert_list( $item_list ),
			)
		);
	}

	/**
	 * Render Filter
	 *
	 * @return mixed
	 */
	private function render_filter() {
		$filter        = null;
		$filter_list   = $this->attribute['sg_filter_list'];
		$filter_type   = esc_attr( $this->attribute['sg_setting_filter'] );
		$all_label     = esc_attr( $this->attribute['sg_filter_all_label'] );
		$filter_enable = esc_attr( $this->attribute['sg_filter_enable'] );
		$placeholder   = esc_attr( $this->attribute['st_search_form_placeholder'] );

		if ( 'yes' === $filter_enable ) {
			$list_filter = '<li class="jkit-gallery-control active" data-filter="*">' . $all_label . '</li>';

			foreach ( $filter_list as $list ) {
				$filter_id   = $this->get_filter_id( $list['sg_filter_list_name'] );
				$list_filter = $list_filter . '<li class="jkit-gallery-control" data-filter=".jkit-gcf-' . $filter_id . '">' . esc_attr( $list['sg_filter_list_name'] ) . '</li>';
			}

			if ( 'search' === $filter_type ) {
				$icon_position = esc_attr( $this->attribute['st_search_control_icon_position'] );

				if ( 'before' === $icon_position ) {
					$icon = $this->render_icon_element( $this->attribute['st_search_control_icon'] ) . '<span>' . $all_label . '</span>';
				} else {
					$icon = '<span>' . $all_label . '</span>' . $this->render_icon_element( $this->attribute['st_search_control_icon'] );
				}

				$filter =
				'<div class="search-filters-wrap">
                    <div class="filter-wrap">
                        <button id="search-filter-trigger" class="search-filter-trigger icon-position-' . $icon_position . '">' . $icon . '</button>
                        <ul class="search-filter-controls">' . $list_filter . '</ul>
                    </div>
                    <form class="jkit-gallery-search-box" id="jkit-gallery-search-box" autocomplete="off">
                        <input type="text" id="jkit-gallery-search-box-input" name="jkit-frontend-search" placeholder="' . $placeholder . '">
                    </form>
                </div>';
			} else {
				$filter = '<div class="filter-controls"><ul>' . $list_filter . '</ul></div>';
			}
		}

		return $filter;
	}

	/**
	 * Get Item List
	 */
	private function get_item_list() {
		$items          = array();
		$image_size     = esc_attr( $this->attribute['sg_gallery_image_size_imagesize_size'] );
		$layout_type    = esc_attr( $this->attribute['sg_setting_layout'] );
		$link_to        = esc_attr( $this->attribute['sg_setting_link_to'] );
		$gallery_enable = $this->attribute['sg_gallery_enable'];
		$gallery_list   = $this->attribute['sg_gallery_list'];

		if ( 'yes' === $gallery_enable ) {
			foreach ( $gallery_list as $list ) {
				$item_title       = esc_attr( $list['sg_gallery_list_item_name'] );
				$filter_id        = ! empty( $list['sg_gallery_list_control_name'] ) ? $this->add_filter_id( $list['sg_gallery_list_control_name'] ) : '';
				$media_url        = ! empty( $image_attachment[0] ) ? $image_attachment[0] : $list['sg_gallery_list_image']['url'];
				$enable_video     = 'yes' === $list['sg_gallery_list_enable_video'];
				$lightbox_caption = 'yes' === $this->attribute['sg_setting_popup_caption'] ? 'data-elementor-lightbox-title="' . $item_title . '"' : '';
				$category         = 'yes' === $list['sg_gallery_list_enable_category'] ? '<span>' . esc_attr( $list['sg_gallery_list_category'] ) . '</span>' : '';
				$price_rating     = $this->render_price_rating( $list );
				$caption          = $this->render_caption( $list );
				$thumbnail        = null;

				$media_url_attribute = array(
					'url'               => $media_url,
					'is_external'       => 'yes' === $this->attribute['sg_setting_link_media_open_tab'] ? 'on' : 'off',
					'nofollow'          => 'yes' === $this->attribute['sg_setting_link_media_nofollow'] ? 'on' : 'off',
					'custom_attributes' => $this->attribute['sg_setting_link_media_attribute'],
				);

				$image = $this->render_image_element( $list['sg_gallery_list_image'], $image_size, null, null, $item_title );

				if ( 'card' === $layout_type ) {
					if ( $enable_video ) {
						$video_link = null;
						$video_url  = esc_url( $list['sg_gallery_list_video_link']['url'] );
						$video_icon = '<div class="video-icon-bg">' . $this->render_icon_element( $list['sg_gallery_list_video_icon'] ) . '</div>';

						if ( 'lightbox' === $list['sg_gallery_list_video_to'] ) {
							$video_link = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $video_icon, 'data-elementor-open-lightbox="yes" data-elementor-lightbox-video="' . $video_url . '" data-elementor-lightbox-slideshow="jkit_gallery_lightbox_' . $this->unique_id . '" ' . $lightbox_caption );
						} else {
							$video_link = $this->render_url_element( $list['sg_gallery_list_video_link'], null, 'gallery-link', $video_icon );
						}

						$thumbnail = $image .
							'<div class="video-wrap">' . $video_link . '</div>
							<div class="caption-wrap search-hover-bg style-overlay">
								<div class="caption-head">' . $price_rating . '</div>
								<div class="caption-category">' . $category . '</div>
							</div>';
					} else {
						$buttons   = $this->render_button( $list );
						$thumbnail = $image .
							'<div class="caption-wrap search-hover-bg style-overlay">
								<div class="caption-head">' . $price_rating . '</div>
								<div class="caption-button">' . $buttons . '</div>
								<div class="caption-category">' . $category . '</div>
							</div>';
					}
				} else {
					$thumbnail = $image;
				}

				switch ( $link_to ) {
					case 'media':
						if ( 'overlay' === $layout_type ) {
							$caption = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $caption, 'data-elementor-open-lightbox="no"' );
						} else {
							$thumbnail = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $thumbnail, 'data-elementor-open-lightbox="no"' );
						}

						break;
					case 'link':
						if ( 'overlay' === $layout_type ) {
							$caption = $this->render_url_element( $list['sg_gallery_list_link'], null, 'gallery-link', $caption, 'data-elementor-open-lightbox="no"' );
						} else {
							$thumbnail = $this->render_url_element( $list['sg_gallery_list_link'], null, 'gallery-link', $thumbnail, 'data-elementor-open-lightbox="no"' );
						}

						break;
					case 'lightbox':
						if ( 'overlay' === $layout_type ) {
							$caption = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $caption, 'data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="jkit_gallery_lightbox_' . $this->unique_id . '" ' . $lightbox_caption );
						} else {
							$thumbnail = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $thumbnail, 'data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="jkit_gallery_lightbox_' . $this->unique_id . '" ' . $lightbox_caption );
						}

						break;
					default:
						break;
				}

				$items[] = preg_replace(
					'~[\r\n\s]+~',
					' ',
					'<div class="gallery-item-wrap ' . $filter_id . '">
                    <div class="grid-item"><div class="thumbnail-wrap">' . $thumbnail . '</div>' . $caption . '</div>
                </div>'
				);
			}
		}

		return $items;
	}

	/**
	 * Render Items
	 *
	 * @param array $list Item.
	 * @param int   $count Count Item.
	 */
	private function render_items( $list, $count ) {
		$items = '';

		foreach ( $list as $key => $item ) {
			if ( $key >= $count ) {
				break;
			}

			$items = $items . $item;
		}

		return $items;
	}

	/**
	 * Convert List
	 *
	 * @param array $list Item.
	 */
	private function convert_list( $list ) {
		return htmlspecialchars( wp_json_encode( $list ), ENT_QUOTES, 'UTF-8' );
	}

	/**
	 * Render Button
	 *
	 * @param array $list Item.
	 */
	private function render_button( $list ) {
		$buttons          = null;
		$enable_video     = 'yes' === $list['sg_gallery_list_enable_video'];
		$lightbox_caption = 'yes' === $this->attribute['sg_setting_popup_caption'] ? 'data-elementor-lightbox-title="' . esc_attr( $list['sg_gallery_list_item_name'] ) . '"' : '';
		$enable_lightbox  = 'yes' === $list['sg_gallery_list_enable_lightbox'];
		$enable_link      = 'yes' === $list['sg_gallery_list_enable_link'];
		$link_to          = $this->attribute['sg_setting_link_to'];
		$image_size       = $this->attribute['sg_gallery_image_size_imagesize_size'];
		$image_attachment = ! empty( $list['sg_gallery_list_image']['id'] ) ? wp_get_attachment_image_src( $list['sg_gallery_list_image']['id'], $image_size ) : '';
		$media_url        = ! empty( $image_attachment[0] ) ? $image_attachment[0] : $list['sg_gallery_list_image']['url'];
		$list_link        = $list['sg_gallery_list_link'];
		$lightbox_icon    = $this->render_icon_element( $this->attribute['sg_setting_icon_lightbox'] );
		$link_icon        = $this->render_icon_element( $this->attribute['sg_setting_icon_link'] );

		$media_url_attribute = array(
			'url'               => $media_url,
			'is_external'       => 'yes' === $this->attribute['sg_setting_link_media_open_tab'] ? 'on' : 'off',
			'nofollow'          => 'yes' === $this->attribute['sg_setting_link_media_nofollow'] ? 'on' : 'off',
			'custom_attributes' => $this->attribute['sg_setting_link_media_attribute'],
		);

		if ( 'button' === $link_to ) {
			$buttons = '<div class="item-buttons">';

			if ( $enable_lightbox && ! $enable_video ) {
				$buttons = $buttons . $this->render_url_element( $media_url_attribute, null, 'gallery-link', '<span class="item-icon-inner">' . $lightbox_icon . '</span>', 'data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="jkit_gallery_lightbox_' . $this->unique_id . '" ' . $lightbox_caption );
			}

			if ( $enable_link && ! $enable_video ) {
				$buttons = $buttons . $this->render_url_element( $list_link, null, 'gallery-link', '<span class="item-icon-inner">' . $link_icon . '</span>', 'data-elementor-open-lightbox="no"' );
			}

			$buttons = $buttons . '</div>';
		}

		return $buttons;
	}

	/**
	 * Render Caption
	 *
	 * @param array $list Gallery Item.
	 */
	private function render_caption( $list ) {
		$caption          = null;
		$html_tag         = ! empty( $this->attribute['sg_setting_html_tag'] ) ? \Elementor\Utils::validate_html_tag( $this->attribute['sg_setting_html_tag'] ) : 'h5';
		$enable_video     = 'yes' === $list['sg_gallery_list_enable_video'];
		$lightbox_caption = 'yes' === $this->attribute['sg_setting_popup_caption'] ? 'data-elementor-lightbox-title="' . esc_attr( $list['sg_gallery_list_item_name'] ) . '"' : '';
		$category         = 'yes' === $list['sg_gallery_list_enable_category'] ? '<span>' . esc_attr( $list['sg_gallery_list_category'] ) . '</span>' : '';
		$layout_type      = $this->attribute['sg_setting_layout'];
		$price_rating     = $this->render_price_rating( $list );
		$image_size       = $this->attribute['sg_gallery_image_size_imagesize_size'];
		$image_attachment = ! empty( $list['sg_gallery_list_image']['id'] ) ? wp_get_attachment_image_src( $list['sg_gallery_list_image']['id'], $image_size ) : '';
		$media_url        = ! empty( $image_attachment[0] ) ? $image_attachment[0] : $list['sg_gallery_list_image']['url'];
		$title            = esc_attr( $list['sg_gallery_list_item_name'] );
		$content          = wp_kses_post( $list['sg_gallery_list_content'] );

		$media_url_attribute = array(
			'url'               => $media_url,
			'is_external'       => 'yes' === $this->attribute['sg_setting_link_media_open_tab'] ? 'on' : 'off',
			'nofollow'          => 'yes' === $this->attribute['sg_setting_link_media_nofollow'] ? 'on' : 'off',
			'custom_attributes' => $this->attribute['sg_setting_link_media_attribute'],
		);

		switch ( $layout_type ) {
			case 'overlay':
				if ( $enable_video ) {
					$link      = null;
					$url       = esc_url( $list['sg_gallery_list_video_link']['url'] );
					$animation = ! empty( $this->attribute['sg_setting_hover'] ) ? 'overlay-' . esc_attr( $this->attribute['sg_setting_hover'] ) : '';
					$link_icon = '<div class="video-icon-bg">' . $this->render_icon_element( $list['sg_gallery_list_video_icon'] ) . '</div>';

					if ( 'lightbox' === $list['sg_gallery_list_video_to'] ) {
						$link = $this->render_url_element( $media_url_attribute, null, 'gallery-link', $link_icon, 'data-elementor-open-lightbox="yes" data-elementor-lightbox-video="' . $url . '" data-elementor-lightbox-slideshow="jkit_gallery_lightbox_' . $this->unique_id . '" ' . $lightbox_caption );
					} else {
						$link = $this->render_url_element( $list['sg_gallery_list_video_link'], null, 'gallery-link', $link_icon );
					}

					$caption =
					'<div class="video-wrap">' . $link . '</div>
                    <div class="caption-wrap style-overlay' . ' ' . $animation . '">
                        <div class="item-hover-bg"></div>
                        <div class="caption-head">' . $price_rating . '</div>
                        <div class="caption-category">' . $category . '</div>
                    </div>';
				} else {
					$animation = ! empty( $this->attribute['sg_setting_hover'] ) ? 'overlay-' . esc_attr( $this->attribute['sg_setting_hover'] ) : '';
					$buttons   = $this->render_button( $list );
					$caption   =
					'<div class="caption-wrap style-overlay ' . $animation . '">
                        <div class="item-hover-bg"></div>
                        <div class="item-caption-over">
                            <' . $html_tag . ' class="item-title">' . $title . '</' . $html_tag . '>
                            <div class="item-content">' . $content . '</div>' . $buttons . '
                        </div>
                        <div class="caption-head">' . $price_rating . '</div>
                        <div class="caption-category">' . $category . '</div>
                    </div>';
				}

				break;
			case 'card':
			default:
				$caption =
				'<div class="caption-wrap style-card">
                    <div class="item-caption-over">
                        <' . $html_tag . ' class="item-title">' . $title . '</' . $html_tag . '>
                        <div class="item-content">' . $content . '</div>
                    </div>
                </div>';
				break;
		}

		return $caption;
	}

	/**
	 * Render Price Rating
	 *
	 * @param array $list Gallery Item.
	 */
	private function render_price_rating( $list ) {
		$output         = '';
		$enable_price   = esc_attr( $list['sg_gallery_list_enable_price'] );
		$enable_rating  = esc_attr( $list['sg_gallery_list_enable_rating'] );
		$list_price     = esc_attr( $list['sg_gallery_list_price'] );
		$list_rating    = esc_attr( $list['sg_gallery_list_rating']['size'] );
		$list_star_full = $this->render_icon_element( $list['sg_gallery_list_rating_icon_full'] );
		$list_star_half = $this->render_icon_element( $list['sg_gallery_list_rating_icon_half'] );

		if ( 'yes' === $enable_price ) {
			$output = $output . '<div class="item-price">' . $list_price . '</div>';
		}

		if ( 'yes' === $enable_rating ) {
			$rating        = '';
			$rating_number = floatval( $list_rating );
			$rating_round  = floor( $rating_number );

			for ( $i = 0; $i < $rating_round; $i++ ) {
				$rating = $rating . '<li>' . $list_star_full . '</li>';
			}

			if ( ( $rating_number - $rating_round ) > 0 ) {
				$rating = $rating . '<li>' . $list_star_half . '</li>';
			}

			$output = $output . '<div class="item-rating">' . $rating . ' ' . $rating_number . '</div>';
		}

		return $output;
	}

	/**
	 * Render Load More
	 */
	private function render_load_more() {
		$load_more = null;
		$label     = null;

		$loadmore_enable        = esc_attr( $this->attribute['sg_loadmore_enable'] );
		$loadmore_icon_position = esc_attr( $this->attribute['sg_loadmore_icon_position'] );
		$loadmore_text          = esc_attr( $this->attribute['sg_loadmore_button_text'] );
		$loadmore_icon          = $this->render_icon_element( $this->attribute['sg_loadmore_button_icon'] );

		if ( 'yes' === $loadmore_enable ) {
			if ( 'before' === $loadmore_icon_position ) {
				$label =
				'<span class="load-more-icon icon-position-before" aria-hidden="true">' . $loadmore_icon . '</span>
                <span class="load-more-text">' . $loadmore_text . '</span>';
			} else {
				$label =
				'<span class="load-more-text">' . $loadmore_text . '</span>
                <span class="load-more-icon icon-position-after" aria-hidden="true">' . $loadmore_icon . '</span>';
			}

			$link_attr = array(
				'url'               => '#',
				'is_external'       => '',
				'nofollow'          => '',
				'custom_attributes' => 'aria-label|Load More Button',
			);

			$load_more = '<div class="jkit-gallery-loadmore">' . $this->render_url_element( $link_attr, null, 'jkit-gallery-load-more', '<span class="btn-loader"></span>' . $label ) . '</div>';
		}

		return $load_more;
	}

	/**
	 * Get filter ID
	 *
	 * @param string $text Filter text.
	 */
	private function get_filter_id( $text ) {
		$filter_id = wp_strip_all_tags( $text );
		$filter_id = preg_replace( '/\p{P}/', '', $filter_id );
		$filter_id = str_replace( array( ' ', '$', '.', '#', '"', '\'' ), '-', $filter_id );

		if ( ! mb_check_encoding( $filter_id, 'UTF-8' ) ) {
			$filter_id = htmlentities( $filter_id, ENT_QUOTES | ENT_IGNORE, 'UTF-8' );
		}

		return $filter_id;
	}

	/**
	 * Add filter ID
	 *
	 * @param string $text Filter text.
	 */
	private function add_filter_id( $text ) {
		$class = '';
		$text  = explode( ',', $text );

		foreach ( $text as $value ) {
			$class .= ' jkit-gcf-' . $this->get_filter_id( $value );
		}

		return $class;
	}
}
