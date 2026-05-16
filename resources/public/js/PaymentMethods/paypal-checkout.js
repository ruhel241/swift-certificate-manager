class PaypalCheckout {
    constructor($form, $response) {
        this.form = $form;
        this.data = $response?.data || {};
    }

    init() {
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

        const paymentProcessorContainer = this.form.find('.swiftcm_payment_processor');

        if (!paymentProcessorContainer.length) {
            console.error('Could not find the payment processor container.');
            return;
        }

        // Remove old message/button before re-render
        paymentProcessorContainer.empty();
        this.form.find('.swiftcm_complete_payment_instruction').remove();

        const paypalButtonContainer = jQuery("<div class='swiftcm_paypal_btn'></div>");
        paymentProcessorContainer.append(paypalButtonContainer);

        window.paypal.Buttons({
            fundingSource: window.paypal.FUNDING.PAYPAL,

            style: {
                shape: 'pill',
                layout: 'vertical',
                label: 'paypal',
                disableMaxWidth: true
            },

            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [this.data.purchase_units]
                });
            },

            onApprove: (data, actions) => {
                return actions.order.capture().then((details) => {
                    const transaction = details?.purchase_units?.[0]?.payments?.captures?.[0];

                    if (!transaction || !transaction.id) {
                        console.error('Transaction details are missing.');
                        alert('Transaction details are missing.');
                        return;
                    }

                    return jQuery.post(window.swiftcmPublicVars.ajaxurl, {
                        action: 'swiftcm_payment_confirmation_paypal',
                        hash: this.data.hash,
                        charge_id: transaction.id,
                        nonce: window.swiftcmPublicVars.nonce
                    })
                    .then((response) => {
                        if (response?.success) {
                            if (this.data.confirmation_url) {
                                window.location.href = this.data.confirmation_url;
                            }
                        } else {
                            console.error('Payment confirmation failed.', response);
                            alert(response?.data?.message || 'Payment confirmation failed.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error during payment confirmation:', error);
                        alert('An error occurred while confirming payment.');
                    });
                });
            },

            onError: (err) => {
                console.error('PayPal error:', err);
                alert('An error occurred during PayPal payment.');
            },

            onCancel: () => {
                console.warn('PayPal payment was cancelled by the user.');
            }

        }).render(paypalButtonContainer[0]);

        this.form.find('.request_cretificate_form').hide();
        this.form.prepend("<p class='swiftcm_complete_payment_instruction'>Please complete your certificate payment with PayPal 👇</p>");
    }
}

window.addEventListener('swiftcm_payment_next_action_paypal', (e) => {
    const detail = e.detail;

    if (detail && detail.form && detail.response) {
        new PaypalCheckout(detail.form, detail.response).init();
    } else {
        console.error('Invalid event details for PayPal checkout.');
    }
});