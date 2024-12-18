(function (api) {
    "use strict";

    if (!api.activeCallback) {
        api.activeCallback = {};
    }

    /**
     * Compare value
     *
     * @param value1
     * @param value2
     * @param compare
     * @returns {boolean}
     */
    api.activeCallback.compare = function (value1, value2, compare) {
        if (compare === '===') {
            return value1 === value2;
        }

        if (compare === '=' || compare === '==' || compare === 'equals' || compare === 'equal') {
            return value1 === value2;
        }

        if (compare === '!=') {
            return value1 !== value2;
        }

        if (compare === '!=' || compare === 'not equal') {
            return value1 !== value2;
        }

        if (compare === '>=' || compare === 'greater or equal' || compare === 'equal or greater') {
            return value1 >= value2;
        }

        if (compare === '<=' || compare === 'smaller or equal' || compare === 'equal or smaller') {
            return value1 <= value2;
        }

        if (compare === '>' || compare === 'greater') {
            return value1 > value2;
        }

        if (compare === '<' || compare === 'smaller') {
            return value1 < value2;
        }

        if (compare === 'in' || compare === 'contains') {
            var result = value1.indexOf(value2),
                high,
                low;
            if ( value1 instanceof Array && value2 instanceof Array ) {
                high = value1.length > value2.length ? value1 : value2
                low = value1.length > value2.length ? value2 : value1
                high.forEach(function(hiVal){
                    low.forEach(function(lowVal){
                        if ( hiVal == lowVal ) result++
                    })
                })
            }
            return result >= 0;
        }
    };

    /**
     * Get status for given rule
     *
     * @param rules
     * @returns {boolean}
     */
    api.activeCallback.getStatus = function (rules) {
        var flag = true;

        _.each(rules, function (rule) {
            var control = api.control(rule.setting);
            if (control) {
                var setting = api.control(rule.setting).setting,
                    value1 = rule.value,
                    value2 = setting.get()
                if (value2 instanceof Array && value2.length == 0 && !(value1 instanceof Array)) {
                    value1 = setting.get()
                    value2 = rule.value
                }
                if (value2 instanceof Object && !(value2 instanceof Array)) {
                    var keys = []
                    for ( var item in value2 ) {
                        if ( value2.hasOwnProperty(item) )
                        keys.push(value2[item])
                    }
                    value1 = keys
                    value2 = rule.value
                }
                flag = flag && api.activeCallback.compare(value1, value2, rule.operator);
            } else {
                console.log("[Active Callback] Control not exist : " + rule.setting);
            }
        });

        return flag;
    };

    /**
     * set control active status
     *
     * @param control
     * @param rules
     * @returns {*}
     */
    api.activeCallback.setActiveStatus = function (control, rules) {
        var active_status = api.activeCallback.getStatus(rules);
        control.active.set(active_status);
        return active_status;
    };

    /**
     * Register every rule for active callback
     *
     * @param control
     * @param rules
     */
    api.activeCallback.registerActiveRule = function (control, rules) {
        var activeStatus = this.setActiveStatus;

        if (control.params.active_rule !== null) {
            activeStatus(control, rules);

            _.each(rules, function (active) {
                var controlParent = api.control(active.setting);

                if ( controlParent ) {
                    controlParent.setting.bind(function () {
                        var result = activeStatus(control, rules);
                        var obj = {
                            id: control.params.settings.default,
                            result: result
                        };
                        api.previewer.send('active-callback-control-output', obj);
                    });
                }
            });
        }
    };


})(wp.customize);
