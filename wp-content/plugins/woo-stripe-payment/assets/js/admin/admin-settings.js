import $ from 'jquery';

class Settings {
    constructor(params) {
        this.params = params;
        this.prefix = '#' + $('#wc_stripe_prefix').val();
    }

    init() {
        $('[name^="woocommerce_stripe"]').on('change', this.display_children.bind(this));

        $('select.stripe-accepted-cards').on('select2:select', this.reorder_multiselect);

        $('.api-register-domain').on('click', this.register_domain.bind(this));

        $('.wc-stripe-create-webhook').on('click', this.manage_webhook.bind(this));

        $('.wc-stripe-connection-test').on('click', this.do_connection_test.bind(this));

        $('.stripe-delete-connection').on('click', this.do_delete_connection.bind(this));

        $(document.body).on('change', '.payment-method-config-options', this.fetchPaymentMethodConfigSettings.bind(this));

        $(document.body).on('click', '.add-new-payment-config', this.renderPaymentConfigModal.bind(this));

        $(document.body).on('click', '#create-payment-config', this.createPaymentMethodConfig.bind(this));

        $(document.body).on('click', '.refresh-payment-config', this.refreshPaymentConfig.bind(this));

        if (typeof (wc_stripe_admin_notices) != 'undefined') {
            this.display_notices();
        }

        this.display_children();

        if (window.location.search.match(/_stripe_connect_nonce/)) {
            history.pushState({}, '', window.location.pathname + '?page=wc-settings&tab=checkout&section=stripe_api');
        }

        $(document.body).on('submit', '#mainform', this.validateForm.bind(this));
    }

    display_children(e) {
        $('[data-show-if]').each(function (i, el) {
            var $this = $(el);
            var values = $this.data('show-if');
            var hidden = [];
            $.each(values, function (k, v) {
                var $key = $(this.prefix + k);
                if (hidden.indexOf($this.attr('id')) == -1) {
                    if ($key.is(':checkbox')) {
                        if ($key.is(':checked') == v) {
                            $this.closest('tr').show();
                        } else {
                            $this.closest('tr').hide();
                            hidden.push($this.attr('id'));
                        }
                    } else {
                        if ($key.val() == v) {
                            $this.closest('tr').show();
                        } else {
                            $this.closest('tr').hide();
                            hidden.push($this.attr('id'));
                        }
                    }
                } else {
                    $this.closest('tr').hide();
                    hidden.push($this.attr('id'));
                }
            }.bind(this));
        }.bind(this));
    }

    reorder_multiselect(e) {
        var element = e.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger('change');
    }

    register_domain(e) {
        e.preventDefault();
        this.block();
        $.ajax({
            url: this.params.routes.apple_domain,
            dataType: 'json',
            method: 'POST',
            data: {_wpnonce: this.params.rest_nonce, hostname: window.location.hostname}
        }).done((response) => {
            this.unblock();
            if (response.code) {
                window.alert(response.message);
            } else {
                window.alert(response.message);
            }
        }).fail((xhr, textStatus, errorThrown) => {
            this.unblock();
            window.alert(errorThrown);
        })
    }

    manage_webhook(e) {
        e.preventDefault();
        if ($(e.currentTarget).is('.wc-stripe-delete-webhook')) {
            this.delete_webhook();
        } else {
            this.create_webhook();
        }
    }

    create_webhook() {
        this.block();
        var env = $('#woocommerce_stripe_api_mode').val();
        $.ajax({
            url: this.params.routes.create_webhook,
            dataType: 'json',
            method: 'POST',
            data: {_wpnonce: this.params.rest_nonce, environment: env}
        }).done((response) => {
            this.unblock();
            if (response.code) {
                window.alert(response.message);
            } else {
                $('#woocommerce_stripe_api_webhook_secret_' + env).val(response.secret);
                window.alert(response.message);
                window.location.reload();
            }
        }).fail((xhr, textStatus, errorThrown) => {
            this.unblock();
            window.alert(errorThrown);
        })
    }

    delete_webhook() {
        this.block();
        var mode = $('#woocommerce_stripe_api_mode').val();
        $.ajax({
            url: this.params.routes.delete_webhook,
            dataType: 'json',
            method: 'POST',
            data: {_wpnonce: this.params.rest_nonce, mode: mode}
        }).done(function (response) {
            this.unblock();
            if (response.code) {
                window.alert(response.message);
            } else {
                $('#woocommerce_stripe_api_webhook_secret_' + mode).val('');
                window.location.reload();
            }
        }.bind(this)).fail(function (xhr, textStatus, errorThrown) {
            this.unblock();
            window.alert(errorThrown);
        }.bind(this))
    }

