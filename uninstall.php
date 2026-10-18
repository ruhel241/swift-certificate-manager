<?php
/**
 * Swift Certificate Manager uninstall.
 *
 * Removes plugin data when the plugin is deleted from the Plugins screen.
 * To keep the data, add this line to wp-config.php before deleting the plugin:
 * define( 'SWIFCEMA_KEEP_DATA_ON_UNINSTALL', true );
 *
 * @package SwiftCertificateManager
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( defined( 'SWIFCEMA_KEEP_DATA_ON_UNINSTALL' ) && SWIFCEMA_KEEP_DATA_ON_UNINSTALL ) {
	return;
}

/**
 * Delete plugin data for the current site.
 */
function swifcema_uninstall_current_site() {
	global $wpdb;

	// Scheduled task.
	wp_clear_scheduled_hook( 'swifcema_cleanup_tmp_dir' );

	// Options.
	$options = array(
		'swifcema_active_template',
		'swifcema_global_settings',
		'swifcema_is_onboarded',
		'swifcema_newsletters',
		'swifcema_onboarding_info',
		'swifcema_payment_settings_paypal',
		'swifcema_payment_settings_stripe',
	);

	foreach ( $options as $option ) {
		delete_option( $option );
	}

	// Rate limit transients.
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Removing this plugin's own transients on uninstall.
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Core table name.
			$wpdb->esc_like( '_transient_swifcema_' ) . '%',
			$wpdb->esc_like( '_transient_timeout_swifcema_' ) . '%'
		)
	);

	// Custom tables.
	$tables = array(
		$wpdb->prefix . 'swifcema_generates',
		$wpdb->prefix . 'swifcema_payments',
		$wpdb->prefix . 'swifcema_templates',
	);

	foreach ( $tables as $table ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Dropping this plugin's own table on uninstall; the name is built from the core prefix and a fixed suffix.
		$wpdb->query( "DROP TABLE IF EXISTS `{$table}`" );
	}

	// Generated files in the uploads folder.
	$upload_dir = wp_upload_dir();
	$plugin_dir = trailingslashit( $upload_dir['basedir'] ) . 'swifcema_templates_upload_dir';

	if ( is_dir( $plugin_dir ) ) {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! empty( $wp_filesystem ) ) {
			$wp_filesystem->delete( $plugin_dir, true );
		}
	}
}

if ( is_multisite() ) {
	$swifcema_site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);

	foreach ( $swifcema_site_ids as $swifcema_site_id ) {
		switch_to_blog( $swifcema_site_id );
		swifcema_uninstall_current_site();
		restore_current_blog();
	}
} else {
	swifcema_uninstall_current_site();
}
