<?php

namespace SwiftCertificateManager\Models;

class SwifCeMaTemplates {

    protected $table;

    public function __construct() {
        global $wpdb;

        $this->table = $wpdb->prefix . 'swifcema_templates';
    }
   
     public function getTemplates() {
        global $wpdb;

        return $wpdb->get_results(
            "SELECT * FROM {$this->table} ORDER BY id ASC"
        );
    }

    public function getTemplate($id) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE id = %d",
                $id
            )
        );
    }

    public function getTemplateSlug($slug) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE slug = %s",
                $slug
            )
        );
    }

    public function isSlug($slug) {
        global $wpdb;

        $template = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT id FROM {$this->table} WHERE slug = %s LIMIT 1",
                $slug
            )
        );

        return !empty($template);
    }

    public function insertGetId($data) {
        global $wpdb;

        $wpdb->insert(
            $this->table,
            $data
        );

        return $wpdb->insert_id;
    }

    public function updateInfo($id, $data) {
        global $wpdb;

        return $wpdb->update(
            $this->table,
            $data,
            [
                'id' => $id,
            ],
            null,
            [
                '%d',
            ]
        );
    }
}