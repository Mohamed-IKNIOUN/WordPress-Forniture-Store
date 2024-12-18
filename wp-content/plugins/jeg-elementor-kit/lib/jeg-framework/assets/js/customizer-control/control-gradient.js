wp.customize.controlConstructor['jeg-gradient'] = wp.customize.controlConstructor.default.extend({

    ready: function() {
        'use strict';

        var control = this,
            value = {},
            beginpicker, endpicker,
            beginlocation, endlocation,
            renderLocation;

        // Make sure everything we're going to need exists.
        _.each( control.params['default'], function( defaultParamValue, param ) {
            if ( false !== defaultParamValue ) {
                value[ param ] = defaultParamValue;
                if ( undefined !== control.setting._value[ param ] ) {
                    value[ param ] = control.setting._value[ param ];
                }
            }
        });
        _.each( control.setting._value, function( subValue, param ) {
            if ( undefined === value[ param ] || 'undefined' === typeof value[ param ] ) {
                value[ param ] = subValue;
            }
        });

        renderLocation = function($range, location) {
            var thisInput,
                inputDefault,
                range_value,
                $reset = $range.closest( '.range' ).find('.jeg-slider-reset');

            $range.on( 'mousedown', function() {
                jQuery( this ).mousemove( function() {
                    range_value = jQuery(this).val();
                    jQuery( this ).closest( '.range' ).find( '.jeg_range_value .value' ).text( range_value );

                    value[location] = range_value;
                    control.saveValue( value );
                });
            });

            $range.on( 'click', function() {
                range_value = jQuery(this).val();
                jQuery( this ).closest( '.range' ).find( '.jeg_range_value .value' ).text( range_value );
            });

            // Handle the reset button
            $reset.on( 'click', function() {
                thisInput    = jQuery( this ).closest( '.range' ).find( 'input' );
                inputDefault = thisInput.data( 'reset_value' );
                thisInput.val( inputDefault );
                thisInput.change();
                jQuery( this ).closest( '.range' ).find( '.jeg_range_value .value' ).text( inputDefault );
            });
        };

        // Change color
        beginpicker = this.container.find( '.jeg-begin-color' ).wpColorPicker({
            change: function() {
                setTimeout( function() {
                    value.begincolor = beginpicker.val();
                    control.saveValue( value );
                }, 100 );
            }
        });

        endpicker = this.container.find( '.jeg-end-color' ).wpColorPicker({
            change: function() {
                setTimeout( function() {
                    value.endcolor = endpicker.val();
                    control.saveValue( value );
                }, 100 );
            }
        });

        // Range
        renderLocation(this.container.find( '.jeg-range-begin input[type=range]' ), 'beginlocation', value);
        renderLocation(this.container.find( '.jeg-range-end input[type=range]' ), 'endlocation', value);
        renderLocation(this.container.find( '.jeg-range-degree input[type=range]' ), 'degree', value);
    },

    /**
     * Saves the value.
     */
    saveValue: function( value ) {
        'use strict';

        var control  = this,
            newValue = {};

        _.each( value, function( newSubValue, i ) {
            newValue[ i ] = newSubValue;
        });

        control.setting.set( newValue );
    }

});
