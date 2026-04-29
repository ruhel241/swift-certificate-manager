<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

class OnboardingHandler
{
    public function registerEndpoints()
    {
        add_action('wp_ajax_swift_certificate_manager_onboarding_info_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
        // 🔐 Nonce check (CSRF protection)
        if (!check_ajax_referer('swiftcertificate_admin_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // Permission
        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                'message' => __('Unauthorized access', 'swift-certificate-manager')
            ], 403);
        }

        $route = sanitize_text_field(wp_unslash($_REQUEST['route'] ?? ''));


        $maps = array(
           'save_onboarding_info' => 'saveOnboardingInfo',
           'save_onboarded'       => 'saveOnboarded',
        );

          // Validate route
        if (!isset($maps[$route])) {
            wp_send_json_error([
                'message' => __('Invalid route', 'swift-certificate-manager')
            ], 400);
        }

        // call method
        do_action('swift-certificate-manager/doing_ajax_onboarding_' . $route);

        // Pass raw request (sanitize inside method)
        $this->{$maps[$route]}($_REQUEST);

        do_action('swift-certificate-manager/admin_ajax_handler_onboarding_catch', $route);
    }

    public function saveOnboardingInfo($request)
    {
        if (!isset($request['info']) || !is_array($request['info'])) {
            wp_send_json_error([
                'message' => __("Invalid onboarding data", 'swift-certificate-manager')
            ], 403);
        }

        // 🔐 sanitize full info array
        $info = $this->sanitizeArray(wp_unslash($request['info']));

        $preference = sanitize_key($info['preference'] ?? '');

        // optional safety fallback
        if (empty($preference)) {
            $preference = 'default';
        }

        // 💾 save onboarding info safely
        update_option('swift_certificate_manager_onboarding_info', $info);

        // 🧠 update global settings safely
        $globalSettings = get_option('swift_certificate_manager_global_settings', []);

        if (!is_array($globalSettings)) {
            $globalSettings = [];
        }

        $globalSettings['instructor_name']                 = sanitize_text_field($info['instructor_name'] ?? '');
        $globalSettings['instructor_signature']            = sanitize_text_field($info['instructor_signature'] ?? '');
        $globalSettings['instructor_signature_img']        = sanitize_text_field($info['instructor_signature_img'] ?? '');
        $globalSettings['instructor_signature_img_enable'] = sanitize_text_field($info['instructor_signature_img_enable'] ?? 'no');

        $globalSettings['company_name']                     = sanitize_text_field($info['company_name'] ?? '');
        $globalSettings['company_signature']                = sanitize_text_field($info['company_signature'] ?? '');
        $globalSettings['company_signature_img']            = sanitize_text_field($info['company_signature_img'] ?? '');
        $globalSettings['company_signature_img_enable']     = sanitize_text_field($info['company_signature_img_enable'] ?? 'no');

        $globalSettings['preference'] = $preference;

        update_option('swift_certificate_manager_global_settings', $globalSettings);

        wp_send_json_success([
            'message' => __("Onboarding saved successfully", 'swift-certificate-manager')
        ]);
    }

    public function saveOnboarded($request)
    {
        if (!isset($request['is_onboarded']) || empty($request['is_onboarded'])) {
            wp_send_json_error(array(
                'message' => __("Invalid onboarded status", 'swift-certificate-manager')
            ), 403);
        }

        $isOnboarded = sanitize_text_field($request['is_onboarded']);

        $saveIsOnboarded = update_option('swift_certificate_manager_is_onboarded', $isOnboarded);

        if (!$saveIsOnboarded) {
            wp_send_json_error(array(
                'message' => __("Failed to save onboarding", 'swift-certificate-manager')
            ), 403);
        }

        wp_send_json_success(array(
            'message' => __("saved onboarding successfully", 'swift-certificate-manager')
        ));
    }

    private function sanitizeArray($data)
    {
        if (!is_array($data)) {
            return sanitize_text_field($data);
        }

        foreach ($data as $key => $value) {
            $data[$key] = is_array($value)
                ? $this->sanitizeArray($value)
                : sanitize_text_field($value);
        }

        return $data;
    }
}