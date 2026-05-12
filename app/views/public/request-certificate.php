<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
   
    $swift_certificate_manager_global_settings         = get_option('swift_certificate_manager_global_settings', []);
    $swift_certificate_manager_payment_settings_stripe = get_option('swift_certificate_manager_payment_settings_stripe', []);
    $swift_certificate_manager_payment_settings_paypal = get_option('swift_certificate_manager_payment_settings_paypal', []);

    $swift_certificate_manager_stripe_enabled = $swift_certificate_manager_payment_settings_stripe['enable'] ?? 'no';
    $swift_certificate_manager_paypal_enabled = $swift_certificate_manager_payment_settings_paypal['enable'] ?? 'no';

    // $swift_certificate_manager_pro = defined('SWIFT_CERTIFICATE_MANAGER_PRO');

?>

<div class="scm-request-certificate-wrapper">
    <div class="scm-form-submit-message"></div>
    <div class="scm-container">
        <h2>Student Request Certificate</h2>

        <form id="scm_request_certificate" method="post">
            <div class="scm_payment_processor"></div>

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
                    if ( ($swift_certificate_manager_stripe_enabled === 'yes') || ($swift_certificate_manager_paypal_enabled === 'yes') ) : 
                    
                    $swift_certificate_manager_global_settings['certificate_payment'] = $swift_certificate_manager_global_settings['certificate_payment'] ?? '10';
                ?>
                    <div class="form-group">
                        <div class="scm_payment_checkbox">
                            <input type="checkbox" id="scm_payment_checkbox" name="scm_payment_checkbox" value="yes" required>
                            <label for="scm_payment_checkbox">
                                Order Digital Certificate for
                                <?php echo esc_html(\SwiftCertificateManager\Helpers\PaymentHelper::currencySymbol($swift_certificate_manager_global_settings['currency'] ?? 'USD')); ?><?php echo esc_html($swift_certificate_manager_global_settings['certificate_payment']); ?>
                            </label>
                            <input
                                type="number"
                                class="scm_payment"
                                id="scm_payment_total"
                                value="<?php echo esc_attr($swift_certificate_manager_global_settings['certificate_payment']); ?>"
                                required
                                disabled
                                hidden
                            >
                        </div>
                    </div>

                    <div class="form-group scm_payment_method" style="display: none;">
                        <label>Payment Method:</label><br>

                        <?php if ($swift_certificate_manager_stripe_enabled === 'yes') : ?>
                            <input type="radio" id="scm_stripe" name="payment_method" value="stripe" required>
                            <label for="scm_stripe">Pay with Card (Stripe)</label><br>
                        <?php endif; ?>

                        <?php if ($swift_certificate_manager_paypal_enabled === 'yes') : ?>
                            <input type="radio" id="scm_paypal" name="payment_method" value="paypal" required>
                            <label for="scm_paypal">Pay with PayPal</label><br>
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