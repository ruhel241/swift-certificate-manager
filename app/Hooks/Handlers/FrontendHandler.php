<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Models\Payment;
use SwiftCertificateManager\Helpers\PaymentHelper;
use SwiftCertificateManager\Helpers\ArrayHelper as Arr;
use SwiftCertificateManager\Models\SwiftCertificateManagerGenerate;
use SwiftCertificateManager\Models\SwiftCertificateManagerTemplates;
use SwiftCertificateManager\Helpers\HelperFunction;

class FrontendHandler
{
    public function register() {
        add_action('wp_ajax_swift_certificate_manager_public_ajax', array($this, 'ajaxRoutes'));
        add_action('wp_ajax_nopriv_swift_certificate_manager_public_ajax', array($this, 'ajaxRoutes'));
        // when paypal or strip payment success then certificate payment status update
        add_action('swift_certificate_manager_after_payment_success', array($this, 'paymentConfirmationAfterPaymentSuccess'));

        $this->registerShortcodes();  

        if ( defined('SWIFT_CERTIFICATE_MANAGER_MANAGER_PRO') ) {
            // // Load payment gateways for frontend to render payment options in certificate request form
            new \SwiftCertificateManagerPro\Services\Integrations\PayPal\PayPal();
            new \SwiftCertificateManagerPro\Services\Integrations\Stripe\Stripe();
        }
       
    }

