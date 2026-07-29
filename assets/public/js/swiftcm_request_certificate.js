/******/ (() => { // webpackBootstrap
/*!************************************************************!*\
  !*** ./resources/public/js/swiftcm_request_certificate.js ***!
  \************************************************************/
jQuery(document).ready(function ($) {
  var ajaxurl = window.swiftcmPublicVars.ajaxurl;
  var hasPro = !!window.swiftcmPublicVars.hasPro;
  var swiftCertificateManager = {
    requestCertificateHandle: function requestCertificateHandle(forms) {
      var that = this;
      var info = {
        student_name: $('#student_name').val().trim().substring(0, 80),
        student_email: $('#student_email').val(),
        course_name: $('#course_name').val().trim().substring(0, 40),
        graduation_date: $('#graduation_date').val(),
        certificate_details: '',
        // grade: $('#grade').val(),
        payment_total: parseInt(parseFloat($('#swiftcm_payment_total').val()) * 100, 10),
        payment_method: $('input[name="payment_method"]:checked').val(),
        currency: window.swiftcmPublicVars.globalSettings.currency || 'USD',
        status: 'request',
        payment_status: 'pending'
      };
      jQuery.post(ajaxurl, {
        action: 'swiftcm_public_ajax',
        // WordPress expects 'action' to be passed for AJAX hooks
        route: 'request_certificate_info',
        info: info,
        nonce: window.swiftcmPublicVars.nonce
      }).then(function (response) {
        var _response$data;
        $('.swiftcm-form-submit-message').show();
        if (response.success) {
          $('.swiftcm-form-submit-message').html('<p class="success-message">Form submitted successfully! We will get back to you soon.</p>');
          $('.swiftcm-container').hide();
        } else {
          $('.swiftcm-form-submit-message').append('<p class="error-message">There was a problem submitting the form. Please try again.</p>');
        }
        if ((_response$data = response.data) !== null && _response$data !== void 0 && _response$data.redirectTo) {
          window.location.href = response.data.redirectTo;
        }

        // payment method stripe enable and paypal enable then fire custom event for next action
        if (window.swiftcmPublicVars.stripe_enabled === 'yes' || window.swiftcmPublicVars.paypal_enabled === 'yes') {
          var _response$data2;
          if (((_response$data2 = response.data) === null || _response$data2 === void 0 ? void 0 : _response$data2.actionName) === 'custom') {
            that.fireCustomEvent(response.data.nextAction, response, forms);
            $('.swiftcm-container').show();
          }
        }
      }).fail(function (error) {
        $('.swiftcm-form-submit-message').append('<p class="error-message">An error occurred. Please try again.</p>');
        console.log(error); // Handle errors
      }).always(function () {});
    },
    verifyCertificateHandle: function verifyCertificateHandle() {
      var certificateCode = $('#certificate_code').val();
      $('.swiftcm-loading-spinner').show();
      $('.swiftcm-student-information').hide();
      $('.swiftcm-verify-certificate-message').hide().empty();
      jQuery.get(ajaxurl, {
        action: 'swiftcm_public_ajax',
        route: 'verify_certificate',
        certificate_code: certificateCode,
        nonce: window.swiftcmPublicVars.nonce
      }).then(function (response) {
        if (response.success) {
          var info = response.data.info;
          $('.swiftcm-student-information .swiftcm-grid .student_name .value').text(info.student_name);
          $('.swiftcm-student-information .swiftcm-grid .course_name .value').text(info.course_name);
          $('.swiftcm-student-information .swiftcm-grid .student_email .value').text(info.student_email);
          $('.swiftcm-student-information .swiftcm-grid .graduation_date .value').text(info.graduation_date);
          $('.swiftcm-student-information .swiftcm-grid .certificate_code .value').text(info.certificate_code);
          // show result
          $('.swiftcm-student-information').fadeIn();
          $('.swiftcm-verify-certificate-message').show().append('<p class="success-message">' + response.data.message + '</p>');
        } else {
          $('.swiftcm-verify-certificate-message').show().append('<p class="error-message">Unable to verify certificate.</p>');
        }
      }).fail(function (error) {
        var _error$responseJSON;
        var errorMessage = (_error$responseJSON = error.responseJSON) !== null && _error$responseJSON !== void 0 && (_error$responseJSON = _error$responseJSON.data) !== null && _error$responseJSON !== void 0 && _error$responseJSON.message ? error.responseJSON.data.message : 'An error occurred while verifying the certificate.';
        $('.swiftcm-verify-certificate-message').show().append('<p class="error-message">' + errorMessage + '</p>');
      }).always(function () {
        $('.swiftcm-loading-spinner').hide();
      });
    },
    fireCustomEvent: function fireCustomEvent(paymentMethod, response, forms) {
      window.dispatchEvent(new CustomEvent("swiftcm_payment_next_action_".concat(paymentMethod), {
        detail: {
          form: forms,
          response: response
        }
      }));
    },
    requestPaymentCheckbox: function requestPaymentCheckbox() {
      var $paymentCheckbox = $('#swiftcm_payment_checkbox');
      var $paymentMethod = $('.swiftcm_payment_method');
      if (!$paymentCheckbox.length || !$paymentMethod.length) return;
      $paymentCheckbox.on('change', function () {
        $paymentMethod.toggle($(this).is(':checked'));
      });
    },
    datepickeDisplay: function datepickeDisplay() {
      $("#graduation_date").datepicker("destroy").datepicker({
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd MM yy"
      });
    },
    init: function init() {
      var that = this;
      var forms = $('#swiftcm_request_certificate');
      // submit request form
      $('.swiftcm-request-certificate-wrapper #swiftcm_request_certificate').on('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally
        that.requestCertificateHandle(forms); // Trigger the AJAX handler
      });

      // verify certificate
      $('.swiftcm-verify-form-wrapper #verifyForm').on('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally
        that.verifyCertificateHandle(); // Trigger the AJAX handler
      });

      // verify certificate when params id match
      var urlParams = new URLSearchParams(window.location.search);
      var certificateCode = urlParams.get('code');
      if (certificateCode) {
        // Set the input field value
        $('#certificate_code').val(certificateCode);
        // Trigger certificate verification automatically
        that.verifyCertificateHandle();
      }
      this.requestPaymentCheckbox();
      this.datepickeDisplay();
    }
  };
  swiftCertificateManager.init();
});
/******/ })()
;