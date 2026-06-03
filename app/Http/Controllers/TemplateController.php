<?php

namespace SwiftCertificateManager\Http\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Hooks\Handlers\TemplatesManager;
use SwiftCertificateManager\Helpers\ArrayHelper as Arr;
use SwiftCertificateManager\Hooks\Handlers\AdminPageHandler;
use SwiftCertificateManager\Models\SwiftCMTemplates;
use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

class TemplateController
{
    public function register() {
        add_action('wp_ajax_swiftcm_template_admin_ajax', array($this, 'ajaxRoutes'));
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
            'get_active_template'   => 'getActiveTemplate',
            'save_active_template'  => 'saveActiveTemplate',
            'get_templates'         => 'getTemplates',
            'get_template'          => 'getEditTemplate',
            'update_template'       => 'updateTemplate',
            'save_templates'        => 'saveTemplates',
            'redesign_template'     => 'redesignTemplate'
        ];

        if (!isset($validRoutes[$route])) {
            wp_send_json_error(['message' => 'Invalid route'], 400);
        }

        $this->{$validRoutes[$route]}();

        do_action('swiftcm_admin_ajax_handler_template_catch', $route);

        wp_die();
    }

    public function getActiveTemplate() {
        wp_send_json_success([
            'message' => __('get Activated Certificate', 'swift-certificate-manager'),
            'active_template' => get_option('swiftcm_active_template', 'template-1')
        ]);
    }

    public function saveActiveTemplate()
    {
        $slug = sanitize_key($_REQUEST['slug'] ?? '');

        if (!$slug) {
            wp_send_json_error(
                [
                    'message' => __('Invalid template slug', 'swift-certificate-manager')
                ], 400);
        }

        update_option('swiftcm_active_template', $slug);

        wp_send_json_success([
            'active_template' => get_option('swiftcm_active_template', 'template-1'),
            'message' => __('Successfully Active Template', 'swift-certificate-manager')
        ]);
    }

    public function getTemplates()
    {
        $SwiftCMTemplates = new SwiftCMTemplates();
    
        $getTemplates = $SwiftCMTemplates->getTemplates();
    
        usort($getTemplates, function ($a, $b) {
            return strnatcmp($a->slug, $b->slug);
        });
    
        wp_send_json_success([
            'message'   => __('Get Templates', 'swift-certificate-manager'),
            'templates' => $getTemplates
        ], 200);
    }

    public function getEditTemplate()
    {
        $templateId = absint($_REQUEST['template_id'] ?? 0);

        if (!$templateId) {
            wp_send_json_error(['message' => __('Template ID is required', 'swift-certificate-manager')], 400);
        }

        $SwiftCMTemplates = new SwiftCMTemplates();
        $template = $SwiftCMTemplates->getTemplate($templateId);

        if (!$template) {
            wp_send_json_error(['message' => __('Template not found', 'swift-certificate-manager')], 404);
        }

        wp_send_json_success([
            'message' => __('Get Template', 'swift-certificate-manager'),
            'template' => $template,
            'fonts'    => AvailableOptions::getInstalledFonts()
        ]);
    }

    public function updateTemplate()
    {
        $template = isset($_REQUEST['template']) && is_array($_REQUEST['template'])
        ? wp_unslash($_REQUEST['template'])
        : [];

        if (!is_array($template)) {
            wp_send_json_error(['message' => __('Invalid template data', 'swift-certificate-manager')], 400);
        }

        $templateId = absint($template['id'] ?? 0);

        if (!$templateId) {
            wp_send_json_error(['message' => __('Invalid template ID', 'swift-certificate-manager')], 400);
        }

        $settings = Arr::get($template, 'settings');

        if (!is_array($settings)) {
            wp_send_json_error(['message' => __('Invalid settings', 'swift-certificate-manager')], 400);
        }

        $settings = $this->sanitizeArray($settings);

        $SwiftCMTemplates = new SwiftCMTemplates();

        $updateData = [
            'settings'   => wp_json_encode($settings),
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $this->updateingGolbalSettingsInfo($settings);

        $SwiftCMTemplates->updateInfo($templateId, $updateData);

        wp_send_json_success([
            'message' => __('Successfully Updated', 'swift-certificate-manager'),
        ]);
    }

    public function saveTemplates()
    {
        $templateManager = new TemplatesManager();
        $SwiftCMTemplates = new SwiftCMTemplates();

        $downloadableFiles = $templateManager->getDownloadableTemplates();

        // Array empty check
        if (empty($downloadableFiles)) {
            wp_send_json_error([
                // 'message' => __('No templates available to install', 'swift-certificate-manager'),
                'downloaded_files' => $downloadableFiles,
            ], 404);
        }

        $getConfigTemplates = AvailableOptions::getConfig();

        $downloadedFiles = [];

        foreach ($downloadableFiles as $template) {
            $templateName  = $template['template_name'];
            $templateImage = $template['template_image'];
            $slug          = $template['slug'];
            $templatePro   = $template['pro'];
            $settings      = isset($getConfigTemplates[$slug]) ? wp_unslash($getConfigTemplates[$slug]) : [];

            $data = [
                'template_name'  => sanitize_text_field($templateName),
                'slug'           => sanitize_title($slug),
                'template_image' => sanitize_text_field($templateImage),
                'pro'            => intval($templatePro),
                'settings'       => wp_json_encode($settings),
                'created_at'     => gmdate('Y-m-d H:i:s'),
                'updated_at'     => gmdate('Y-m-d H:i:s'),
            ];

            $res = $SwiftCMTemplates->insertGetId($data);

            if ($res) {
                $downloadedFiles[] = $slug;
            }
        }

        wp_send_json_success([
            'downloaded_files' => $downloadedFiles,
            'message'          => __('Templates Installed Successfully', 'swift-certificate-manager')
        ], 200);
    }
    

    public function updateingGolbalSettingsInfo($settings)
    {
        $existing = get_option('swiftcm_global_settings', []);

        if (!is_array($existing)) {
            $existing = [];
        }

        $preference = sanitize_key($existing['preference'] ?? '');

        $instructorInfo = [
            $preference . '_name'                 => sanitize_text_field($settings['instructor_name'] ?? ''),
            $preference . '_signature'            => sanitize_text_field($settings['instructor_signature'] ?? ''),
            $preference . '_signature_img'        => sanitize_text_field($settings['instructor_signature_img'] ?? ''),
            $preference . '_signature_img_enable' => sanitize_text_field($settings['instructor_signature_img_enable'] ?? ''),
        ];

        update_option('swiftcm_global_settings', array_merge($existing, $instructorInfo));
    }

    public function redesignTemplate()
    {
        $templateId = absint($_REQUEST['template_id'] ?? 0);

        if (!$templateId) {
            wp_send_json_error(['message' => __('Template ID is required', 'swift-certificate-manager')], 400);
        }

        $SwiftCMTemplates = new SwiftCMTemplates();
        $template = $SwiftCMTemplates->getTemplate($templateId);

        if (!$template) {
            wp_send_json_error(['message' => __('Template not found', 'swift-certificate-manager')], 404);
        }

        $slug = sanitize_key($template->slug ?? '');

        $config = AvailableOptions::getConfig();
        $settings = $config[$slug] ?? [];

        $SwiftCMTemplates->updateInfo($templateId, [
            'settings'   => wp_json_encode($settings),
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ]);

        wp_send_json_success([
            'message' => __('Successfully Redesigned Template', 'swift-certificate-manager')
        ]);
    }

    /* -----------------------------------------
     * SAFE SANITIZER
     * ----------------------------------------- */
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