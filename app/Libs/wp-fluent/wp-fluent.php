<?php defined('ABSPATH') or die;

// Autoload plugin.
require 'autoload.php';

if (! function_exists('SwiftCertificateManagerDB')) {
    /**
     * @return \SwiftCertificateManagerFluent\QueryBuilder\QueryBuilderHandler
     */
    function SwiftCertificateManagerDB() {
        static $SwiftCertificateManagerDB;

        if (! $SwiftCertificateManagerDB) {
            global $wpdb;

            $connection = new SwiftCertificateManagerFluent\Connection($wpdb, ['prefix' => $wpdb->prefix]);

            $SwiftCertificateManagerDB = new \SwiftCertificateManagerFluent\QueryBuilder\QueryBuilderHandler($connection);
        }

        return $SwiftCertificateManagerDB;
    }
}