/******/ (() => { // webpackBootstrap
/*!***************************************************************!*\
  !*** ./resources/public/js/PaymentMethods/paypal-checkout.js ***!
  \***************************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var PaypalCheckout = /*#__PURE__*/function () {
  function PaypalCheckout($form, $response) {
    _classCallCheck(this, PaypalCheckout);
    this.form = $form;
    this.data = ($response === null || $response === void 0 ? void 0 : $response.data) || {};
  }
  return _createClass(PaypalCheckout, [{
    key: "init",
    value: function init() {
      var _this = this;
      if (typeof window.paypal === 'undefined' || !window.paypal.Buttons) {
        console.error('PayPal SDK is not loaded.');
        return;
      }
      if (!this.form || !this.form.length) {
        console.error('PayPal form not found.');
        return;
      }
      if (!this.data.purchase_units || !this.data.hash) {
        console.error('Invalid PayPal response data.', this.data);
        return;
      }
      var paymentProcessorContainer = this.form.find('.swiftcm_payment_processor');
      if (!paymentProcessorContainer.length) {
        console.error('Could not find the payment processor container.');
        return;
      }

      // Remove old message/button before re-render
      paymentProcessorContainer.empty();
      this.form.find('.swiftcm_complete_payment_instruction').remove();
      var paypalButtonContainer = jQuery("<div class='swiftcm_paypal_btn'></div>");
      paymentProcessorContainer.append(paypalButtonContainer);
      window.paypal.Buttons({
        fundingSource: window.paypal.FUNDING.PAYPAL,
        style: {
          shape: 'pill',
          layout: 'vertical',
          label: 'paypal',
          disableMaxWidth: true
        },
        createOrder: function createOrder(data, actions) {
          return actions.order.create({
            purchase_units: [_this.data.purchase_units]
          });
        },
        onApprove: function onApprove(data, actions) {
          return actions.order.capture().then(function (details) {
            var _details$purchase_uni;
            var transaction = details === null || details === void 0 || (_details$purchase_uni = details.purchase_units) === null || _details$purchase_uni === void 0 || (_details$purchase_uni = _details$purchase_uni[0]) === null || _details$purchase_uni === void 0 || (_details$purchase_uni = _details$purchase_uni.payments) === null || _details$purchase_uni === void 0 || (_details$purchase_uni = _details$purchase_uni.captures) === null || _details$purchase_uni === void 0 ? void 0 : _details$purchase_uni[0];
            if (!transaction || !transaction.id) {
              console.error('Transaction details are missing.');
              alert('Transaction details are missing.');
              return;
            }
            return jQuery.post(window.swiftcmPublicVars.ajaxurl, {
              action: 'swiftcm_payment_confirmation_paypal',
              hash: _this.data.hash,
              charge_id: transaction.id,
              nonce: window.swiftcmPublicVars.nonce
            }).then(function (response) {
              if (response !== null && response !== void 0 && response.success) {
                if (_this.data.confirmation_url) {
                  window.location.href = _this.data.confirmation_url;
                }
              } else {
                var _response$data;
                console.error('Payment confirmation failed.', response);
                alert((response === null || response === void 0 || (_response$data = response.data) === null || _response$data === void 0 ? void 0 : _response$data.message) || 'Payment confirmation failed.');
              }
            })["catch"](function (error) {
              console.error('Error during payment confirmation:', error);
              alert('An error occurred while confirming payment.');
            });
          });
        },
        onError: function onError(err) {
          console.error('PayPal error:', err);
          alert('An error occurred during PayPal payment.');
        },
        onCancel: function onCancel() {
          console.warn('PayPal payment was cancelled by the user.');
        }
      }).render(paypalButtonContainer[0]);
      this.form.find('.request_cretificate_form').hide();
      this.form.prepend("<p class='swiftcm_complete_payment_instruction'>Please complete your certificate payment with PayPal 👇</p>");
    }
  }]);
}();
window.addEventListener('swiftcm_payment_next_action_paypal', function (e) {
  var detail = e.detail;
  if (detail && detail.form && detail.response) {
    new PaypalCheckout(detail.form, detail.response).init();
  } else {
    console.error('Invalid event details for PayPal checkout.');
  }
});
/******/ })()
;