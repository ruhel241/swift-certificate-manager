<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

if (!class_exists('\SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
	require_once SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
}

// db wp-fluent helper functions
if (!function_exists('SwiftCertificateManagerQuery')) {
    function SwiftCertificateManagerQuery()
    {
        if (!function_exists('SwiftCertificateManagerDB')) {
            include SWIFT_CERTIFICATE_MANAGER_PLUGIN_DIR_PATH . 'app/Libs/wp-fluent/wp-fluent.php';
        }
       
        return SwiftCertificateManagerDB();
    }
}

/**
 * Add rewrite rules for custom invoice URL.
 */
function swift_certificate_manager_add_rewrite_rules() {
	add_rewrite_rule(
		'^wscm_invoice/([^/]+)/?$',
		'index.php?wscm_invoice=$matches[1]',
		'top'
	);
}
add_action( 'init', 'swift_certificate_manager_add_rewrite_rules' );

/**
 * Register wscm_invoice query variable.
 *
 * @param array $vars Query vars.
 * @return array
 */
function swift_certificate_manager_query_vars( $vars ) {
	$vars[] = 'wscm_invoice';
	return $vars;
}
add_filter( 'query_vars', 'swift_certificate_manager_query_vars' );


/**
 * Handle the wscm_invoice request
 */
function swift_certificate_manager_handle_request() {
	$requestedCertificate = get_query_var( 'wscm_invoice', false );

	// Check if wscm_invoice is in the query string
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public invoice view endpoint, no state change.
	if ( $requestedCertificate === false && isset( $_GET['wscm_invoice'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public invoice view endpoint; nonce verification is not required.
		$requestedCertificate = sanitize_text_field( wp_unslash( $_GET['wscm_invoice'] ) );
	}

	if ( $requestedCertificate !== false) {
		get_header();
			echo do_shortcode(
			sprintf(
				'[swift_certificate_manager wscm_invoice="%s"]',
				esc_attr( $requestedCertificate )
			)
		);
		get_footer();
		exit;
	}
}
add_action( 'template_redirect', 'swift_certificate_manager_handle_request' );


// regiseter custom cron schedule, when app load
add_action('swift-certificate-manager/admin_app_loaded', function () {
	if (!wp_next_scheduled('swift_certificate_manager_cleanup_tmp_dir')) {
        wp_schedule_event(time(), 'daily', 'swift_certificate_manager_cleanup_tmp_dir');
    }
});

// error_log(print_r(_get_cron_array(), 1));

// for testing purpose
// function swift_certificate_manager_cleanup_tmp_dir( $schedules ) {
//     $schedules['every_minute'] = array(
//             'interval'  => 60,
//             'display'   => __( 'Every Minute', 'textdomain' )
//     );
//     return $schedules;
// }
// add_filter( 'cron_schedules', 'swift_certificate_manager_cleanup_tmp_dir' );

//  ✅ Cron callback
add_action('swift_certificate_manager_cleanup_tmp_dir', function(){
    file_put_contents(
        WP_CONTENT_DIR . '/cron-test.txt',
        'Cron working at ' . gmdate('Y-m-d H:i:s') . PHP_EOL,
        FILE_APPEND
    );

	$availableOptions = new AvailableOptions();
	$availableOptions->cleanupTempDir();
});