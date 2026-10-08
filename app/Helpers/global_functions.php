<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;

if (!class_exists('SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
    require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
}


/**
 * Add rewrite rules for custom invoice URL.
 */
function swifcema_add_rewrite_rules() {
	add_rewrite_rule(
		'^swifcema_invoice/([^/]+)/?$',
		'index.php?swifcema_invoice=$matches[1]',
		'top'
	);
}
add_action( 'init', 'swifcema_add_rewrite_rules' );

/**
 * Register swifcema_invoice query variable.
 *
 * @param array $vars Query vars.
 * @return array
 */

function swifcema_query_vars( $vars ) {

	$vars[] = 'swifcema_invoice';
	$vars[] = 'hash';
	$vars[] = 'swifcema_success';
	$vars[] = 'payment_method';
	$vars[] = 'payment_status';

	return $vars;
}

add_filter( 'query_vars', 'swifcema_query_vars' );


/**
 * Handle the swifcema_invoice request
 */
function swifcema_handle_request() {

	$requestedCertificate = get_query_var( 'swifcema_invoice', false );

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
				'[swifcema swifcema_invoice="%s"]',
				esc_attr( $hash )
			)
		);

		get_footer();

		exit;
	}
}
add_action( 'template_redirect', 'swifcema_handle_request' );


// regiseter custom cron schedule, when app load
add_action('swifcema_admin_app_loaded', function () {
	if (!wp_next_scheduled('swifcema_cleanup_tmp_dir')) {
        wp_schedule_event(time(), 'daily', 'swifcema_cleanup_tmp_dir');
    }
});


//  ✅ Cron callback
function swifcema_cleanup_tmp_dir_callback() {
	$availableOptions = new AvailableOptions();
    $availableOptions->cleanupTempDir();
}
add_action('swifcema_cleanup_tmp_dir', 'swifcema_cleanup_tmp_dir_callback');