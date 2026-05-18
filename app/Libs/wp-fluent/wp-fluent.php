<?php defined('ABSPATH') or die;

// Autoload plugin.
require 'autoload.php';

if (! function_exists('swiftcm_db')) {
    /**
     * @return \SwiftCertificateManagerFluent\QueryBuilder\QueryBuilderHandler
     */
    function swiftcm_db() {
        static $swiftcm_db;

        if (! $swiftcm_db) {
            global $wpdb;

            $connection = new SwiftCertificateManagerFluent\Connection($wpdb, ['prefix' => $wpdb->prefix]);

            $swiftcm_db = new \SwiftCertificateManagerFluent\QueryBuilder\QueryBuilderHandler($connection);
        }

        return $swiftcm_db;
    }
}