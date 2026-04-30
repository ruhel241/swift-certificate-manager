<?php

namespace SwiftCertificateManager\Hooks\Handlers;

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

class TemplatesManager
{
    private $github_repo = 'https://raw.githubusercontent.com/ruhel241/swift-certificate-manager-image-templates/main/';

    public function getCoreTemplates()
    {
        $file = SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/Libs/certificate-templates.json';

        if (!file_exists($file)) {
            return [];
        }

        $json = file_get_contents($file);
        return json_decode($json, true);
    }

    public function getDownloadableTemplates($limit = 0)
    {
        $templateDir = $this->getTemplateDir();

        if (!function_exists('\list_files')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $downloadedFiles = \list_files($templateDir, 1);

        $fileNames = [];
        foreach ($downloadedFiles as $file) {
            $fileNames[] = basename($file);
        }

        $coreTemplates = $this->getCoreTemplates();
        $downloadableTemplates = [];

        foreach ($coreTemplates as $coreTemplate) {

            if ($limit && count($downloadableTemplates) >= $limit) {
                break;
            }

            if (!in_array($coreTemplate['name'], $fileNames)) {
                $downloadableTemplates[] = $coreTemplate;
            }
        }

        return $downloadableTemplates;
    }

    public function download($templateName)
    {
        // 🔒 sanitize file name
        $templateName = sanitize_file_name($templateName);

        // 🔒 allow only specific extensions
        $allowed_extensions = ['json', 'png', 'jpg', 'jpeg', 'webp'];

        $ext = pathinfo($templateName, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $allowed_extensions)) {
            return new \WP_Error('invalid_file', __('Invalid file type', 'swift-certificate-manager'));
        }

        $destination = trailingslashit($this->getTemplateDir());

        // 🔒 prevent overwrite
        $file_path = $destination . $templateName;
        if (file_exists($file_path)) {
            return true; // already exists
        }

        // 🔒 safe remote request
        $response = wp_remote_get(
            esc_url_raw($this->github_repo . $templateName),
            [
                'timeout' => 30,
            ]
        );

        if (is_wp_error($response)) {
            return $response;
        }

        $code = wp_remote_retrieve_response_code($response);
        if ($code !== 200) {
            return new \WP_Error('download_failed', __('Template download failed', 'swift-certificate-manager'));
        }

        $body = wp_remote_retrieve_body($response);

        if (empty($body)) {
            return new \WP_Error('empty_file', __('Empty file received', 'swift-certificate-manager'));
        }

        // 🔒 save file safely
        $saved = file_put_contents($file_path, $body);

        if (!$saved) {
            return new \WP_Error('write_failed', __('Failed to save template', 'swift-certificate-manager'));
        }

        return true;
    }

    private function getTemplateDir()
    {
        $dirStructure = AvailableOptions::getDirStructure();
        return trailingslashit($dirStructure['certificatesDir']);
    }
}