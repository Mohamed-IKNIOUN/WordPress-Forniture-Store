(function ($) {
    'use strict';

    // New Select Mechanism
    var ajaxCall = function (query, callback) {
        var field = this,
            value = field.element.find('input').attr('value');
        if (!query.length || query.length < 3) return callback();

        var request = wp.ajax.send(field.ajax, {
            data: {
                query: query,
                nonce: field.nonce,
                slug: field.slug,
                value: value
            }
        });

        request.done(function (response) {
            callback(response);
        });
    };

    $('.vc-select-wrapper').each(function () {
        var element = $(this),
            ajax = element.data('ajax'),
            multiple = element.data('multiple'),
            nonce = element.data('nonce'),
            slug = element.data('slug'),
            input, setting;

        if (multiple > 1) {
            var optionText = $(this).find('.data-option').text();
            var options = JSON.parse(optionText);
            input = $(this).find('input');

            setting = {
                plugins: ['drag_drop', 'remove_button'],
                multiple: multiple,
                hideSelected: true,
                persist: true,
                options: options,
                render: {
                    option: function (item) {
                        return '<div><span>' + item.text + '</span></div>';
                    }
                }
            };
        } else {
            input = $(this).find('select');
            setting = {
                allowEmptyOption: true
            };
        }

        if (ajax !== '') {
            setting.load = ajaxCall.bind({
                ajax: ajax,
                nonce: nonce,
                slug: slug,
                element: element
            });
            setting.create = true;
        }

        $(input).selectize(setting);
    });

    // Number.js
    $('.number-input-wrapper input[type=text]').each(function () {
        var element = this,
            min = $(this).attr('min'),
            max = $(this).attr('max'),
            step = $(this).attr('step');

        $(element).spinner({
            min: min,
            max: max,
            step: step
        });
    });

    // Checkblock.js
    $('.wp-tab-panel.vc_checkblock').each(function () {
        var parent = this;
        var input = $(parent).find('.wpb-input');

        $(this).find('.checkblock').on('click', function () {
            var result = [];
            $(parent).find('.checkblock').each(function () {
                if ($(this).is(":checked")) {
                    result.push($(this).val());
                }
            });
            $(input).val(result);
        });
    });

    // Radioimage.js
    window.vc.atts.radioimage = {
        init: function (param, $field) {
            $('.radio-image-wrapper label input', $field).change(function () {
                var $input = $(this).closest('.radio-image-wrapper').find('.wpb_vc_param_value');
                $input.val($(this).val()).trigger('change');
            });
        }
    };

    // Slider.js
    $('.slider-input-wrapper').each(function () {
        var element = $(this),
            input = element.find('input[type=range]');

        input.on('mousedown', function () {
            $(this).mousemove(function () {
                element.find('.jeg_range_value .value').text($(this).val());
            });
        });

        input.on('click', function () {
            element.find('.jeg_range_value .value').text($(this).val());
        });

        element.find('.jeg-slider-reset').on('click', function () {
            var thisInput = $(this).parent().find('input'),
                inputDefault = thisInput.data('reset_value')

            thisInput.val(inputDefault);
            thisInput.change();

            element.find('.jeg_range_value .value').text(inputDefault);
        });
    });

    // File.js
    $(".input-uploadfile").each(function () {
        var element = this;
        var input = $(element).find('input[type="text"]');

        $(this).find('.selectfileimage').on('click', function (e) {
            e.preventDefault();

            //Extend the wp.media object
            var custom_uploader = wp.media.frames.file_frame = wp.media({
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                var url = attachment.url;
                input.val(url);
            });

            //Open the uploader dialog
            custom_uploader.open();
        });
    });
})(window.jQuery);
