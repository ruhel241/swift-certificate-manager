jQuery(document).ready(function($) {
    var ajaxurl = window.SwiftCertificateManagerPublicVars.ajaxurl;
    var hasPro = !!window.SwiftCertificateManagerPublicVars.hasPro;

    var swiftCertificateManager = {
        requestCertificateHandle(forms) {
            var that = this;

            var info = {
                student_name: $('#student_name').val().trim().substring(0, 80),
                student_email: $('#student_email').val(),
                course_name: $('#course_name').val().trim().substring(0, 40),
                graduation_date: $('#graduation_date').val(),
                certificate_details: '',
                // grade: $('#grade').val(),
                payment_total: parseInt(parseFloat($('#scm_payment_total').val()) * 100, 10),
                payment_method: $('input[name="payment_method"]:checked').val(),
                currency: window.SwiftCertificateManagerPublicVars.globalSettings.currency || 'USD',
                status: 'request',
                payment_status: 'pending'
            };

            jQuery.post(ajaxurl, {
                action: 'scm_public_ajax', // WordPress expects 'action' to be passed for AJAX hooks
                route: 'request_certificate_info',
                info: info,
                nonce: window.SwiftCertificateManagerPublicVars.nonce
            })
                .then(function(response) {
                    $('.scm-form-submit-message').show();
                    if (response.success) {
                        $('.scm-form-submit-message').html('<p class="success-message">Form submitted successfully! We will get back to you soon.</p>');
                        $('.scm-container').hide();
                    } else {
                        $('.scm-form-submit-message').append('<p class="error-message">There was a problem submitting the form. Please try again.</p>');
                    }

                    if (response.data?.redirectTo) {
                        window.location.href = response.data.redirectTo;
                    }

                    // payment method stripe enable and paypal enable then fire custom event for next action
                    if (window.SwiftCertificateManagerPublicVars.stripe_enabled === 'yes' || window.SwiftCertificateManagerPublicVars.paypal_enabled === 'yes') {
                        if (response.data?.actionName === 'custom') {
                            that.fireCustomEvent(response.data.nextAction, response, forms);
                            $('.scm-container').show();
                        }
                    }

                })
                .fail(function(error) {
                    $('.scm-form-submit-message').append('<p class="error-message">An error occurred. Please try again.</p>');
                    console.log(error); // Handle errors
                })
                .always(function() {
                });
        },

        verifyCertificateHandle() {
            var certificateCode = $('#certificate_code').val();
            $('.scm-loading-spinner').show();
            $('.scm-student-information').hide();
            $('.scm-verify-certificate-message').hide().empty();
            
            jQuery.get(ajaxurl, {
                action: 'scm_public_ajax',
                route: 'verify_certificate',
                certificate_code: certificateCode,
                nonce: window.SwiftCertificateManagerPublicVars.nonce
            })
            .then(function(response) {
                if (response.success) {
                    var info = response.data.info;
                    $('.scm-student-information .scm-grid .student_name .value').text(info.student_name);
                    $('.scm-student-information .scm-grid .course_name .value').text(info.course_name);
                    $('.scm-student-information .scm-grid .student_email .value').text(info.student_email);
                    $('.scm-student-information .scm-grid .graduation_date .value').text(info.graduation_date);
                    $('.scm-student-information .scm-grid .certificate_code .value').text(info.certificate_code);
                    // show result
                    $('.scm-student-information').fadeIn();
                    $('.scm-verify-certificate-message')
                        .show()
                        .append('<p class="success-message">' + response.data.message + '</p>');
                } else {
                    $('.scm-verify-certificate-message')
                        .show()
                        .append('<p class="error-message">Unable to verify certificate.</p>');
                }
            })
            .fail(function(error) {
                var errorMessage = error.responseJSON?.data?.message
                    ? error.responseJSON.data.message
                    : 'An error occurred while verifying the certificate.';

                $('.scm-verify-certificate-message')
                    .show()
                    .append('<p class="error-message">' + errorMessage + '</p>');
            })
            .always(function() {
                $('.scm-loading-spinner').hide();
            });
        },

        fireCustomEvent(paymentMethod, response, forms) {
            window.dispatchEvent(new CustomEvent(`scm_payment_next_action_${paymentMethod}`, {
                detail: { form: forms, response },
            }));
        },

        requestPaymentCheckbox() {
            const $paymentCheckbox = $('#scm_payment_checkbox');
            const $paymentMethod   = $('.scm_payment_method');

            if (!$paymentCheckbox.length || !$paymentMethod.length) return;
            
            $paymentCheckbox.on('change', function() {
                $paymentMethod.toggle($(this).is(':checked'));
            });
        },

        datepickeDisplay() {
           $("#graduation_date").datepicker("destroy").datepicker({
                maxDate: 0,
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd MM yy"
            });
        },

        init: function() {
            var that = this;
            var forms = $('#scm_request_certificate');
            // submit request form
            $('.scm-request-certificate-wrapper #scm_request_certificate').on('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                that.requestCertificateHandle(forms); // Trigger the AJAX handler
            });

            // verify certificate
            $('.scm-verify-form-wrapper #verifyForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                that.verifyCertificateHandle(); // Trigger the AJAX handler
            });

            // verify certificate when params id match
            const urlParams = new URLSearchParams(window.location.search);
            const certificateCode = urlParams.get('code');

            if (certificateCode) {
                // Set the input field value
                $('#certificate_code').val(certificateCode);
                // Trigger certificate verification automatically
                that.verifyCertificateHandle();
            }

            this.requestPaymentCheckbox();
            this.datepickeDisplay();
        }
    }

    swiftCertificateManager.init();
 });

