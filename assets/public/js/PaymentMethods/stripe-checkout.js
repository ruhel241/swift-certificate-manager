/******/ (() => { // webpackBootstrap
/*!***************************************************************!*\
  !*** ./resources/public/js/PaymentMethods/stripe-checkout.js ***!
  \***************************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var StripeCheckout = /*#__PURE__*/function () {
  function StripeCheckout($form, $response) {
    var _this$data;
    _classCallCheck(this, StripeCheckout);
    this.form = $form;
    this.data = ($response === null || $response === void 0 ? void 0 : $response.data) || {};
    this.intent = ((_this$data = this.data) === null || _this$data === void 0 ? void 0 : _this$data.intent) || {};
    this.parentWrapper = this.form.parents('.swiftcm-request-certificate-wrapper');
  }
  return _createClass(StripeCheckout, [{
    key: "init",
    value: function init() {
      var _this$data2,
        _this = this;
      this.startPaymentProcessing();
      var payButtonHtml = this.generatePayButton();
      var publicKey = (_this$data2 = this.data) === null || _this$data2 === void 0 || (_this$data2 = _this$data2.order_items) === null || _this$data2 === void 0 || (_this$data2 = _this$data2.payment_args) === null || _this$data2 === void 0 ? void 0 : _this$data2.public_key;
      if (!publicKey) {
        console.error('Stripe public key not found.');
        return;
      }
      var stripe = Stripe(publicKey);
      var elements = stripe.elements({
        clientSecret: this.intent.client_secret
      });
      var paymentElement = elements.create('payment', {});
      var formSelector = '#' + this.form.attr('id') + ' .swiftcm_payment_processor';
      paymentElement.mount(formSelector);
      paymentElement.on('ready', function () {
        _this.afterPaymentProcessorReady(payButtonHtml);
        var $payNowBtn = _this.form.find('#swiftcm_pay_now');
        var defaultButtonText = $payNowBtn.text();
        $payNowBtn.on('click', function (e) {
          e.preventDefault();
          $payNowBtn.text('Processing...').prop('disabled', true);
          elements.submit().then(function (submitResult) {
            if (submitResult !== null && submitResult !== void 0 && submitResult.error) {
              throw submitResult.error;
            }
            return stripe.confirmPayment({
              elements: elements,
              confirmParams: {},
              redirect: 'if_required'
            });
          }).then(function (result) {
            var _result$paymentIntent;
            if (result !== null && result !== void 0 && result.error) {
              throw result.error;
            }
            var paymentIntentId = result === null || result === void 0 || (_result$paymentIntent = result.paymentIntent) === null || _result$paymentIntent === void 0 ? void 0 : _result$paymentIntent.id;
            if (!paymentIntentId) {
              throw new Error('Stripe payment intent not found.');
            }
            $payNowBtn.text('Redirecting...');
            return jQuery.post(window.swiftcmPublicVars.ajaxurl, {
              action: 'swiftcm_payment_confirmation_stripe',
              route: 'payment_confirmation',
              intentId: paymentIntentId,
              nonce: window.swiftcmPublicVars.nonce
            });
          }).then(function (response) {
            if (response !== null && response !== void 0 && response.success) {
              var _response$data, _this$data3;
              var redirectUrl = (response === null || response === void 0 || (_response$data = response.data) === null || _response$data === void 0 ? void 0 : _response$data.redirect_url) || ((_this$data3 = _this.data) === null || _this$data3 === void 0 || (_this$data3 = _this$data3.order_items) === null || _this$data3 === void 0 || (_this$data3 = _this$data3.payment_args) === null || _this$data3 === void 0 ? void 0 : _this$data3.success_url);
              if (redirectUrl) {
                window.location.href = redirectUrl;
                return;
              }
              console.warn('Stripe success but no redirect URL found.');
              $payNowBtn.text(defaultButtonText).prop('disabled', false);
            } else {
              var _response$data2;
              console.error('Payment confirmation failed.', response);
              alert((response === null || response === void 0 || (_response$data2 = response.data) === null || _response$data2 === void 0 ? void 0 : _response$data2.message) || 'Payment confirmation failed.');
              $payNowBtn.text(defaultButtonText).prop('disabled', false);
            }
          })["catch"](function (error) {
            console.error('Stripe payment error:', error);
            alert((error === null || error === void 0 ? void 0 : error.message) || 'An error occurred while processing payment.');
            $payNowBtn.text(defaultButtonText).prop('disabled', false);
          });
        });
      });
    }
  }, {
    key: "generatePayButton",
    value: function generatePayButton() {
      var currencySymbol = window.swiftcmPublicVars.currencySymbol || '';
      var amount = parseInt(this.intent.amount || 0, 10) / 100;
      var buttonText = 'Pay ' + currencySymbol + amount + ' Now';
      return "<button id='swiftcm_pay_now' style='margin-top:20px;width:100%;' type='button'>" + buttonText + "</button>";
    }
  }, {
    key: "startPaymentProcessing",
    value: function startPaymentProcessing() {
      var _this2 = this;
      this.form.find('.swiftcm_payment_processor').parent().prepend("<p class='swiftcm_loading_processor'>Payment processor loading...</p>");
      this.parentWrapper.find('.request_cretificate_form').hide();
      setTimeout(function () {
        _this2.parentWrapper.find('.swiftcm-form-submit-message').hide();
      }, 3000);
    }

    // afterPaymentSuccess() {
    //     const receipt = "<a href='" + this.data?.order_items?.payment_args?.success_url + "'>View Receipt</a>";
    //     this.parentWrapper.find('.swiftcm-container').append("<div class='swiftcm_form_receipt'>Thanks for your Request Certificate <br/>" + receipt + "</div>");
    //     this.parentWrapper.find('#swiftcm_request_certificate').hide();
    // }
  }, {
    key: "afterPaymentProcessorReady",
    value: function afterPaymentProcessorReady(payButton) {
      this.form.find('.swiftcm_complete_payment_instruction').remove();
      this.form.prepend("<p class='swiftcm_complete_payment_instruction'>Please complete your payment with Stripe 👇</p>");
      this.form.find('.swiftcm_payment_processor').append(payButton);
      this.form.find('.swiftcm_loading_processor').remove();
    }
  }]);
}(); // when get response from server then init the stripe checkout
window.addEventListener('swiftcm_payment_next_action_stripe', function (e) {
  new StripeCheckout(e.detail.form, e.detail.response).init();
});
/******/ })()
;