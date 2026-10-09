<?php

namespace Arimtiaz\SwiftCertificateManager\Hooks\Handlers;

use Arimtiaz\SwiftCertificateManager\database\DBMigrator;
use Arimtiaz\SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

class ActivationHandler
{
    public static function activate($network_wide)
    {
        self::maybeCreateFolderStructure();
        self::maybeCreatePages();

        require_once(SWIFCEMA_PLUGIN_DIR_PATH . 'database/DBMigrator.php');

        DBMigrator::run($network_wide);

        $globalSettings = AvailableOptions::globalSettings();
       
        // create custom cron schedule and job
        wp_schedule_event( time(), 'daily', 'swifcema_cleanup_tmp_dir' );

        if (!get_option('swifcema_active_template')){
            update_option('swifcema_active_template', 'template-1');
        }

        if (!get_option('swifcema_global_settings')){
            update_option('swifcema_global_settings', $globalSettings);
        }

        // invoice flush 
        swifcema_add_rewrite_rules();
        flush_rewrite_rules();
    }

    public static function maybeCreateFolderStructure()
    {
        if (!class_exists('\Arimtiaz\SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
            require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
        }

        $dirs = AvailableOptions::getDirStructure();
    
        /* add folders that need to be checked */
        $folders = [
            $dirs['workingDir'],
            $dirs['fontDir'],
            $dirs['pdfCacheDir'],
            $dirs['tempDir'],
            $dirs['certificatesDir'],
        ];

        /* create the required folder structure, or throw error */
        foreach ($folders as $dir) {
            if (!is_dir($dir)) {
                wp_mkdir_p($dir);
            }
        }

        $content = '<FilesMatch "\.(jpg|jpeg|png|pdf|gif)$">
                        Allow from all
                    </FilesMatch>
                    # Block all other files by default
                    deny from all';

        if (!is_file($dirs['workingDir'] . '/.htaccess')) {
            file_put_contents($dirs['workingDir'] . '/.htaccess', $content);
        }
    }


    public static function maybeCreatePages() {
        $pages = [
            [
                'post_title'   => 'Request Swift Certificate Manager',
                'post_content' => '[swifcema form="request-swift-certificate-manager"]',
                'post_status'  => 'publish',
                'post_type'    => 'page'
            ],
            [
                'post_title'   => 'Verify Swift Certificate Manager',
                'post_content' => '[swifcema form="verify-swift-certificate-manager"]',
                'post_status'  => 'publish',
                'post_type'    => 'page'
            ]
        ];
    
        foreach ($pages as $page) {
            $query = new \WP_Query([
                'post_type'  => 'page',
                'title'      => $page['post_title'],
                'post_status'=> 'publish',
                'posts_per_page' => 1
            ]);
    
            // If no page exists, insert the new one
            if (!$query->have_posts()) {
                wp_insert_post($page);
            }
        }
    }
}