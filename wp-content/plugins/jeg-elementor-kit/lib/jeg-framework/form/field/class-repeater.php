<?php
/**
 * Form Control: repeater.
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form\Field;

/**
 * Repeater control
 */
class Repeater extends Field_Abstract {
	/**
	 * Form Control Type
	 *
	 * @var string
	 */
	protected $type = 'repeater';

	/**
	 * Render the control's JS template.
	 */
	public function render_template() {
		?>
		<script type="text/html" id="tmpl-form-field-repeater">
			<?php $this->js_template(); ?>
		</script>
		<script type="text/html" id="tmpl-form-field-repeater-content">
			<?php $this->js_repeater_template(); ?>
		</script>
		<?php
	}

	/**
	 * An Underscore (JS) template for this control's content
	 */
	public function js_template() {
		?>
		<div class="widget-wrapper type-repeater" data-field="{{ data.fieldID }}">
			<div class="widget-wrapper-top">
				<label for="{{ data.fieldID }}">{{{ data.title }}}</label>
				<i>{{{ data.description }}}</i>
			</div>
			<div class="jeg-repeater-wrapper">
				<ul class="repeater-fields"></ul>
				<div class="repeater-add-wrapper">
					<button class="button button-large button-primary repeater-add"><i class="fa fa-plus"></i></button>
				</div>
			</div>
			<# var value = ( 'object' === typeof data.value ) ? JSON.stringify(data.value) : data.value; #>
			<input class="widefat data-setting" id="{{ data.fieldID }}" name="{{ data.fieldName }}" type="hidden" value="{{ value }}" />
		</div>
		<?php
	}