    public function ajaxRoutes()
    {
        // Nonce check (CSRF protection)
        if (!check_ajax_referer('swiftcertificate_public_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // Route (only sanitized from request)
        $route = sanitize_text_field(wp_unslash($_REQUEST['route'] ?? ''));

        if (empty($route)) {
            wp_send_json_error([
                'message' => __('Route is required', 'swift-certificate-manager')
            ], 400);
        }

        // Route map
        $maps = [
            'request_certificate_info' => 'requestCertificateInfo',
            'verify_certificate'       => 'verifyCertificate',
        ];

        if (!isset($maps[$route])) {
            wp_send_json_error([
                'message' => __('Invalid route', 'swift-certificate-manager')
            ], 400);
        }

        // Decide request method based on route
        if ($route === 'verify_certificate') {
            $requestData = $_GET;   // read-only operation
        } else {
            $requestData = $_POST;  // write / normal actions
        }

        
        // Validate route
        if (!isset($maps[$route])) {
            wp_send_json_error([
                'message' => __('Invalid route', 'swift-certificate-manager')
            ], 400);
        }

        // call method
        do_action('swift-certificate-manager/doing_ajax_public_forms_' . $route);

        // Pass raw request (sanitize inside method)
        $this->{$maps[$route]}($_REQUEST);

        do_action('swift-certificate-manager/public_ajax_handler_catch', $route);
    }

    // shortcode register
    public function registerShortcodes()
    {   
        add_shortcode('swift_certificate_manager', function ($attr) {
            $builder =  $this->render($attr);
            return $builder; 
        });
    }

    public function render($attr)
    {
       $this->loadAssets();

        ob_start();
            foreach($attr as $name ) {
                if ($name === 'request-swift-certificate-manager') {
                    $this->shortcodeRenderRequestForm();
                }

                if ($name === 'verify-swift-certificate-manager') {
                    $this->shortcodeRenderVerifyForm();
                }
            }

            if (isset($attr['wscm_invoice'])) {
                $this->getInvoice();
            }

        $html = ob_get_clean();

        return apply_filters('swift-certificate-manager/rendered_post_html', $html);
    }

    public function shortcodeRenderRequestForm() {
        require_once SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/views/public/request-certificate.php';

        $paymentSettingsStripe = get_option('swift_certificate_manager_payment_settings_stripe', []);
        $paymentSettingsPaypal = get_option('swift_certificate_manager_payment_settings_paypal', []);

        $isStripeEnabled = isset($paymentSettingsStripe['enable']) ? $paymentSettingsStripe['enable'] : 'no';
        $isPaypalEnabled = isset($paymentSettingsPaypal['enable']) ? $paymentSettingsPaypal['enable'] : 'no';

        if ($isStripeEnabled === 'yes') {
            do_action('swift_certificate_manager_render_component_stripe');
        }
        if ($isPaypalEnabled === 'yes') {
            do_action('swift_certificate_manager_render_component_paypal');
        }
    }

    public function shortcodeRenderVerifyForm() {
        require_once SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/views/public/verify-certificate.php';
    }

    public function getInvoice()
    {
        require_once SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/views/public/payment-invoice.php';
    }

    public function requestCertificateInfo($request)
    {
        // ✅ validate info
        if (!isset($request['info']) || !is_array($request['info'])) {
            wp_send_json_error([
                'message' => __('Invalid request data', 'swift-certificate-manager')
            ], 400);
        }

        $info = $request['info'];

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

        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();
        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();
        $helperFunction            = new HelperFunction();

        // settings
        $globalSettings = get_option('swift_certificate_manager_global_settings', []);
        $preference     = sanitize_key($globalSettings['preference'] ?? '');

        // generate code
        $certificateCodePrefix = $globalSettings['certificate_code_prefix'] ?? '';
        $certificateCode       = $helperFunction->generateCertificateCode($certificateCodePrefix);

        // template
        $activeTemplate = get_option('swift_certificate_manager_active_template', 'template-1');
        $getTemplate    = $SwiftCertificateManagerTemplates->getTemplateSlug($activeTemplate);

        if (!$getTemplate) {
            wp_send_json_error([
                'message' => __('Template not found', 'swift-certificate-manager')
            ], 404);
        }

        $settings = json_decode($getTemplate->settings, true);

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

        $certificateGenerateId = $SwiftCertificateManagerGenerate->insertGetId($data);
        $certificateData       = $SwiftCertificateManagerGenerate->getInfo($certificateGenerateId);

        // ⚠️ pass sanitized info only
        $this->paymentCreate($info, $certificateGenerateId);

        wp_send_json_success([
            'message' => __("Successfully Requested Certificate", 'swift-certificate-manager'),
            'info'    => $certificateData
        ], 200);
    }

    public function verifyCertificate($request)
    {
        if (empty($request['certificate_code'])) {
            wp_send_json_error([
                'message' => __('Certificate code is required', 'swift-certificate-manager')
            ], 400);
        }

        // 🔐 sanitize input
        $certificateCode = sanitize_text_field($request['certificate_code']);

        $SwiftCertificateManagerGenerate = new SwiftCertificateManagerGenerate();

        $info = $SwiftCertificateManagerGenerate->verifyCertificateCode($certificateCode);

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
        $paymentTotal  = floatval(Arr::get($info, 'payment_total'));
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
        $key = "swift_certificate_manager_payment_settings_" . $paymentMethod;

        $paymentSettings = get_option($key, []);
        $isEnabled = $paymentSettings['enable'] ?? 'no';

        if ($isEnabled !== 'yes') {
            return;
        }

        if ($status !== 'request') {
            return;
        }

        // 🔐 generate safe hash
        $hash = sanitize_text_field($this->generateHash());

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

        $paymentId = (new Payment())->insertGetId($paymentData);

        // 💳 trigger payment only if amount valid
        if ($paymentTotal > 0) {
            do_action(
                'swift_certificate_manager_make_payment_' . $paymentMethod,
                $certificateGenerateId,
                $paymentId
            );
        }
    }

    private function generateHash()
    {
        return 'swift_certificate_manager_' . wp_generate_uuid4();
    }

     // when paypal or stripe paid then generate certificate payment status update
    public function paymentConfirmationAfterPaymentSuccess($hash) {
        if (empty($hash)) {
            return;
        }

        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();
        $payment = (new Payment())->getHash($hash);
        $paymentStatus = $payment->payment_status;

        $GenerateData = [
            'payment_status' => $paymentStatus,
            'updated_at' => gmdate('Y-m-d H:i:s')
        ];
        
        $SwiftCertificateManagerGenerate->updateInfo($payment->request_id, $GenerateData);
    }

    public function loadAssets() {
        static $loaded = false;
        
        if ($loaded) return;

        $loaded = true;

        $assetsUrl = SWIFT_CERTIFICATE_MANAGER_PLUGIN_URL . 'assets/';

        $globalSettings        = get_option('swift_certificate_manager_global_settings', []);
        $paymentSettingsStripe = get_option('swift_certificate_manager_payment_settings_stripe', []);
        $paymentSettingsPaypal = get_option('swift_certificate_manager_payment_settings_paypal', []);

        $isStripeEnabled = $paymentSettingsStripe['enable'] ?? 'no';
        $isPaypalEnabled = $paymentSettingsPaypal['enable'] ?? 'no';

        wp_enqueue_script(
            'wscm_request_certificate',
            $assetsUrl . 'public/js/wscm_request_certificate.js',
            ['jquery'],
            SWIFT_CERTIFICATE_MANAGER_VERSION,
            true // footer
        );

        wp_enqueue_script('jquery-ui-datepicker');

        wp_enqueue_style(
            'wscm_date_picker',
            $assetsUrl . 'public/css/jquery-ui/jquery-ui.css',
            [],
            '1.13.2'
        );

        wp_enqueue_style(
            'wscm_public_styles',
            $assetsUrl . 'public/css/swift-certificate-manager-public.css',
            [],
            SWIFT_CERTIFICATE_MANAGER_VERSION
        ); 
      
        // $helperFunction = new HelperFunction();
    
        $scPublicVars = apply_filters('swift-certificate-manager/public_app_vars', [
            'ajaxurl'        => admin_url('admin-ajax.php'),
            'nonce'          => wp_create_nonce('swiftcertificate_public_nonce'),
            'stripe_enabled' => $isStripeEnabled,
            'paypal_enabled' => $isPaypalEnabled,
            'globalSettings' => $globalSettings,
            'currencySymbol' => PaymentHelper::currencySymbol($globalSettings['currency'] ?? 'USD'),
            'has_pro'        => defined('SWIFT_CERTIFICATE_MANAGER_PRO'),
        ]);

        wp_localize_script('wscm_request_certificate', 'SwiftCertificateManagerPublicVars', $scPublicVars);
    }
}