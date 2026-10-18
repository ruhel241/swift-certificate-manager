<?php

namespace Arimtiaz\SwiftCertificateManager\Hooks\Handlers;
use Arimtiaz\SwiftCertificateManager\Models\SwifCeMaTemplates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TemplatesManager
{
    public function getCoreTemplates()
    {
        $file = SWIFCEMA_PLUGIN_DIR_PATH . 'app/Libs/certificate-templates.json';
    
        if (!file_exists($file)) {
            return [];
        }
    
        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading a local file bundled with the plugin.
        $json = file_get_contents($file);
    
        return json_decode($json, true);
    }
    
    public function getDownloadableTemplates($limit = 0)
    {
        $coreTemplates = $this->getCoreTemplates();
    
        $SwifCeMaTemplates = new SwifCeMaTemplates();
        $getTemplates = $SwifCeMaTemplates->getTemplates();

        // Existing template slug collect
        $existingSlugs = [];
    
        foreach ($getTemplates as $template) {
            $existingSlugs[] = $template->slug;
        }
    
        $downloadableTemplates = [];
    
        foreach ($coreTemplates as $coreTemplate) {
    
            if ($limit && count($downloadableTemplates) >= $limit) {
                break;
            }
    
            if (!in_array($coreTemplate['slug'], $existingSlugs, true)) {
                $downloadableTemplates[] = $coreTemplate;
            }
        }
    
        return $downloadableTemplates;
    }
}