    do_connection_test(e) {
        e.preventDefault();
        this.block();
        var mode = $('#woocommerce_stripe_api_mode').val();
        $.ajax({
            url: this.params.routes.connection_test,
            dataType: 'json',
            method: 'POST',
            data: (() => {
                var data = {
                    _wpnonce: this.params.rest_nonce,
                    mode: mode
                };
                if (mode === 'test') {
                    data.secret_key = $('#woocommerce_stripe_api_secret_key_test').val();
                    data.publishable_key = $('#woocommerce_stripe_api_publishable_key_test').val();
                }
                return data;
            })()
        }).done(response => {
            this.unblock();
            if (response.code) {
                window.alert(response.message);
            } else {
                window.alert(response.message);
            }
        }).fail((xhr, textStatus, errorThrown) => {
            this.unblock();
            window.alert(errorThrown);
        })
    }

    display_notices() {
        $.each(wc_stripe_admin_notices, function (idx, notice) {
            $('.woo-nav-tab-wrapper').after(notice);
        }.bind(this))
    }

    block() {
        $('.wc-stripe-settings-container').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
    }

    unblock() {
        $('.wc-stripe-settings-container').unblock();
    }

    do_delete_connection(e) {
        e.preventDefault();
        if (confirm(this.params.messages.delete_connection)) {
            this.block();
            $.ajax({
                method: 'POST',
                url: this.params.routes.delete_connection,
                dataType: 'json',
                data: {_wpnonce: this.params.rest_nonce}
            }).done(function (response) {
                this.unblock();
                if (!response.code) {
                    window.location.reload();
                } else {
                    window.alert(response.message);
                }
            }.bind(this)).fail(function () {
                this.unblock();
            }.bind(this));
        }
    }

    createPaymentMethodConfig(e) {
        e.preventDefault();
        const $button = $(e.currentTarget);
        const oldText = $button.text();
        $button.text(this.params.messages.create).prop('disabled', true);
        $.ajax({
            method: 'POST',
            url: this.params.routes.create_payment_method_config,
            dataType: 'json',
            data: {_wpnonce: this.params.rest_nonce, name: $('#payment_config_name').val()}
        }).done(response => {
            $button.text(oldText).prop('disabled', false);
            if (!response.code) {
                $('.wc-stripe-settings-container').replaceWith(response.html);
                $(document.body).trigger('wc-enhanced-select-init');
                $('.modal-close').click();
            } else {
                window.alert(response.message);
            }
        }).fail(() => {
            $button.text(oldText).prop('disabled', false);
        });
    }

    fetchPaymentMethodConfigSettings(e) {
        this.block();
        const enabled = $('#woocommerce_stripe_upm_enabled').is(':checked');
        $.ajax({
            method: 'POST',
            url: this.params.routes.fetch_payment_method_config,
            dataType: 'json',
            data: {
                _wpnonce: this.params.rest_nonce,
                payment_config: $(e.currentTarget).val()
            }
        }).done(response => {
            this.unblock();
            if (!response.code) {
                $('.wc-stripe-settings-container').replaceWith(response.html);
                $('#woocommerce_stripe_upm_enabled').prop('checked', enabled);
                $(document.body).trigger('wc-enhanced-select-init');
                $('.modal-close').click();
            } else {
                window.alert(response.message);
            }
        }).fail(() => {
            this.unblock();
        });
    }

    renderPaymentConfigModal(e) {
        e.preventDefault();
        $(e.currentTarget).WCBackboneModal({
            template: 'wc-stripe-modal-payment-config',
            variable: ''
        })
    }

    validateForm(e) {
        if ($('.wc-stripe-settings-container').hasClass('stripe_upm')) {
            if ($('.payment-method-config-options').val() === '') {
                window.alert(this.params.messages.upm_validation);
                return false;
            }
        }
    }

    refreshPaymentConfig(e) {
        e.preventDefault();
        const $button = $(e.currentTarget);
        $button.prop('disabled', true).find('span').addClass('processing');
        $.ajax({
            method: 'POST',
            url: this.params.routes.refresh_payment_method_config,
            dataType: 'json',
            data: {
                _wpnonce: this.params.rest_nonce,
                payment_config: $(e.currentTarget).val()
            }
        }).done(response => {
            $button.prop('disabled', false).find('span').removeClass('processing');
            if (!response.code) {
                $('.wc-stripe-settings-container').replaceWith(response.html);
                $(document.body).trigger('wc-enhanced-select-init');
            } else {
                window.alert(response.message);
            }
        }).fail(() => {
            $button.prop('disabled', false).find('span').removeClass('processing');
        });
    }

}

$(() => {
    (new Settings(wc_stripe_setting_params)).init();
})