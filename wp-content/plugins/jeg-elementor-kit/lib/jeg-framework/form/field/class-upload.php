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
class Upload extends Field_Abstract {

	/**
	 * Form Text Template
	 *
	 * @var string
	 */
	protected $type = 'upload';

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper upload-control type-upload" data-field="{{ data.fieldID }}">
			<div class="widget-left">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
			</div>
			<div class="widget-right">
				<div class="upload-wrapper">
					<figure class="jeg-file-attachment" data-placeholder="<?php echo esc_attr__( 'No File Selected', 'jeg-elementor-kit' ); ?>" >
						<# if ( data.value ) { #>
							<# var defaultFilename = ( data.filename ) ? data.filename : data.default; #>
							<span class="file"><span class="dashicons dashicons-media-default"></span> {{ defaultFilename }}</span>
						<# } else { #>
							<?php echo esc_attr__( 'No File Selected', 'jeg-elementor-kit' ); ?>
						<# } #>
					</figure>

					<div class="actions">
						<button type="button" class="button remove-button<# if ( ! data.value ) { #> hidden<# } #>"><?php echo esc_attr__( 'Remove', 'jeg-elementor-kit' ); ?></button>
						<button type="button" class="button upload-button" data-label="<?php echo esc_attr__( 'Add File', 'jeg-elementor-kit' ); ?>" data-alt-label="<?php echo esc_attr__( 'Change File', 'jeg-elementor-kit' ); ?>" >
							<# if ( data.value ) { #>
								<?php echo esc_attr__( 'Change File', 'jeg-elementor-kit' ); ?>
							<# } else { #>
								<?php echo esc_attr__( 'Add File', 'jeg-elementor-kit' ); ?>
							<# } #>
						</button>
						<# if ( data.value && data.value.id ) { #>
							<input type="hidden" name="{{ data.fieldName }}" class="hidden-field" value="{{{ data.value.id }}}" data-field="{{{ data.fieldID }}}" >
						<# } else { #>
							<input type="hidden" name="{{ data.fieldName }}" class="hidden-field" value="{{{ data.value }}}" data-field="{{{ data.fieldID }}}" >
						<# } #>
					</div>
				</div>
				<i>{{{ data.description }}}</i>
			</div>
		</div>
		<?php
	}
}