	/**
	 * Repeater Template
	 */
	public function js_repeater_template() {
		?>
		<# var field; var index = data.index; #>
			<li class="repeater-row minimized" data-row="{{{ index }}}">
				<div class="repeater-row-header">
					<span class="repeater-row-label"></span>
					<i class="dashicons dashicons-arrow-down repeater-minimize"></i>
				</div>
				<div class="repeater-row-content">
					<# _.each( data, function( field, fieldID ) { #>
						<div class="repeater-field repeater-field-{{{ field.type }}}">
							<# if ( 'text' === field.type || 'url' === field.type || 'email' === field.type || 'tel' === field.type || 'date' === field.type ) { #>
								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
									<input type="{{field.type}}" name="" value="{{{ field.default }}}" data-field="{{{ fieldID }}}">
								</label>

							<# } else if ( 'hidden' === field.type ) { #>

								<input type="hidden" data-field="{{{ fieldID }}}" <# if ( field.default ) { #> value="{{{ field.default }}}" <# } #> />

							<# } else if ( 'checkbox' === field.type ) { #>

								<label>
									<input type="checkbox" value="true" data-field="{{{ fieldID }}}" <# if ( field.default ) { #> checked="checked" <# } #> /> {{ field.label }}
									<# if ( field.description ) { #>
										{{ field.description }}
									<# } #>
								</label>

							<# } else if ( 'select' === field.type ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
									<select data-field="{{{ fieldID }}}">
										<# _.each( field.choices, function( choice, i ) { #>
											<# var selected = ( field.default == i ) ? 'selected="selected"' : '';  #>
											<option value="{{{ i }}}" {{ selected }}>{{ choice }}</option>
										<# }); #>
									</select>
								</label>

							<# } else if ( 'dropdown-pages' === field.type ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{{ data.label }}}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{{ field.description }}}</span>
									<# } #>
									<div class="customize-control-content repeater-dropdown-pages">{{{ field.dropdown }}}</div>
								</label>

							<# } else if ( 'radio' === field.type ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>

									<# _.each( field.choices, function( choice, i ) { #>
										<label>
											<input type="radio" name="{{{ fieldID }}}{{ index }}" data-field="{{{ fieldID }}}" value="{{{ i }}}" <# if ( field.default == i ) { #> checked="checked" <# } #>> {{ choice }} <br/>
										</label>
									<# }); #>
								</label>

							<# } else if ( 'radio-image' === field.type ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>

									<# _.each(field.choices, function(choice, i){ #>
										<# var checked =  ( field.default == i ) ? 'checked="checked"' : ''; #>
										<input type="radio" id="{{{ fieldID }}}_{{ index }}_{{{ i }}}" name="{{{ fieldID }}}{{ index }}" data-field="{{{ fieldID }}}" value="{{{ i }}}" {{{ checked }}}>
											<label for="{{{ fieldID }}}_{{ index }}_{{{ i }}}">
												<img src="{{ choice }}">
											</label>
										</input>
									<# }); #>
								</label>

							<# } else if ( 'color' === field.type ) { #>

								<# var defaultValue = '';
								if ( field.default ) {
									if ( '#' !== field.default.substring( 0, 1 ) ) {
										defaultValue = '#' + field.default;
									} else {
										defaultValue = field.default;
									}
									defaultValue = ' data-default-color=' + defaultValue; // Quotes added automatically.
								} #>
								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{{ field.label }}}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{{ field.description }}}</span>
									<# } #>
									<input class="color-picker-hex" type="text" maxlength="7" placeholder="<?php echo esc_attr__( 'Hex Value', 'jeg-elementor-kit' ); ?>"  value="{{{ field.default }}}" data-field="{{{ fieldID }}}" {{ defaultValue }} />

								</label>

							<# } else if ( 'textarea' === field.type ) { #>

								<# if ( field.label ) { #>
									<span class="customize-control-title">{{ field.label }}</span>
								<# } #>
								<# if ( field.description ) { #>
									<span class="description customize-control-description">{{ field.description }}</span>
								<# } #>
								<textarea rows="5" data-field="{{{ fieldID }}}">{{ field.default }}</textarea>

							<# } else if ( field.type === 'image' || field.type === 'cropped_image' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
								</label>

								<figure class="jeg-image-attachment" data-placeholder="<?php echo esc_attr__( 'No Image Selected', 'jeg-elementor-kit' ); ?>" >
									<# if ( field.default ) { #>
										<# var defaultImageURL = ( field.default.url ) ? field.default.url : field.default; #>
										<img src="{{{ defaultImageURL }}}">
									<# } else { #>
										<?php echo esc_attr__( 'No Image Selected', 'jeg-elementor-kit' ); ?>
									<# } #>
								</figure>

								<div class="actions">
									<button type="button" class="button remove-button<# if ( ! field.default ) { #> hidden<# } #>"><?php echo esc_attr__( 'Remove', 'jeg-elementor-kit' ); ?></button>
									<button type="button" class="button upload-button" data-label=" <?php echo esc_attr__( 'Add Image', 'jeg-elementor-kit' ); ?>" data-alt-label="<?php echo esc_attr__( 'Change Image', 'jeg-elementor-kit' ); ?>" >
										<# if ( field.default ) { #>
											<?php echo esc_attr__( 'Change Image', 'jeg-elementor-kit' ); ?>
										<# } else { #>
											<?php echo esc_attr__( 'Add Image', 'jeg-elementor-kit' ); ?>
										<# } #>
									</button>
									<# if ( field.default.id ) { #>
										<input type="hidden" class="hidden-field" value="{{{ field.default.id }}}" data-field="{{{ fieldID }}}" >
									<# } else { #>
										<input type="hidden" class="hidden-field" value="{{{ field.default }}}" data-field="{{{ fieldID }}}" >
									<# } #>
								</div>

							<# } else if ( field.type === 'upload' || field.type === 'upload_file' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
								</label>

								<figure class="jeg-file-attachment" data-placeholder="<?php echo esc_attr__( 'No File Selected', 'jeg-elementor-kit' ); ?>" >
									<# if ( field.default ) { #>
										<# var defaultFilename = ( field.default.filename ) ? field.default.filename : field.default; #>
										<span class="file"><span class="dashicons dashicons-media-default"></span> {{ defaultFilename }}</span>
									<# } else { #>
										<?php echo esc_attr__( 'No File Selected', 'jeg-elementor-kit' ); ?>
									<# } #>
								</figure>

								<div class="actions">
									<button type="button" class="button remove-button<# if ( ! field.default ) { #> hidden<# } #>"><?php echo esc_attr__( 'Remove', 'jeg-elementor-kit' ); ?></button>
									<button type="button" class="button upload-button" data-label="<?php echo esc_attr__( 'Add File', 'jeg-elementor-kit' ); ?>" data-alt-label="<?php echo esc_attr__( 'Change File', 'jeg-elementor-kit' ); ?>" >
										<# if ( field.default ) { #>
											<?php echo esc_attr__( 'Change File', 'jeg-elementor-kit' ); ?>
										<# } else { #>
											<?php echo esc_attr__( 'Add File', 'jeg-elementor-kit' ); ?>
										<# } #>
									</button>
									<# if ( field.default && field.default.id ) { #>
										<input type="hidden" class="hidden-field" value="{{{ field.default.id }}}" data-field="{{{ fieldID }}}" >
									<# } else { #>
										<input type="hidden" class="hidden-field" value="{{{ field.default }}}" data-field="{{{ fieldID }}}" >
									<# } #>
								</div>

							<# } else if ( 'slider' === field.type ) { #>

								<span class="repeater-slider-description customize-control-description">{{{ field.description }}}</span>	
								<div class="repeater-slider-wrapper">
									<input {{data.link}} class="jeg-number-range" type="range" min="{{ field.options.min }}" max="{{ field.options.max }}" step="{{ field.options.step }}" value="{{ field.value }}" data-reset_value="{{ field.default }}" />
									<div class="jeg_range_value">
										<span class="value">{{{ field.value }}}</span>
									</div>
									<div class="jeg-slider-reset">
										<span class="dashicons dashicons-image-rotate"></span>
									</div>
								</div>

							<# } #>

						</div>
					<# }); #>
					<button type="button" class="button-link repeater-row-remove"><?php echo esc_attr__( 'delete', 'jeg-elementor-kit' ); ?></button>
				</div>
			</li>
		<?php
	}
}
