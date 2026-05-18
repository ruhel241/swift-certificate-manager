<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
   
    $swiftcm_global_settings         = get_option('swiftcm_global_settings', []);
    $swiftcm_payment_settings_stripe = get_option('swiftcm_payment_settings_stripe', []);
    $swiftcm_payment_settings_paypal = get_option('swiftcm_payment_settings_paypal', []);

    $swiftcm_stripe_enabled = $swiftcm_payment_settings_stripe['enable'] ?? 'no';
    $swiftcm_paypal_enabled = $swiftcm_payment_settings_paypal['enable'] ?? 'no';

?>

<div class="swiftcm-request-certificate-wrapper">
    <div class="swiftcm-form-submit-message"></div>
    <div class="swiftcm-container">
        <h2>Student Request Certificate</h2>

        <form id="swiftcm_request_certificate" method="post">
            <div class="swiftcm_payment_processor"></div>

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
                    if ( ($swiftcm_stripe_enabled === 'yes') || ($swiftcm_paypal_enabled === 'yes') ) : 
                    
                    $swiftcm_global_settings['certificate_payment'] = $swiftcm_global_settings['certificate_payment'] ?? '10';
                ?>
                    <div class="form-group">
                        <div class="swiftcm_payment_checkbox">
                            <input type="checkbox" id="swiftcm_payment_checkbox" name="swiftcm_payment_checkbox" value="yes" required>
                            <label for="swiftcm_payment_checkbox">
                                Order Digital Certificate for
                                <?php echo esc_html(\SwiftCertificateManager\Helpers\PaymentHelper::currencySymbol($swiftcm_global_settings['currency'] ?? 'USD')); ?><?php echo esc_html($swiftcm_global_settings['certificate_payment']); ?>
                            </label>
                            <input
                                type="number"
                                class="swiftcm_payment"
                                id="swiftcm_payment_total"
                                value="<?php echo esc_attr($swiftcm_global_settings['certificate_payment']); ?>"
                                required
                                disabled
                                hidden
                            >
                        </div>
                    </div>

                    <div class="form-group swiftcm_payment_method" style="display: none;">
                        <label>Payment Method:</label><br>

                        <?php if ($swiftcm_stripe_enabled === 'yes') : ?>
                            <input type="radio" id="swiftcm_stripe" name="payment_method" value="stripe" required>
                            <label for="swiftcm_stripe">Pay with Card (Stripe)</label><br>
                        <?php endif; ?>

                        <?php if ($swiftcm_paypal_enabled === 'yes') : ?>
                            <input type="radio" id="swiftcm_paypal" name="payment_method" value="paypal" required>
                            <label for="swiftcm_paypal">Pay with PayPal</label><br>
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