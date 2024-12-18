<# var field = data.field; #>
<div class="dynamic-select-wrapper">
	<# if ( 1 < field.multi ) { #>
		<input type="text" class="tooltip-target input-sortable dynamic-target"
		       name="{{ data.name }}"
		       title="{{ field.label }}"
		       placeholder="{{ field.placeholder }}"
		       data-retriever="{{ field.retriever }}"
		       data-tooltip="{{ field.label }}"
		       data-ajax="{{ field.ajax }}"
		       data-multiple="{{ field.multi }}"
		       data-nonce="{{ field.nonce }}"
		       value="{{{ data.value }}}" />
		<div class="data-option" style="display: none;">
			{{ field.options }}
		</div>
	<# } else { #>
		<select class="widefat dynamic-target" name="{{ data.name }}" data-ajax="{{ field.ajax }}" data-nonce="{{ field.nonce }}">
			<# for ( key in field.options ) { #>
				<option value="{{ key }}">{{ field.options[ key ] }}</option>
			<# } #>
		</select>
	<# } #>
</div>