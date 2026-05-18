<?php

namespace SwiftCertificateManager\Models;

class SwiftCMTemplates {

    protected $table = 'swiftcm_templates';
   
    public function getTemplates() {
        
        $templates = swiftcm_query()->table($this->table)
                ->orderBy('id', 'ASC')
                ->get();

        return $templates;
    }

    public function getTemplate($id)
    {
        $template = swiftcm_query()->table($this->table)->where('id', $id)->first();

        return $template;
    }

    public function getTemplateSlug($slug)
    {
        $template = swiftcm_query()->table($this->table)->where('slug', $slug)->first();
        return $template;
    }

    public function isSlug($slug) {
        $isSlug =  swiftcm_query()->table($this->table)->where('slug', $slug)->first();

        if ($isSlug) {
            return true;
        }

        return false;
    }

    public function insertGetId($data) {
        $save = swiftcm_query()->table($this->table)->insert($data);

        return $save;
    }


    public function updateInfo($id, $data) {
       
        $update = swiftcm_query()->table($this->table)
                ->where('id', $id)
                ->update($data);

        return $update; 
    }
}