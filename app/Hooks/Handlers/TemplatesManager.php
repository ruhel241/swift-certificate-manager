<?php

namespace SwiftCertificateManager\Hooks\Handlers;
use SwiftCertificateManager\Models\SwiftCertificateManagerTemplates;

class TemplatesManager
{
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
        $coreTemplates = $this->getCoreTemplates();
    
        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();
        $getTemplates = $SwiftCertificateManagerTemplates->getTemplates();
    
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