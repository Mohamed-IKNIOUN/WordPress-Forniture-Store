<?php
/**
 * Jeg News Element Background Load Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Image;

/**
 * Class Image Background Load
 */
class Image_Background_Load implements Image_Interface {

	/**
	 * Distance from where image expanded
	 *
	 * @var int
	 */
	private $expand_distance = 700;

	/**
	 * Check if image is a GIF file
	 *
	 * @param string $image_src Image URL.
	 *
	 * @return bool
	 */
	public function is_gif_file( $image_src ) {
		$filetype = wp_check_filetype( $image_src );

		return 'gif' === $filetype['ext'];
	}

	/**
	 * Get image URL.
	 *
	 * @param integer $image_id Image ID.
	 * @param string  $size Size of image.
	 *
	 * @return string
	 */
	public function get_image_url( $image_id, $size ) {
		$image = wp_get_attachment_image_src( $image_id, $size );

		if ( is_array( $image ) ) {
			if ( $this->is_gif_file( $image[0] ) ) {
				$image = wp_get_attachment_image_src( $image_id, 'full' );

				return $image[0];
			} else {
				return $image[0];
			}
		} else {
			return '';
		}
	}

	/**
	 * Get alternate text for image.
	 *
	 * @param integer $id Image ID.
	 *
	 * @return string
	 */
	public function alt_text( $id ) {
		$image = get_post( $id );

		if ( $image ) {
			$image_alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );

			if ( empty( $image_alt ) && ! empty( $image->post_parent ) ) {
				$image_alt = wp_strip_all_tags( get_the_title( $image->post_parent ) );
			}

			return 'title="' . $image_alt . '"';
		} else {
			return '';
		}
	}

	/**
	 * Image for hero content.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function single_hero_image( $id, $size ) {
		$post_thumbnail_id = get_post_thumbnail_id( $id );
		$image             = $this->get_image_url( $post_thumbnail_id, $size );

		$thumbnail = "<div class=\"thumbnail-container thumbnail-background\" data-src=\"{$image}\" >
                        <div class=\"lazyloaded\" data-src=\"{$image}\" style=\"background-image: url($image)\"></div>
                    </div>";

		return $thumbnail;
	}

	/**
	 * Generate Image HTML tag without predefine size.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function single_image_unwrap( $id, $size ) {
		$image_src  = wp_get_attachment_image_src( $id, $size );
		$percentage = round( $image_src[2] / $image_src[1] * 100, 3 );
		$image_url  = $this->get_image_url( $id, $size );

		$thumbnail = '<div class="thumbnail-container animate-lazy thumbnail-background" style="padding-bottom:' . $percentage . '%;">
                        <div class="lazyload" ' . $this->alt_text( $id ) . ' data-bgset="' . $image_url . '" data-expand="' . $this->expand_distance . '"></div>
                      </div>';

		$image = get_post( $id );
		if ( ! empty( $image->post_excerpt ) ) {
			$thumbnail .= '<p class="wp-caption-text">' . $image->post_excerpt . '</p>';
		}

		return $thumbnail;
	}

	/**
	 * Image thumbnail.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail_unwrap( $id, $size ) {
		$post_thumbnail_id = get_post_thumbnail_id( $id );

		return $this->single_image_unwrap( $post_thumbnail_id, $size );
	}

	/**
	 * Generate image thumbnail HTML tag
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail( $id, $size ) {
		$image_size = Image::get_image_sizes( $size );

		$additional_class  = '';
		$image             = '';
		$post_thumbnail_id = '';

		if ( ! has_post_thumbnail( $id ) ) {
			$additional_class = 'no_thumbnail';
		} else {
			$post_thumbnail_id = get_post_thumbnail_id( $id );
			$image             = $this->get_image_url( $post_thumbnail_id, $size );
		}

		$thumbnail = "<div class=\"thumbnail-container animate-lazy thumbnail-background {$additional_class} size-{$image_size['dimension']}\">
                        <div class=\"lazyload\" {$this->alt_text($post_thumbnail_id)} data-bgset=\"$image\" data-expand='{$this->expand_distance}'></div>
                      </div>";

		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_single_image( $id, $size ) {
		$image_size = Image::get_image_size( $size );

		$image     = $this->get_image_url( $id, $size );
		$thumbnail = "<div class=\"thumbnail-container animate-lazy thumbnail-background size-{$image_size['dimension']}\">
                        <div class=\"lazyload\" {$this->alt_text($id)} data-bgset=\"{$image}\" data-expand='{$this->expand_distance}'></div>
                     </div>";

		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Lazy Load Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_single_image( $id, $size ) {
		$image           = get_post( $id );
		$image_size      = wp_get_attachment_metadata( $id );
		$image_dimension = Image::get_image_size( $size );
		$image_url       = $this->get_image_url( $id, $size );

		$thumbnail = "<div class=\"thumbnail-container animate-lazy thumbnail-background size-{$image_dimension['dimension']}\">
                        <div class=\"lazyload\" {$this->alt_text($id)} data-bgset=\"{$image_url}\" data-expand='{$this->expand_distance}' data-full-width=\"{$image_size['width']}\" data-full-height=\"{$image_size['height']}\" alt=\"{$image->post_excerpt}\"></div>
                      </div>";

		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Lazy Load Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_image( $id, $size ) {
		$image_size = Image::get_image_size( $size );

		$additional_class  = '';
		$image             = '';
		$post_thumbnail_id = '';

		if ( ! has_post_thumbnail( $id ) ) {
			$additional_class = 'no_thumbnail';
		} else {
			$post_thumbnail_id = get_post_thumbnail_id( $id );
			$image             = $this->get_image_url( $post_thumbnail_id, $size );
		}

		$thumbnail = "<div class=\"thumbnail-container animate-lazy thumbnail-background size-{$image_size['dimension']} {$additional_class}\">
                        <div class=\"lazyload\" {$this->alt_text($post_thumbnail_id)} data-bgset=\"{$image}\" data-expand='{$this->expand_distance}'></div>
                      </div>";

		return $thumbnail;
	}

	/**
	 * HTML tag for Single image.
	 *
	 * @param string $img_src URL of image.
	 * @param string $img_title Title of image.
	 * @param string $img_size Size of image.
	 *
	 * @return string
	 */
	public function single_image( $img_src, $img_title, $img_size ) {
		if ( $img_size ) {
			return "<div class='thumbnail-container animate-lazy thumbnail-background size-{$img_size}'>
                        <div class=\"lazyload\" data-bgset=\"{$img_src}\"></div>
                    </div>";
		} else {
			return "<img src='{$img_src}' alt='{$img_title}' title='{$img_title}'>";
		}
	}
}
