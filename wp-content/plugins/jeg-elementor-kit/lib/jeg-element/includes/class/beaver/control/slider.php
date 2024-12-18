<# var field = data.field; #>
<div class="slider-wrapper">
	<input class="jeg-number-range" type="range" id="{{ data.name }}" name="{{ data.name }}" min="{{ field.options.min }}" max="{{ field.options.max }}" step="{{ field.options.step }}" value="{{ data.value }}" data-reset_value="{{ data.default }}" />
	<div class="jeg_range_value">
		<span class="value">{{{ data.value }}}</span>
	</div>
	<div class="jeg-slider-reset">
		<span class="dashicons dashicons-image-rotate"></span>
	</div>
</div>