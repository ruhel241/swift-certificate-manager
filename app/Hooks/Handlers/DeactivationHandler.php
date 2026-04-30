<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DeactivationHandler
{
    public static function deActivate($network_wide)
    {
        if (is_multisite()) {
            return;
        }

        // remove the cron job
        wp_clear_scheduled_hook('swift_certificate_manager_cleanup_tmp_dir');

        if (!class_exists('\SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
            require_once SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
        } 
        
        $dirs = AvailableOptions::getDirStructure();

        /* delete folders that need to be checked */
        $folders = [
            $dirs['tempDir'],
            $dirs['pdfCacheDir'],
            $dirs['fontDir'],
            $dirs['certificatesDir'],
        ];

        if(!class_exists('\WP_Filesystem_Direct')) {
            $admin_path = ABSPATH .'/wp-admin/';
            if(!class_exists('\WP_Filesystem_Base')) {
                include_once $admin_path.'includes/class-wp-filesystem-base.php';
            }
            include_once $admin_path.'includes/class-wp-filesystem-direct.php';
        }

        $fileSystem = new \WP_Filesystem_Direct([]);

        foreach ($folders as $folder) {
            $fileSystem->delete($folder, true);
        }

       /**
       *  Delete all tables and options
       */
        static::dropTables();
    }

    public static function dropTables()
    {
        global $wpdb;
        
        // delete options all options
        delete_option('swift_certificate_manager_global_settings');
        delete_option('swift_certificate_manager_onboarding_info');
        delete_option('swift_certificate_manager_is_onboarded');
        delete_option('swift_certificate_manager_newsletters');


        // Disable foreign key checks temporarily
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 0");

        // List all tables to be deleted
        $tables = [
            $wpdb->prefix . 'wscm_generates',
            $wpdb->prefix . 'wscm_payments',
            $wpdb->prefix . SWIFT_CERTIFICATE_MANAGER_UPLOAD_DIR
        ];

        // Drop each table
        foreach ($tables as $table) {
            // Format for DROP TABLE using string concatenation outside the query
            // This is the WordPress core pattern for handling table names
            $table_name = '`' . esc_sql($table) . '`';
            $wpdb->query("DROP TABLE IF EXISTS $table_name");
        }

        // Re-enable foreign key checks
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 1");

        return true;
    }
}
