<?php

namespace SwiftCertificateManager\database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\database\Migrations\SwiftCertificateManagerGenerateMigrator;
use SwiftCertificateManager\database\Migrations\SwiftCertificateManagerTemplatesMigrator;
use SwiftCertificateManager\database\Migrations\SwiftCertificateManagerPaymentsMigrator;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class DBMigrator {

	public static function run( $network_wide = false ) {
		if ( $network_wide ) {
			$site_ids = get_sites(
				array(
					'fields'     => 'ids',
					'network_id' => get_current_network_id(),
				)
			);

			foreach ( $site_ids as $site_id ) {
				switch_to_blog( $site_id );
				static::migrate();
				restore_current_blog();
			}
		} else {
			static::migrate();
		}
	}

	private static function migrate() {
		require_once SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCertificateManagerGenerateMigrator.php';
		require_once SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCertificateManagerTemplatesMigrator.php';
		require_once SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCertificateManagerPaymentsMigrator.php';

		SwiftCertificateManagerGenerateMigrator::migrate();
		SwiftCertificateManagerTemplatesMigrator::migrate();
		SwiftCertificateManagerPaymentsMigrator::migrate();
	}
}