<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

if (!class_exists('SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
    require_once SWIFTCM_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
}

// db wp-fluent helper functions
if (!function_exists('swiftcm_query')) {
    function swiftcm_query()
    {
        if (!function_exists('swiftcm_db')) {
            include SWIFTCM_PLUGIN_DIR_PATH . 'app/Libs/wp-fluent/wp-fluent.php';
        }
       
        return swiftcm_db();
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
	$vars[] = 'hash';
	$vars[] = 'swiftcm_success';
	$vars[] = 'payment_method';
	$vars[] = 'payment_status';

	return $vars;
}

add_filter( 'query_vars', 'swiftcm_query_vars' );


/**
 * Handle the swiftcm_invoice request
 */
function swiftcm_handle_request() {

	$requestedCertificate = get_query_var( 'swiftcm_invoice', false );

	if ( $requestedCertificate !== false ) {

		$hash = sanitize_text_field(
			get_query_var( 'hash', '' )
		);

		$payment_method = sanitize_text_field(
			get_query_var( 'payment_method', '' )
		);

		$payment_status = sanitize_text_field(
			get_query_var( 'payment_status', '' )
		);

		get_header();

		echo do_shortcode(
			sprintf(
				'[swiftcm swiftcm_invoice="%s"]',
				esc_attr( $hash )
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


//  ✅ Cron callback
function swiftcm_cleanup_tmp_dir_callback() {
	$availableOptions = new AvailableOptions();
    $availableOptions->cleanupTempDir();
}
add_action('swiftcm_cleanup_tmp_dir', 'swiftcm_cleanup_tmp_dir_callback');