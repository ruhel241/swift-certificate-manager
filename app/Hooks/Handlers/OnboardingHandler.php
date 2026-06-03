<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OnboardingHandler
{
    public function registerEndpoints()
    {
        add_action('wp_ajax_swiftcm_onboarding_info_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
        if (!check_ajax_referer('swiftcm_admin_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                'message' => __('Unauthorized access', 'swift-certificate-manager')
            ], 403);
        }

        $route = sanitize_key( wp_unslash($_REQUEST['route'] ?? '') );

        if (!$route) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $validRoutes = [
            'save_onboarding_info' => 'saveOnboardingInfo',
            'save_onboarded'       => 'saveOnboarded',
        ];

        if (!isset($validRoutes[$route])) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $this->{$validRoutes[$route]}();

        do_action('swiftcm_admin_ajax_handler_onboarding_catch', $route);

        wp_die();
    }

    public function saveOnboardingInfo()
    {
        $info = (array) wp_unslash($_REQUEST['info'] ?? []);
    
        if (empty($info)) {
            wp_send_json_error([
                'message' => __('Invalid onboarding data', 'swift-certificate-manager')
            ], 400);
        }
    
        $preference = sanitize_key($info['preference'] ?? '');

        if (!$preference) {
            $preference = 'default';
        }
    
        // 🔐 Sanitize ONCE only
        $onboardingInfo = [
            'instructor_name'                 => sanitize_text_field($info['instructor_name'] ?? ''),
            'instructor_signature'            => sanitize_text_field($info['instructor_signature'] ?? ''),
            'instructor_signature_img'        => esc_url_raw($info['instructor_signature_img'] ?? ''),
            'instructor_signature_img_enable' => sanitize_text_field($info['instructor_signature_img_enable'] ?? 'no'),
            'company_name'                    => sanitize_text_field($info['company_name'] ?? ''),
            'company_signature'               => sanitize_text_field($info['company_signature'] ?? ''),
            'company_signature_img'           => esc_url_raw($info['company_signature_img'] ?? ''),
            'company_signature_img_enable'    => sanitize_text_field($info['company_signature_img_enable'] ?? 'no'),
            'preference'                      => $preference,
        ];
    
        // 💾 Save onboarding info
        update_option('swiftcm_onboarding_info', $onboardingInfo);
    
        // 🧠 Merge with global settings (NO re-sanitization)
        $globalSettings = get_option('swiftcm_global_settings', []);
        
        if (!is_array($globalSettings)) {
            $globalSettings = [];
        }
    
        $globalSettings = array_merge($globalSettings, [
            'instructor_name'                 => $onboardingInfo['instructor_name'],
            'instructor_signature'            => $onboardingInfo['instructor_signature'],
            'instructor_signature_img'        => $onboardingInfo['instructor_signature_img'],
            'instructor_signature_img_enable' => $onboardingInfo['instructor_signature_img_enable'],
            'company_name'                    => $onboardingInfo['company_name'],
            'company_signature'               => $onboardingInfo['company_signature'],
            'company_signature_img'           => $onboardingInfo['company_signature_img'],
            'company_signature_img_enable'    => $onboardingInfo['company_signature_img_enable'],
            'preference'                      => $onboardingInfo['preference'],
        ]);
    
        update_option('swiftcm_global_settings', $globalSettings);
    
        wp_send_json_success([
            'message' => __("Onboarding saved successfully", 'swift-certificate-manager')
        ]);
    }

    public function saveOnboarded()
    {
        $isOnboarded = sanitize_text_field(
            wp_unslash($_REQUEST['is_onboarded'] ?? '')
        );

        if ($isOnboarded === '') {
            wp_send_json_error([
                'message' => __('Invalid onboarded status', 'swift-certificate-manager')
            ], 400);
        }

        update_option('swiftcm_is_onboarded', $isOnboarded);

        wp_send_json_success([
            'message' => __('Saved onboarding successfully', 'swift-certificate-manager')
        ]);
    }

    // private function sanitizeArray( $data ) {

    //     if ( ! is_array( $data ) ) {
    //         return sanitize_text_field( (string) $data );
    //     }
    
    //     foreach ( $data as $key => $value ) {
    
    //         $data[ $key ] = is_array( $value )
    //             ? $this->sanitizeArray( $value )
    //             : sanitize_text_field( (string) $value );
    //     }
    
    //     return $data;
    // }
}