<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
   
    $swiftCertificateGlobalSettings        = get_option('swift_certificate_manager_global_settings', []);
    $swiftCertificatePaymentSettingsStripe = get_option('swift_certificate_manager_payment_settings_stripe', []);
    $swiftCertificatePaymentSettingsPaypal = get_option('swift_certificate_manager_payment_settings_paypal', []);

    $swiftCertificateStripeEnabled = $swiftCertificatePaymentSettingsStripe['enable'] ?? 'no';
    $swiftCertificatePaypalEnabled = $swiftCertificatePaymentSettingsPaypal['enable'] ?? 'no';

    $swiftCertificatePro = defined('SWIFT_CERTIFICATE_PRO');

?>

<div class="wscm-request-certificate-wrapper">
    <div class="wscm-form-submit-message"></div>
    <div class="wscm-container">
        <h2>Student Request Certificate</h2>

        <form id="wscm_request_certificate" method="post">
            <div class="swift_certificate_manager_payment_processor"></div>

            <div class="request_cretificate_form">
                <div class="form-group">
                    <label for="student_name">Student Name:</label><br>
                    <input type="text" id="student_name" name="student_name" required maxlength="40">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="student_email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="course_name">Course Name:</label><br>
                    <input type="text" id="course_name" name="course_name" required maxlength="80">
                </div>

                <div class="form-group">
                    <label for="graduation_date">Date:</label><br>
                    <input type="text" id="graduation_date" name="graduation_date" required>
                </div>

                <?php 
                    if ( ($swiftCertificateStripeEnabled === 'yes') || ($swiftCertificatePaypalEnabled === 'yes') ) : 
                    
                    $swiftCertificateGlobalSettings['certificate_payment'] = $swiftCertificateGlobalSettings['certificate_payment'] ?? '10';
                ?>
                    <div class="form-group">
                        <div class="wscm_payment_checkbox">
                            <input type="checkbox" id="wscm_payment_checkbox" name="wscm_payment_checkbox" value="yes" required>
                            <label for="wscm_payment_checkbox">
                                Order Digital Certificate for
                                <?php echo esc_html(\SwiftCertificateManager\Helpers\PaymentHelper::currencySymbol($swiftCertificateGlobalSettings['currency'] ?? 'USD')); ?><?php echo esc_html($swiftCertificateGlobalSettings['certificate_payment']); ?>
                            </label>
                            <input
                                type="number"
                                class="wscm_payment"
                                id="wscm_payment_total"
                                value="<?php echo esc_attr($swiftCertificateGlobalSettings['certificate_payment']); ?>"
                                required
                                disabled
                                hidden
                            >
                        </div>
                    </div>

                    <div class="form-group wscm_payment_method" style="display: none;">
                        <label>Payment Method:</label><br>

                        <?php if ($swiftCertificateStripeEnabled === 'yes') : ?>
                            <input type="radio" id="wscm_stripe" name="payment_method" value="stripe" required>
                            <label for="wscm_stripe">Pay with Card (Stripe)</label><br>
                        <?php endif; ?>

                        <?php if ($swiftCertificatePaypalEnabled === 'yes') : ?>
                            <input type="radio" id="wscm_paypal" name="payment_method" value="paypal" required>
                            <label for="wscm_paypal">Pay with PayPal</label><br>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="form-group" style="margin: 40px 0px">
                    <input type="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>