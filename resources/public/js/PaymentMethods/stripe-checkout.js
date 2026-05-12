class StripeCheckout {
    constructor($form, $response) {
        this.form = $form;
        this.data = $response?.data || {};
        this.intent = this.data?.intent || {};
        this.parentWrapper = this.form.parents('.scm-request-certificate-wrapper');
    }

    init() {
        this.startPaymentProcessing();

        const payButtonHtml = this.generatePayButton();
        const publicKey = this.data?.order_items?.payment_args?.public_key;

        if (!publicKey) {
            console.error('Stripe public key not found.');
            return;
        }

        const stripe = Stripe(publicKey);

        const elements = stripe.elements({
            clientSecret: this.intent.client_secret
        });

        const paymentElement = elements.create('payment', {});
        const formSelector = '#' + this.form.attr('id') + ' .scm_payment_processor';

        paymentElement.mount(formSelector);

        paymentElement.on('ready', () => {
            this.afterPaymentProcessorReady(payButtonHtml);

            const $payNowBtn = this.form.find('#swift_certificate_manager_pay_now');
            const defaultButtonText = $payNowBtn.text();

            $payNowBtn.on('click', (e) => {
                e.preventDefault();

                $payNowBtn.text('Processing...').prop('disabled', true);

                elements.submit()
                    .then((submitResult) => {
                        if (submitResult?.error) {
                            throw submitResult.error;
                        }

                        return stripe.confirmPayment({
                            elements,
                            confirmParams: {},
                            redirect: 'if_required'
                        });
                    })
                    .then((result) => {
                        if (result?.error) {
                            throw result.error;
                        }

                        const paymentIntentId = result?.paymentIntent?.id;

                        if (!paymentIntentId) {
                            throw new Error('Stripe payment intent not found.');
                        }

                        $payNowBtn.text('Redirecting...');

                        return jQuery.post(window.SwiftCertificateManagerPublicVars.ajaxurl, {
                            action: 'scm_payment_confirmation_stripe',
                            route: 'payment_confirmation',
                            intentId: paymentIntentId,
                            nonce: window.SwiftCertificateManagerPublicVars.nonce
                        });
                    })
                    .then((response) => {
                        if (response?.success) {
                            const redirectUrl =
                                response?.data?.redirect_url ||
                                this.data?.order_items?.payment_args?.success_url;

                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                                return;
                            }

                            console.warn('Stripe success but no redirect URL found.');
                            $payNowBtn.text(defaultButtonText).prop('disabled', false);
                        } else {
                            console.error('Payment confirmation failed.', response);
                            alert(response?.data?.message || 'Payment confirmation failed.');
                            $payNowBtn.text(defaultButtonText).prop('disabled', false);
                        }
                    })
                    .catch((error) => {
                        console.error('Stripe payment error:', error);
                        alert(error?.message || 'An error occurred while processing payment.');
                        $payNowBtn.text(defaultButtonText).prop('disabled', false);
                    });
            });
        });
    }

    generatePayButton() {
        const currencySymbol = window.SwiftCertificateManagerPublicVars.currencySymbol || '';
        const amount = parseInt(this.intent.amount || 0, 10) / 100;
        const buttonText = 'Pay ' + currencySymbol + amount + ' Now';

        return "<button id='swift_certificate_manager_pay_now' style='margin-top:20px;width:100%;' type='button'>" + buttonText + "</button>";
    }

    startPaymentProcessing() {
        this.form.find('.scm_payment_processor')
            .parent()
            .prepend("<p class='scm_loading_processor'>Payment processor loading...</p>");

        this.parentWrapper.find('.request_cretificate_form').hide();

        setTimeout(() => {
            this.parentWrapper.find('.scm-form-submit-message').hide();
        }, 3000);
    }

    // afterPaymentSuccess() {
    //     const receipt = "<a href='" + this.data?.order_items?.payment_args?.success_url + "'>View Receipt</a>";
    //     this.parentWrapper.find('.scm-container').append("<div class='scm_form_receipt'>Thanks for your Request Certificate <br/>" + receipt + "</div>");
    //     this.parentWrapper.find('#scm_request_certificate').hide();
    // }

    afterPaymentProcessorReady(payButton) {
        this.form.find('.scm_complete_payment_instruction').remove();
        this.form.prepend("<p class='scm_complete_payment_instruction'>Please complete your payment with Stripe 👇</p>");
        this.form.find('.scm_payment_processor').append(payButton);
        this.form.find('.scm_loading_processor').remove();
    }
}

// when get response from server then init the stripe checkout
window.addEventListener('scm_payment_next_action_stripe', function (e) {
    new StripeCheckout(e.detail.form, e.detail.response).init();
});