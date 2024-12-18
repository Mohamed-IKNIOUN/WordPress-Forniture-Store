(()=>{"use strict";var e={103:e=>{e.exports=window.wcStripeModules.checkoutModules},622:e=>{e.exports=window.wcStripeModules.messageModules},705:e=>{e.exports=window.wc_stripe}},t={};function r(o){var n=t[o];if(void 0!==n)return n.exports;var i=t[o]={exports:{}};return e[o](i,i.exports,r),i.exports}(()=>{function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}var t=r(705),o=r(103),n=r(622);function i(t,r,o){return r=a(r),function(t,r){if(r&&("object"===e(r)||"function"==typeof r))return r;if(void 0!==r)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(t)}(t,p()?Reflect.construct(r,o||[],a(t).constructor):r.apply(t,o))}function p(){try{var e=!Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){})))}catch(e){}return(p=function(){return!!e})()}function a(e){return a=Object.setPrototypeOf?Object.getPrototypeOf.bind():function(e){return e.__proto__||Object.getPrototypeOf(e)},a(e)}function c(e,t){return c=Object.setPrototypeOf?Object.setPrototypeOf.bind():function(e,t){return e.__proto__=t,e},c(e,t)}var s,u="affirmMessage",f=function(e){var t,r,o=null==e||null===(t=e.get_gateway_data())||void 0===t?void 0:t.currency;return null==e||null===(r=e.params)||void 0===r||null===(r=r.supportedCurrencies)||void 0===r?void 0:r.includes(o)},l=function(e){function t(e){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),i(this,t,[e])}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&c(e,t)}(t,e),r=t,Object.defineProperty(r,"prototype",{writable:!1}),r;var r}(t.BaseGateway);"undefined"!=typeof wc_stripe_affirm_cart_params&&new n.CartMessage(new l(wc_stripe_affirm_cart_params),{elementType:u,elementId:"wc-stripe-affirm-cart-msg",containerId:"wc-stripe-affirm-cart-container",isSupported:f}),"undefined"!=typeof wc_stripe_affirm_product_params&&(Object.assign(l.prototype,t.ProductGateway.prototype),new n.ProductMessage(new l(wc_stripe_affirm_product_params),{elementType:u,elementId:"wc-stripe-affirm-product-msg",isSupported:f})),"undefined"!=typeof wc_stripe_local_payment_params&&null!==(s=wc_stripe_local_payment_params)&&void 0!==s&&null!==(s=s.gateways)&&void 0!==s&&s.stripe_affirm&&new n.CheckoutMessage((0,o.getPaymentMethod)("stripe_affirm"),{elementType:u,elementId:"wc-stripe-affirm-message-container",isSupported:f}),"undefined"!=typeof wc_stripe_bnpl_shop_params&&new n.CategoryMessage(t.stripe,wc_stripe_bnpl_shop_params,{id:"stripe_affirm",elementType:u,isSupported:function(e){var t=e.data.currency;return e.data.stripe_affirm.supportedCurrencies.includes(t)}})})(),(this.wcStripeModules=this.wcStripeModules||{}).affirmMessage={}})();
//# sourceMappingURL=affirm-message.js.map