<?php

namespace SwiftCertificateManager\Models;

class SwiftCertificateManagerTemplates {

    protected $table = 'scm_templates';
   
    public function getTemplates() {
        
        $templates = SwiftCertificateManagerQuery()->table($this->table)
                ->orderBy('id', 'ASC')
                ->get();

        return $templates;
    }

    public function getTemplate($id)
    {
        $template = SwiftCertificateManagerQuery()->table($this->table)->where('id', $id)->first();

        return $template;
    }

    public function getTemplateSlug($slug)
    {
        $template = SwiftCertificateManagerQuery()->table($this->table)->where('slug', $slug)->first();
        return $template;
    }

    public function isSlug($slug) {
        $isSlug =  SwiftCertificateManagerQuery()->table($this->table)->where('slug', $slug)->first();

        if ($isSlug) {
            return true;
        }

        return false;
    }

    public function insertGetId($data) {
        $save = SwiftCertificateManagerQuery()->table($this->table)->insert($data);

        return $save;
    }


    public function updateInfo($id, $data) {
       
        $update = SwiftCertificateManagerQuery()->table($this->table)
                ->where('id', $id)
                ->update($data);

        return $update; 
    }
}