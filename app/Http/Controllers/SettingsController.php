<?php

namespace SwiftCertificateManager\Http\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SettingsController
{
    public function register() {
        add_action('wp_ajax_swiftcm_global_settings_admin_ajax', array($this, 'ajaxRoutes'));
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

    public function saveSettings() {
        $settings = isset($_REQUEST['settings']) && is_array($_REQUEST['settings'])
        ? wp_unslash($_REQUEST['settings'])
        : [];


        if (empty($settings)) {
            wp_send_json_error([
                'message' => __('Invalid settings', 'swift-certificate-manager'),
            ], 400);
        }

        $settings = $this->sanitizeArray(
            wp_unslash($_REQUEST['settings'])
        );
    
        $this->handleNewsletter( $settings );
    
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

    public function handleNewsletter($settings)
    {
        $email = sanitize_email($settings['newsletter'] ?? '');
        $terms = sanitize_text_field($settings['terms_and_condition'] ?? 'no');

        if (empty($email) || !is_email($email)) {
            return;
        }

        if ($terms !== 'yes') {
            return;
        }

        $stored = get_option('swiftcm_newsletters', []);
        $emails = $stored['emails'] ?? [];

        if (!is_array($emails)) {
            $emails = [];
        }

        if (in_array($email, $emails, true)) {
            return;
        }

        $result = $this->subscribeToNewsletter($email);

        if (!is_wp_error($result)) {
            $emails[] = $email;

            update_option('swiftcm_newsletters', [
                'emails' => $emails
            ]);
        }
    }

    public function subscribeToNewsletter($email)
    {
        $email = sanitize_email($email);

        if (!is_email($email)) {
            return new \WP_Error('invalid_email', __('Invalid email address.', 'swift-certificate-manager'));
        }

        $pluginCreatorEmail = 'info@swiftcertificate.com';

        $subject = 'Swift Certificate Manager Plugin - New Subscriber';

        $message = "
            <h2>Swift Certificate Manager Plugin - New Subscription</h2>
            <p><strong>Email:</strong> " . esc_html($email) . "</p>
            <p><strong>Date:</strong> " . esc_html(gmdate('F j, Y, g:i a')) . "</p>
        ";

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $sent = wp_mail($pluginCreatorEmail, $subject, $message, $headers);

        if (!$sent) {
            return new \WP_Error('email_failed', __('Email sending failed.', 'swift-certificate-manager'));
        }

        return true;
    }

    // public function sendNoCacheHeaders() {
    //     nocache_headers();
    // }
}