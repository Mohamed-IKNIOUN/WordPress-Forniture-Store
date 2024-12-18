<?php
/**
 * Jeg News Element Image Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Image;

interface Image_Interface {

	/**
	 * Generate Image HTML tag without predefine size.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function single_image_unwrap( $id, $size );

	/**
	 * Image thumbnail.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail_unwrap( $id, $size );

	/**
	 * Generate image thumbnail HTML tag
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail( $id, $size );

	/**
	 * Generate Image Tag for Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_single_image( $id, $size );

	/**
	 * Generate Image Tag for Lazy Load Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_single_image( $id, $size );

	/**
	 * Generate Image Tag for Lazy Load Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_image( $id, $size );

	/**
	 * HTML tag for Single image.
	 *
	 * @param string $img_src URL of image.
	 * @param string $img_title Title of image.
	 * @param string $img_size Size of image.
	 *
	 * @return string
	 */
	public function single_image( $img_src, $img_title, $img_size );
}
