<?php

namespace SwiftCertificateManager\database\Migrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SwiftCMGenerateMigrator {

	public static $tableName = 'swiftcm_generates';

	public static function migrate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table           = $wpdb->prefix . static::$tableName;

		dbDelta(
			"CREATE TABLE {$table} (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				course_name VARCHAR(255) NULL,
				student_name VARCHAR(255) NULL,
				student_email VARCHAR(255) NULL,
				graduation_date VARCHAR(255) NULL,
				grade VARCHAR(255) NULL,
				certificate_details VARCHAR(255) NULL,
				certificate_template VARCHAR(255) NULL,
				qr_code_url VARCHAR(255) NULL,
				certificate_code VARCHAR(255) NULL,
				image_url VARCHAR(255) NULL,
				pdf_url VARCHAR(255) NULL,
				status VARCHAR(11) NULL,
				payment_status VARCHAR(11) NULL,
				settings LONGTEXT NULL,
				created_at TIMESTAMP NULL,
				updated_at TIMESTAMP NULL,
				PRIMARY KEY (id),
			) {$charset_collate};"
		);
	}
}