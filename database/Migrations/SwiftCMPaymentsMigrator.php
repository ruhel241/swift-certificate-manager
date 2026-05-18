<?php

namespace SwiftCertificateManager\database\Migrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SwiftCMPaymentsMigrator {

	public static $tableName = 'swiftcm_payments';

	public static function migrate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table           = $wpdb->prefix . static::$tableName;

		dbDelta(
			"CREATE TABLE {$table} (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				request_id BIGINT UNSIGNED NOT NULL,
				payment_method VARCHAR(50) NULL,
				payment_status VARCHAR(11) NULL,
				entry_hash VARCHAR(255) NULL,
				charge_id VARCHAR(255) NULL,
				card_last_4 VARCHAR(4) NULL,
				card_brand VARCHAR(20) NULL,
				payment_mode VARCHAR(20) NULL,
				payment_total DECIMAL(10,2) NULL,
				currency VARCHAR(10) NULL,
				transaction_type VARCHAR(50) NULL,
				payment_note LONGTEXT NULL,
				created_at TIMESTAMP NULL DEFAULT NULL,
				updated_at TIMESTAMP NULL DEFAULT NULL,
				PRIMARY KEY (id),
				KEY request_id (request_id)
			) ENGINE=InnoDB {$charset_collate};"
		);
	}
}