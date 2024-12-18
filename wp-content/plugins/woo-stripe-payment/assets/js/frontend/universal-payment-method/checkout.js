import {CheckoutGateway, registerPaymentMethod} from '@paymentplugins/wc-stripe/checkout';

registerPaymentMethod(
    new CheckoutGateway(wc_stripe_upm_checkout_params, '#wc-stripe-upm-element')
)
