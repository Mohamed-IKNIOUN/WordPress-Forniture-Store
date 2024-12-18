<?php
/**
 * Customizer Control: Image.
 *
 * Creates a text
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Image control
 */
class Image extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'image';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper image-control type-image" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<# var multiple = ( 1 < data.multiple ) ? true : false #>
				<div class="image-content" data-multiple="{{ multiple }}">

					<# var showImageClass = ( '' === data.value ) ? 'hide-image' : '' #>
					<div class="image-wrapper {{ showImageClass }}">
						<# if ( 1 < data.multiple ) { #>
							<# if ( undefined !== data.imageUrl && Array.isArray( data.imageUrl ) ) { #>
								<# data.imageUrl.forEach( function( element ) { #>
									<div>
										<input type="hidden" name="{{ data.fieldName }}[]" value="{{ element.id }}">
										<img src="{{ element.url }}">
										<span class='remove'></span>
									</div>
								<# } ) #>
							<# } #>
						<# } else { #>
							<img src="{{ data.imageUrl }}">
							<input type="hidden" class="image-input" id="{{ data.fieldID }}" name="{{ data.fieldName }}" value="{{ data.value }}" />
						<# } #>
					</div>

					<# var addButtonClass = ( '' === data.value || 1 < data.multiple ) ? '' : 'hide-button'; #>
					<input type="button" class="button-image-text add-button button {{ addButtonClass }}" value="<?php esc_attr_e( 'Add Image', 'jeg-elementor-kit' ); ?>">
					<# var removeButtonClass = ( '' === data.value || 1 < data.multiple ) ? 'hide-button' : ''; #>
					<input type="button" class="button-image-text remove-button button {{ removeButtonClass }}" value="<?php esc_attr_e( 'Remove Image', 'jeg-elementor-kit' ); ?>">
				</div>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
