<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Models\SwifCeMaPayment;
use SwiftCertificateManager\Helpers\PaymentHelper;
use SwiftCertificateManager\Helpers\ArrayHelper as Arr;
use SwiftCertificateManager\Models\SwifCeMaGenerate;
use SwiftCertificateManager\Models\SwifCeMaTemplates;
use SwiftCertificateManager\Helpers\HelperFunction;

class FrontendHandler
{
    public function register() {
        add_action('wp_ajax_swifcema_public_ajax', array($this, 'ajaxRoutes'));
        add_action('wp_ajax_nopriv_swifcema_public_ajax', array($this, 'ajaxRoutes'));
        // when paypal or strip payment success then certificate payment status update
        add_action('swifcema_after_payment_success', array($this, 'paymentConfirmationAfterPaymentSuccess'));

        $this->registerShortcodes();  

        if ( defined('SWIFCEMA_PRO') ) {
            // Load payment gateways for frontend to render payment options in certificate request form
            new \SwiftCertificateManagerPro\Services\Integrations\PayPal\PayPal();
            new \SwiftCertificateManagerPro\Services\Integrations\Stripe\Stripe();
        }     
    }

    public function ajaxRoutes()
    {
        if (!check_ajax_referer('swifcema_public_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // phpcs:disable WordPress.Security.NonceVerification.Recommended.
        $route = sanitize_key( wp_unslash($_REQUEST['route'] ?? '') );
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

        if (!$route) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $validRoutes = [
            'request_certificate_info' => 'requestCertificateInfo',
            'verify_certificate'       => 'verifyCertificate',
        ];

        if (!isset($validRoutes[$route])) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $this->{$validRoutes[$route]}();

        do_action('swifcema_public_ajax_handler_catch', $route);

        wp_die();
    }

    // shortcode register
    public function registerShortcodes() {
        add_shortcode( 'swifcema', [ $this, 'render' ] );
    }

    public function render( $attr ) {

        $this->loadAssets();

        $attr = array_map( 'sanitize_key', (array) $attr );

        ob_start();

        foreach ( $attr as $name ) {

            if ( 'request-swift-certificate-manager' === $name ) {
                $this->shortcodeRenderRequestForm();
            }

            if ( 'verify-swift-certificate-manager' === $name ) {
                $this->shortcodeRenderVerifyForm();
            }
        }

        if ( isset( $attr['swifcema_invoice'] ) ) {
            $this->getInvoice();
        }

        return ob_get_clean();
    }

    public function shortcodeRenderRequestForm() {
        require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/views/public/request-certificate.php';

        $paymentSettingsStripe = get_option('swifcema_payment_settings_stripe', []);
        $paymentSettingsPaypal = get_option('swifcema_payment_settings_paypal', []);

       
        $isStripeEnabled = $paymentSettingsStripe['enable'] ?? 'no';
        $isPaypalEnabled = $paymentSettingsPaypal['enable'] ?? 'no';

        if ($isStripeEnabled === 'yes') {
            do_action('swifcema_render_component_stripe');
        }
        
        if ($isPaypalEnabled === 'yes') {
            do_action('swifcema_render_component_paypal');
        }
    }

    public function shortcodeRenderVerifyForm() {
        require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/views/public/verify-certificate.php';
    }

    public function getInvoice()
    {
        require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/views/public/payment-invoice.php';
    }

    public function requestCertificateInfo()
    {
        if (!check_ajax_referer('swifcema_public_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // phpcs:disable WordPress.Security.NonceVerification.Recommended.
        $info = isset($_REQUEST['info']) && is_array($_REQUEST['info'])
            ? map_deep(wp_unslash($_REQUEST['info']), 'sanitize_text_field')
            : [];
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

        if (empty($info)) {
            wp_send_json_error([
                'message' => __('Invalid request data', 'swift-certificate-manager'),
            ], 400);
        }

        // ✅ sanitize fields
        $status        = sanitize_text_field(Arr::get($info, 'status'));
        $paymentStatus = sanitize_text_field(Arr::get($info, 'payment_status'));
        $studentName   = sanitize_text_field(Arr::get($info, 'student_name'));
        $studentEmail  = sanitize_email(Arr::get($info, 'student_email'));
        $courseName    = sanitize_text_field(Arr::get($info, 'course_name'));

        if (!is_email($studentEmail)) {
            wp_send_json_error([
                'message' => __('Invalid email address', 'swift-certificate-manager')
            ], 400);
        }

        $SwifCeMaGenerate  = new SwifCeMaGenerate();
        $SwifCeMaTemplates = new SwifCeMaTemplates();
       
        // settings
        $globalSettings = get_option('swifcema_global_settings', []);
        $preference     = sanitize_key($globalSettings['preference'] ?? '');

        // generate code
        $certificateCodePrefix = $globalSettings['certificate_code_prefix'] ?? '';
        $certificateCode       = HelperFunction::generateCertificateCode($certificateCodePrefix);

        // template
        $activeTemplate = get_option('swifcema_active_template', 'template-1');
        $getTemplate    = $SwifCeMaTemplates->getTemplateSlug($activeTemplate);

        if (!$getTemplate) {
            wp_send_json_error([
                'message' => __('Template not found', 'swift-certificate-manager')
            ], 404);
        }

       
        $settings = json_decode($getTemplate->settings ?? '', true);
        $settings = is_array($settings) ? $settings : [];

        // date
        $rawDate = sanitize_text_field(Arr::get($info, 'graduation_date'));
        $graduationDate = $rawDate
            ? gmdate("d F Y", strtotime($rawDate))
            : gmdate('d F Y');

        // settings build
        $settings['student_name']             = $studentName;
        $settings['course_name']              = $courseName;
        $settings['graduation_date']          = $graduationDate;
        $settings['certificate_code']         = $certificateCode;
        $settings['instructor_name']          = $globalSettings[$preference . '_name'] ?? '';
        $settings['instructor_signature']     = $globalSettings[$preference . '_signature'] ?? '';
        $settings['instructor_signature_img'] = $globalSettings[$preference . '_signature_img'] ?? '';
        $settings['template_id']              = $getTemplate->id;

        // db data
        $data = [
            'status'           => $status,
            'student_name'     => $studentName,
            'student_email'    => $studentEmail,
            'course_name'      => $courseName,
            'payment_status'   => $paymentStatus,
            'graduation_date'  => $graduationDate,
            'certificate_code' => $certificateCode,
            'qr_code_url'      => esc_url_raw(get_site_url() . '/verify-form/?code=' . urlencode($certificateCode)),
            'settings'         => wp_json_encode($settings),
            'created_at'       => gmdate('Y-m-d H:i:s'),
            'updated_at'       => gmdate('Y-m-d H:i:s'),
        ];

        $certificateGenerateId = $SwifCeMaGenerate->insertGetId($data);
        $certificateData       = $SwifCeMaGenerate->getInfo($certificateGenerateId);

        // ⚠️ pass sanitized info only
        $this->paymentCreate($info, $certificateGenerateId);

        wp_send_json_success([
            'message' => __("Successfully Requested Certificate", 'swift-certificate-manager'),
            'info'    => $certificateData
        ], 200);
    }

    public function verifyCertificate()
    {
        if (!check_ajax_referer('swifcema_public_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // phpcs:disable WordPress.Security.NonceVerification.Recommended.
        $certificateCode = sanitize_text_field(wp_unslash($_REQUEST['certificate_code'] ?? ''));
        // phpcs:enable WordPress.Security.NonceVerification.Recommended
        
        if (!$certificateCode) {
            wp_send_json_error([
                'message' => __('Certificate code is required', 'swift-certificate-manager')
            ], 400);
        }

       
        $SwifCeMaGenerate = new SwifCeMaGenerate();

        $info = $SwifCeMaGenerate->verifyCertificateCode($certificateCode);

        if (empty($info)) {
            wp_send_json_error([
                'message' => __('Data can\'t be found', 'swift-certificate-manager'),
                'info'    => []
            ], 404);
        }

        $getInfo = [
            'student_name'     => esc_html($info->student_name ?? ''),
            'student_email'    => esc_html($info->student_email ?? ''),
            'course_name'      => esc_html($info->course_name ?? ''),
            'certificate_code' => esc_html($info->certificate_code ?? ''),
            'graduation_date'  => esc_html($info->graduation_date ?? ''),
        ];

        wp_send_json_success([
            'message' => __('Successfully Verify Certificate', 'swift-certificate-manager'),
            'info'    => $getInfo
        ], 200);
    }

    // when payment then trigger action paypal or stripe
    public function paymentCreate($info, $certificateGenerateId)
    {
        if (!is_array($info)) {
            return;
        }

        // 🔐 sanitize inputs
        $paymentMethod = sanitize_key(Arr::get($info, 'payment_method'));
        $status        = sanitize_text_field(Arr::get($info, 'status'));
        $paymentTotal  = (float) sanitize_text_field(Arr::get($info, 'payment_total'));
        $currency      = sanitize_text_field(Arr::get($info, 'currency'));

        if (empty($paymentMethod)) {
            return;
        }

        // 🔒 allow only known methods (IMPORTANT)
        $allowedMethods = ['stripe', 'paypal']; // add more if needed
        if (!in_array($paymentMethod, $allowedMethods, true)) {
            return;
        }

        // option key safe
        $key = "swifcema_payment_settings_" . $paymentMethod;

        $paymentSettings = get_option($key, []);
        $isEnabled = $paymentSettings['enable'] ?? 'no';

        if ($isEnabled !== 'yes') {
            return;
        }

        if ($status !== 'request') {
            return;
        }

        // 🔐 generate safe hash
        $hash = $this->generateHash();

        $paymentData = [
            'request_id'     => absint($certificateGenerateId),
            'entry_hash'     => $hash,
            'payment_status' => 'pending',
            'payment_total'  => $paymentTotal,
            'payment_method' => $paymentMethod,
            'currency'       => $currency,
            'created_at'     => gmdate('Y-m-d H:i:s'),
            'updated_at'     => gmdate('Y-m-d H:i:s'),
        ];

        $paymentId = (new SwifCeMaPayment)->insertGetId($paymentData);

        // 💳 trigger payment only if amount valid
        if ($paymentTotal > 0) {
            do_action(
                'swifcema_make_payment_' . $paymentMethod,
                $certificateGenerateId,
                $paymentId
            );
        }
    }

    private function generateHash()
    {
        return 'swifcema_' . wp_generate_uuid4();
    }

     // when paypal or stripe paid then generate certificate payment status update
    public function paymentConfirmationAfterPaymentSuccess($hash) {
        if (empty($hash)) {
            return;
        }

        $SwifCeMaGenerate  = new SwifCeMaGenerate();
        $payment = (new SwifCeMaPayment)->getHash($hash);
        $paymentStatus = $payment->payment_status;

        $GenerateData = [
            'payment_status' => $paymentStatus,
            'updated_at' => gmdate('Y-m-d H:i:s')
        ];
        
        $SwifCeMaGenerate->updateInfo($payment->request_id, $GenerateData);
    }

    public function loadAssets() {
        static $loaded = false;
        
        if ($loaded) return;

        $loaded = true;

        $assetsUrl = SWIFCEMA_PLUGIN_URL . 'assets/';

        $globalSettings        = get_option('swifcema_global_settings', []);
        $paymentSettingsStripe = get_option('swifcema_payment_settings_stripe', []);
        $paymentSettingsPaypal = get_option('swifcema_payment_settings_paypal', []);

        $isStripeEnabled = $paymentSettingsStripe['enable'] ?? 'no';
        $isPaypalEnabled = $paymentSettingsPaypal['enable'] ?? 'no';

        wp_enqueue_script(
            'swifcema_request_certificate',
            $assetsUrl . 'public/js/swifcema_request_certificate.js',
            ['jquery'],
            SWIFCEMA_VERSION,
            true // footer
        );

        wp_enqueue_script('jquery-ui-datepicker');

        wp_enqueue_style(
            'swifcema_date_picker',
            $assetsUrl . 'public/css/jquery-ui/jquery-ui.css',
            [],
            '1.13.2'
        );

        wp_enqueue_style(
            'swifcema_public_styles',
            $assetsUrl . 'public/css/swifcema-public.css',
            [],
            SWIFCEMA_VERSION
        ); 
      
        $swifcemaPublicVars = apply_filters('swifcema_public_app_vars', [
            'ajaxurl'        => admin_url('admin-ajax.php'),
            'nonce'          => wp_create_nonce('swifcema_public_nonce'),
            'stripe_enabled' => $isStripeEnabled,
            'paypal_enabled' => $isPaypalEnabled,
            'globalSettings' => $globalSettings,
            'currencySymbol' => PaymentHelper::currencySymbol($globalSettings['currency'] ?? 'USD'),
            'has_pro'        => defined('SWIFCEMA_PRO'),
        ]);

        wp_localize_script('swifcema_request_certificate', 'swifcemaPublicVars', $swifcemaPublicVars);
    }
}