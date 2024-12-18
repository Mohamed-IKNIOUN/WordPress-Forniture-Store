import {CheckoutGateway} from '../payments/classes';
import cart from '@ppcp/cart';
import {isPluginConnected} from '@ppcp/utils';

if (isPluginConnected()) {
    const checkout = new CheckoutGateway(cart, {id: 'ppcp', context: 'checkout'});

    setInterval(() => {
        checkout.createButton();
    }, 2000);
}