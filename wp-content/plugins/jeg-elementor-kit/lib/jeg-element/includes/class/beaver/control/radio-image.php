<# var field = data.field; #>
<div class="radio-image-wrapper" type="radio-image">
	<# for(key in field.options) { #>
		<# var checked =  ( key == data.value ) ? 'checked' : ''; #>
		<label>
			<input type='radio' name="{{ data.name }}" value="{{ key }}" class='radio-image-item radioimage_field' {{ checked }}  />
			<img src='{{ field.options[ key ] }}' class='radio-image'/>
		</label>
	<# } #>
</div>