<#
var atts  = '',
field = data.field,
name  = data.name,
value = data.value;

// Class
if ( field.className ) {
atts += ' class="' + field.className + ' checkbox"';
}

// Toggle data
if ( field.toggle ) {
atts += " data-toggle='" + JSON.stringify( field.toggle ) + "'";
}

// Hide data
if ( field.hide ) {
atts += " data-hide='" + JSON.stringify( field.hide ) + "'";
}

// Trigger data
if ( field.trigger ) {
atts += " data-trigger='" + JSON.stringify( field.trigger ) + "'";
}

var checked = ( '1' == data.value ) ? 'checked' : '';
#>

<label class="checkbox-container" for="{{ data.name }}">
	<input type="checkbox" {{{ atts }}} name="{{ data.name }}" id="{{ data.name }}" hidden value="1" {{ checked }}/>
	<span class="switch"></span>
</label>