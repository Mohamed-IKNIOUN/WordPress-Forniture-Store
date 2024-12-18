<# var field = data.field; #>
<div class="widget-wrapper type-alert" data-field="{{ data.name }}">
	<div class="widget-alert alert-{{ field.default }}" id="{{ data.name }}" name="{{ data.name }}">
		<strong>{{{ field.label }}}</strong>
		<div class="alert-description">{{{ field.help }}}</div>
	</div>
</div>