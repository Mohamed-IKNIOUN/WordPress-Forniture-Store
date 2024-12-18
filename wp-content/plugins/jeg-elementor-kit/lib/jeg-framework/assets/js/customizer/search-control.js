(function (api, $) {
    "use strict";

    var search = {};

    search.searchString = function (query) {
        query = query.trim();

        return wp.ajax.send({
            url: searchSetting.ajaxUrl,
            data: {
                nonce: searchSetting.nonce,
                search: query
            }
        });
    };

    search.buildElement = function ($header, $control) {
        var searchOnHeader = search.compileTemplate('search-wrapper');
        $header.append(searchOnHeader);

        var searchOverlay = search.compileTemplate('search-overlay');
        $control.append(searchOverlay);
    };

    search.resizeSearchResult = function ($searchResult, $control) {
        var resizeSearchContainer = function () {
            var wh = $control.height();
            $searchResult.height(wh - 90);
        };

        resizeSearchContainer();
        $(window).on('resize', resizeSearchContainer);
    };

    search.hookInput = function ($searchInput, $searchResult) {
        var timeout = null;
        $searchInput.on('input', function (e) {
            var value = $(this).val();
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                value = value.trim();

                if (value.length >= 3) {
                    search.showLoader($searchResult);
                    var result = search.searchString(value);
                    result.done(search.buildSearchResult.bind($searchResult))
                }
            }, 500);
        });
    };

    search.showLoader = function (searchResult) {
        $(searchResult).find('.search-loader').removeClass('hidden');
    };

    search.hideLoader = function (searchResult) {
        $(searchResult).find('.search-loader').addClass('hidden');
    };

    search.compileTemplate = function (template, data) {
        var compiledTemplate = wp.template(template);
        return $(compiledTemplate(data));
    };

    search.buildSearchResult = function (responses) {
        var wrapper = this;
        var result = _.sortBy(responses, 'match').reverse();

        _.each(result, function (content, index) {
            var section = api.section(content.section);
            
            if(undefined != section ){
                var path = section.params.title;
                var panelID = api.section(content.section).panel();
            }

            if (panelID) {
                path = api.panel(panelID).params.title + " » " + path;
            }

            result[index]['path'] = path;
        });

        var html = search.compileTemplate('search-control', result);
        $(wrapper).find('.customizer-search-result-wrapper').html(html);
        search.hideLoader(wrapper);
    };

    search.focusControl = function (controlID) {
        var control = api.control(controlID);
        if (control) control.focus();
    };

    search.init = function(){
        var showSearch = false;
        var $header = $("#customize-header-actions");
        var $control = $("#customize-controls");

        search.buildElement($header, $control);

        var $searchInput = $header.find("input[type='text']");
        var $searchWrapper = $header.find('.customizer-search-wrapper');
        var $toggleButton = $header.find('.customizer-search-toggle');
        var $toggleIcon = $header.find('.customizer-search-toggle i');
        var $searchResult = $header.find('.customizer-search-result');
        var $overlay = $control.find('.customizer-search-overlay');

        search.resizeSearchResult($searchResult, $control);

        var openSearch = function () {
            $toggleIcon.removeClass('fa-search').addClass('fa-times');
            $searchWrapper.addClass('active');
            $searchResult.addClass('active');
            $overlay.addClass('active');
            $searchInput.focus();
            showSearch = true;
        };

        var closeSearch = function () {
            $toggleIcon.removeClass('fa-times').addClass('fa-search');
            $searchWrapper.removeClass('active');
            $searchResult.removeClass('active');
            $overlay.removeClass('active');
            showSearch = false;
        };

        $toggleButton.on('click', function (e) {
            e.preventDefault();

            if (!showSearch) {
                openSearch();
            } else {
                closeSearch();
            }
        });

        search.hookInput($searchInput, $searchResult);

        $searchResult.on('click', '.search-li', function () {
            var control = $(this).data('control');
            var section = $(this).data('section');

            var sectionAPI = api.section(section);
            closeSearch();

            if (sectionAPI.params.type === 'lazy') {
                if (sectionAPI.loaded) {
                    search.focusControl(control);
                } else {
                    var promise = sectionAPI.expand();
                    promise.done(function () {
                        search.focusControl(control);
                    });
                }
            } else {
                search.focusControl(control);
            }
        });
    };


    api.bind('ready', function () {
        search.init();
    });
})(wp.customize, jQuery);