<?php

namespace SwiftCertificateManager\database\Migrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SwiftCMTemplatesMigrator {

	public static $tableName = 'swiftcm_templates';

	public static function migrate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table           = $wpdb->prefix . static::$tableName;
		
		dbDelta(
			"CREATE TABLE {$table} (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				template_name VARCHAR(255) NULL,
				slug VARCHAR(255) NULL,
				template_image VARCHAR(255) NULL,
				pro INT(1) NULL,
				settings LONGTEXT NULL,
				created_at TIMESTAMP NULL,
				updated_at TIMESTAMP NULL,
				PRIMARY KEY (id)
			) {$charset_collate};"
		);
	}
}