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
function swiftcm_add_rewrite_rules() {
	add_rewrite_rule(
		'^swiftcm_invoice/([^/]+)/?$',
		'index.php?swiftcm_invoice=$matches[1]',
		'top'
	);
}
add_action( 'init', 'swiftcm_add_rewrite_rules' );

/**
 * Register swiftcm_invoice query variable.
 *
 * @param array $vars Query vars.
 * @return array
 */
function swiftcm_query_vars( $vars ) {
	$vars[] = 'swiftcm_invoice';
	return $vars;
}
add_filter( 'query_vars', 'swiftcm_query_vars' );


/**
 * Handle the swiftcm_invoice request
 */
function swiftcm_handle_request() {
	$requestedCertificate = get_query_var( 'swiftcm_invoice', false );

	// Check if swiftcm_invoice is in the query string
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public invoice view endpoint, no state change.
	if ( $requestedCertificate === false && isset( $_GET['swiftcm_invoice'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public invoice view endpoint; nonce verification is not required.
		$requestedCertificate = sanitize_text_field( wp_unslash( $_GET['swiftcm_invoice'] ) );
	}

	if ( $requestedCertificate !== false) {
		get_header();
			echo do_shortcode(
			sprintf(
				'[swiftcm swiftcm_invoice="%s"]',
				esc_attr( $requestedCertificate )
			)
		);
		get_footer();
		exit;
	}
}
add_action( 'template_redirect', 'swiftcm_handle_request' );


// regiseter custom cron schedule, when app load
add_action('swiftcm_admin_app_loaded', function () {
	if (!wp_next_scheduled('swiftcm_cleanup_tmp_dir')) {
        wp_schedule_event(time(), 'daily', 'swiftcm_cleanup_tmp_dir');
    }
});



// for testing purpose
// function swiftcm_cleanup_tmp_dir( $schedules ) {
//     $schedules['every_minute'] = array(
//             'interval'  => 60,
//             'display'   => __( 'Every Minute', 'textdomain' )
//     );
//     return $schedules;
// }
// add_filter( 'cron_schedules', 'swiftcm_cleanup_tmp_dir' );

//  ✅ Cron callback
add_action('swiftcm_cleanup_tmp_dir', function(){
   $availableOptions = new AvailableOptions();
	$availableOptions->cleanupTempDir();
});