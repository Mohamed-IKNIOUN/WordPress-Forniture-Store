(function ($) {
  'use strict';

  var JegBeaver = {};

  JegBeaver.init = function(){
    $('body').delegate('.checkbox-container input', 'change', JegBeaver.checkboxChange);
  };

  JegBeaver.checkboxChange = function(){
    var select  = $(this),
        toggle  = select.attr('data-toggle'),
        i       = 0,
        value   = select.is(':checked');

    // TOGGLE sections, fields or tabs.
    if(typeof toggle !== 'undefined') {
      toggle = JSON.parse(toggle);
      for(i in toggle) {
        if(value && "1" === i ) {
          FLBuilder._settingsSelectToggle(toggle[i].fields, 'show', '#fl-field-');
        } else {
          FLBuilder._settingsSelectToggle(toggle[i].fields, 'hide', '#fl-field-');
        }
      }
    }

    FLBuilder._calculateSettingsTabsOverflow();
  };

  /**
   * Slider
   */
  JegBeaver.slider = function(wrapper){
    $(wrapper).find('input[type=range]').each(function(){
      var element = $(this),
          value = element.attr('value')

      element.closest('div').find('.jeg_range_value .value').text(value);

      element.on('mousedown', function () {
        $(this).mousemove(function () {
          var value = $(this).attr('value');
          $(this).closest('div').find('.jeg_range_value .value').text(value);
        });
      });

      element.on('click', function () {
        var value = $(this).attr('value');
        $(this).closest('div').find('.jeg_range_value .value').text(value);
      });

      element.find('.jeg-slider-reset').on('click', function () {
        var thisInput = element;
        var inputDefault = thisInput.data('reset_value');
        thisInput.val(inputDefault);
        thisInput.change();

        $(this).closest('div.wrapper').find('.jeg_range_value .value').text(inputDefault);
      });
    })
  };

  /**
   * Number
   */
  JegBeaver.number = function (wrapper) {
    var element = $(wrapper).find('input'),
      min = $(this).attr('min'),
      max = $(this).attr('max'),
      step = $(this).attr('step')

    $(element).spinner({
      min: min,
      max: max,
      step: step
    })
  };

  JegBeaver.dynamic = function (wrapper) {
    $(wrapper).find('.dynamic-target').each(function(){
      window.selectField(this);
    });
  };

  /**
   * Need to handle behavior of every element
   */
  FLBuilder.addHook('didShowLightbox', function(event, lightbox){
    var wrapper = lightbox._node[0];
    window.setTimeout(function(){
      JegBeaver.slider($(wrapper).find('.slider-wrapper'));
      JegBeaver.number($(wrapper).find('.number-wrapper'));
      JegBeaver.dynamic($(wrapper).find('.dynamic-select-wrapper'));
    }, 10);
  });

  FLBuilder.addHook('settings-form-init', function(){
    $('.checkbox-container input').trigger('change');
  });

  $(document).ready(function(){
    JegBeaver.init();
  });

})(jQuery)
