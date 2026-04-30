<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public verification endpoint
$swiftCertificateHash = isset($_GET['hash']) ? sanitize_text_field(wp_unslash($_GET['hash'])) : '';

$swiftCertificatePaymentInfo = (new \SwiftCertificateManager\Models\Payment())->getHash($swiftCertificateHash);

?>

<?php
    if ($swiftCertificatePaymentInfo) :
    $swiftCertificateCertificateInfo = (new \SwiftCertificateManager\Models\SwiftCertificateManagerGenerate)->getInfo($swiftCertificatePaymentInfo->request_id);
?>
    <div class="wscm-invoice-wrrapper">
        <div class="invoice-header">
            <div class="invoice-logo">
                <img src="<?php echo esc_url( SWIFT_CERTIFICATE_MANAGER_PLUGIN_URL . 'assets/admin/images/logo.png' ); ?>" alt="SwiftCertificateManager">
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <div class="invoice-number">#INV-<?php echo esc_html(gmdate('Y').'-000'.$swiftCertificatePaymentInfo->id);?></div>
            </div>
        </div>

        <div class="invoice-details">
            <div class="invoice-details-col client-details">
                <div class="info-block">
                    <h3>Billed To</h3>
                    <p><?php echo esc_html($swiftCertificateCertificateInfo->student_name); ?></p>
                    <p><?php echo esc_html($swiftCertificateCertificateInfo->student_email); ?></p>
                    <p>Course Name: <?php echo esc_html($swiftCertificateCertificateInfo->course_name); ?></p>
                </div>
            </div>

            <div class="invoice-details-col company-details">
                <div class="info-block">
                    <h3>From</h3>
                    <?php
                        // $logo = get_theme_mod('custom_logo');
                        // $logo_url = wp_get_attachment_image_src($logo, 'full');

                        // if ($logo_url) {
                        //     echo '<img src="'.$logo_url[0].'" alt="'.get_bloginfo('name').'">';
                        // }
                    ?>
                    <p><?php bloginfo('name'); ?></p>
                </div>

                <div class="info-block">
                    <h3>Invoice Details</h3>
                    <p><strong>Invoice Date:</strong> <?php echo esc_html(gmdate('F j, Y')); ?></p>
                    <p><strong>Status:</strong> <span class="status-badge status-paid"><?php echo esc_html($swiftCertificatePaymentInfo->payment_status);?></span></p>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <h3>Payment Information</h3>
            <div class="payment-method">
                <div><strong>Payment Method:</strong></div>
                <div><?php echo esc_html($swiftCertificatePaymentInfo->payment_method);?> (<?php echo esc_html($swiftCertificatePaymentInfo->card_brand);?> ending in <?php echo esc_html($swiftCertificatePaymentInfo->card_last_4);?>)</div>
            </div>
            <div class="payment-method">
                <div><strong>Transaction ID:</strong></div>
                <div><?php echo esc_html($swiftCertificatePaymentInfo->charge_id); ?></div>
            </div>
            <div class="payment-method">
                <div><strong>Payment Date:</strong></div>
                <div><?php echo esc_html(gmdate('F j, Y', strtotime($swiftCertificatePaymentInfo->created_at))); ?></div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for purchasing our certificate.</p>
            <p>If you have any questions about this invoice, please contact us at info@swiftcertificate.com</p>
            <p>&copy; 2026 SWIFT CERTIFICATE 
                <br/>All rights reserved.</p>
        </div>
    </div>
<?php else : ?>
    <div class="wscm-error-message" style="margin-top: 30px; background: #ffff; width: 100%; padding: 50px;  box-shadow: 0 5px 25px rgba(0,0,0,0.1); border-radius: 5px">
        <h2>Invoice Not Found</h2>
        <p>The requested payment information could not be found.</p>
    </div>
<?php endif; ?>