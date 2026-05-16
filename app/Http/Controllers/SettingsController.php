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


        $route = sanitize_key(wp_unslash($_REQUEST['route'] ?? ''));

        $maps = array(
            'get_settings'          => 'getSettings',
            'save_settings'         => 'saveSettings',
        );

        if (!isset($maps[$route])) {
            wp_send_json_error([
                'message' => __('Invalid route', 'swift-certificate-manager')
            ], 400);
        }

        do_action('swiftcm_doing_ajax_settings_' . $route);

        // Pass request (already sanitized inside methods)
        $this->{$maps[$route]}($_REQUEST);

        do_action('swiftcm_admin_ajax_handler_settings_catch', $route);
    }

    public function getSettings($request)
    {
        $settings = get_option('swiftcm_global_settings', array());

        wp_send_json_success(array(
            'settings' => $settings
        ));
    }

    public function saveSettings($request)
    {
        if (!isset($request['settings']) || !is_array($request['settings'])) {
            wp_send_json_error([
                'message' => __('Invalid settings', 'swift-certificate-manager')
            ], 400);
        }

        // ✅ sanitize full settings array safely
        $settings = $this->sanitizeArray(wp_unslash($request['settings']));

        $this->handleNewsletter($settings);

        update_option('swiftcm_global_settings', $settings);

        wp_send_json_success([
            'message' => __('Settings saved successfully.', 'swift-certificate-manager')
        ]);
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

        $subject = sanitize_text_field('Swift Certificate Manager Plugin - New Subscriber');

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

    public function clearCache()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}