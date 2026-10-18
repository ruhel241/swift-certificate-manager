<?php

namespace Arimtiaz\SwiftCertificateManager\Models;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class SwifCeMaTemplates {

    protected $table;

    public function __construct() {
        global $wpdb;

        $this->table = $wpdb->prefix . 'swifcema_templates';
    }

    public function getTemplates() {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; query has no external values.
        return $wpdb->get_results( "SELECT * FROM {$this->table} ORDER BY id ASC" );
    }

    public function getTemplate($id) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current template record.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; ID uses a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE id = %d",
                absint($id)
            )
        );
    }

    public function getTemplateSlug($slug) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current template record by slug.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; slug uses a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE slug = %s",
                $slug
            )
        );
    }

    public function isSlug($slug) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Check whether a template slug already exists.
        $template = $wpdb->get_var(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; slug uses a prepared placeholder.
                "SELECT id FROM {$this->table} WHERE slug = %s LIMIT 1",
                $slug
            )
        );

        return !empty($template);
    }

    public function insertGetId($data) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Insert a template record into the plugin's custom table.
        $wpdb->insert(
            $this->table,
            $data
        );

        return $wpdb->insert_id;
    }

    public function updateInfo($id, $data) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Update the plugin's custom template table directly.
        return $wpdb->update(
            $this->table,
            $data,
            [
                'id' => absint($id),
            ],
            null,
            [
                '%d',
            ]
        );
    }
}