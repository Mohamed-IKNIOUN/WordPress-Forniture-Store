/*jslint browser:true */
(function ($, api) {
    "use strict";

    tinymce.PluginManager.add('jeg-shortcode', function (editor, url) {
        editor.addButton('jeg-shortcode-generator', {
            title: 'Jeg Shortcode Generator',
            image: url + '/shortcode/generator.png',
            cmd: 'jeg_shortcode_list'
        });

        editor.addCommand('jeg_shortcode_list', function () {
            if (!api.shortcodepopup.has('jeg')) {
                api.shortcodepopup.add('jeg', new api.ShortCodeListPopup(editor));
            } else {
                var element = api.shortcodepopup.instance('jeg');
                element.showPopup();
            }
        });
    });

})(jQuery, wp.customize);