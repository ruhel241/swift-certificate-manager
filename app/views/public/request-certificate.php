<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
   
    $swifcema_global_settings         = get_option('swifcema_global_settings', []);
    $swifcema_payment_settings_stripe = get_option('swifcema_payment_settings_stripe', []);
    $swifcema_payment_settings_paypal = get_option('swifcema_payment_settings_paypal', []);

    $swifcema_stripe_enabled = $swifcema_payment_settings_stripe['enable'] ?? 'no';
    $swifcema_paypal_enabled = $swifcema_payment_settings_paypal['enable'] ?? 'no';

?>

<div class="swifcema-request-certificate-wrapper">
    <div class="swifcema-form-submit-message"></div>
    <div class="swifcema-container">
        <h2>Student Request Certificate</h2>

        <form id="swifcema_request_certificate" method="post">
            <div class="swifcema_payment_processor"></div>

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
                    if ( ($swifcema_stripe_enabled === 'yes') || ($swifcema_paypal_enabled === 'yes') ) : 
                    
                    $swifcema_global_settings['certificate_payment'] = $swifcema_global_settings['certificate_payment'] ?? '10';
                ?>
                    <div class="form-group">
                        <div class="swifcema_payment_checkbox">
                            <input type="checkbox" id="swifcema_payment_checkbox" name="swifcema_payment_checkbox" value="yes" required>
                            <label for="swifcema_payment_checkbox">
                                Order Digital Certificate for
                                <?php echo esc_html(\SwiftCertificateManager\Helpers\PaymentHelper::currencySymbol($swifcema_global_settings['currency'] ?? 'USD')); ?><?php echo esc_html($swifcema_global_settings['certificate_payment']); ?>
                            </label>
                            <input
                                type="number"
                                class="swifcema_payment"
                                id="swifcema_payment_total"
                                value="<?php echo esc_attr($swifcema_global_settings['certificate_payment']); ?>"
                                required
                                disabled
                                hidden
                            >
                        </div>
                    </div>

                    <div class="form-group swifcema_payment_method" style="display: none;">
                        <label>Payment Method:</label><br>

                        <?php if ($swifcema_stripe_enabled === 'yes') : ?>
                            <input type="radio" id="swifcema_stripe" name="payment_method" value="stripe" required>
                            <label for="swifcema_stripe">Pay with Card (Stripe)</label><br>
                        <?php endif; ?>

                        <?php if ($swifcema_paypal_enabled === 'yes') : ?>
                            <input type="radio" id="swifcema_paypal" name="payment_method" value="paypal" required>
                            <label for="swifcema_paypal">Pay with PayPal</label><br>
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