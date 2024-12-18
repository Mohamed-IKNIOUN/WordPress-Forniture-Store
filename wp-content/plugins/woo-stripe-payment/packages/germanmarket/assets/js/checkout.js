import {addFilter} from '@wordpress/hooks';

if (typeof wc_stripe_german_market_params !== 'undefined') {
    if (wc_stripe_german_market_params.second_checkout === 'on') {
        addFilter('wc_stripe_should_create_payment_method', 'paymentplugins/stripe', (value) => {
            if (!value) {
                value = true;
            }
            return value;
        });
    }
}