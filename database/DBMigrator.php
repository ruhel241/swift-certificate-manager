<?php

namespace SwiftCertificateManager\database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\database\Migrations\SwiftCMGenerateMigrator;
use SwiftCertificateManager\database\Migrations\SwiftCMTemplatesMigrator;
use SwiftCertificateManager\database\Migrations\SwiftCMPaymentsMigrator;

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

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		require_once SWIFTCM_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCMGenerateMigrator.php';

		require_once SWIFTCM_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCMTemplatesMigrator.php';

		require_once SWIFTCM_PLUGIN_DIR_PATH . 'database/Migrations/SwiftCMPaymentsMigrator.php';

		SwiftCMGenerateMigrator::migrate();

		SwiftCMTemplatesMigrator::migrate();

		SwiftCMPaymentsMigrator::migrate();
	}
}