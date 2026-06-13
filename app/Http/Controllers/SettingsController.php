<?php

namespace SwiftCertificateManager\Http\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Helpers\HelperFunction;


class SettingsController
{
    public function register() {
        add_action('wp_ajax_swiftcm_global_settings_admin_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
        HelperFunction::verifyAdminAjaxRequest();

        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- Nonce verified in verifyAdminAjaxRequest().
        $route = sanitize_key( wp_unslash($_REQUEST['route'] ?? '') );
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

        if (!$route) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $validRoutes = [
            'get_settings'  => 'getSettings',
            'save_settings' => 'saveSettings',
        ];

        if (!isset($validRoutes[$route])) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $this->{$validRoutes[$route]}();

        do_action('swiftcm_admin_ajax_handler_settings_catch', $route);

        wp_die();
    }

    public function getSettings()
    {
        $settings = get_option('swiftcm_global_settings', []);

        wp_send_json_success(array(
            'settings' => $settings
        ));
    }

    public function saveSettings() 
    {
        HelperFunction::verifyAdminAjaxRequest();
        
        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- Nonce verified in verifyAdminAjaxRequest().
        $rawSettings = isset($_REQUEST['settings']) && is_array($_REQUEST['settings'])
            ? map_deep(wp_unslash($_REQUEST['settings']), 'sanitize_text_field')
            : [];
       // phpcs:enable WordPress.Security.NonceVerification.Recommended

        if (empty($rawSettings)) {
            wp_send_json_error([
                'message' => __('Invalid settings', 'swift-certificate-manager'),
            ], 400);
        }

        $settings = $this->sanitizeArray($rawSettings);
        
        update_option('swiftcm_global_settings', $settings );
    
        wp_send_json_success(
            [
                'message' => __(
                    'Settings saved successfully.',
                    'swift-certificate-manager'
                ),
            ]
        );
    }

    private function sanitizeArray( $data ) {

        if ( ! is_array( $data ) ) {
            return sanitize_text_field( (string) $data );
        }
    
        foreach ( $data as $key => $value ) {
    
            $data[ $key ] = is_array( $value )
                ? $this->sanitizeArray( $value )
                : sanitize_text_field( (string) $value );
        }
    
        return $data;
    }


    // public function sendNoCacheHeaders() {
    //     nocache_headers();
    // }
}