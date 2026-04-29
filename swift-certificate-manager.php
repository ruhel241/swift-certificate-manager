<?php 
/*
Plugin Name: Swift Certificate Manager
Plugin URI: https://wordpress.org/plugins/swift-certificate-manager/
Description: The Most certificate generato For WordPress  
Version: 1.0.0
Author: ''
Author URI: ''
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: swift-certificate-manager
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('SWIFT_CERTIFICATE_VERSION', '1.0.0');
defined('SWIFT_CERTIFICATE_LITE') or define('SWIFT_CERTIFICATE_LITE', true);
define('SWIFT_CERTIFICATE_UPLOAD_DIR', 'wscm_templates_upload_dir');
define('SWIFT_CERTIFICATE_PLUGIN_FILE_PATH', plugin_basename(__FILE__));
define('SWIFT_CERTIFICATE_PLUGIN_URL', plugin_dir_url(__FILE__));
define("SWIFT_CERTIFICATE_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

include 'app/Helpers/global_functions.php';
require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function () {
    require_once SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'swift-certificate-manager-boot.php';
    $swiftCertificateBoot = new SwiftCertificateManagerBoot();
    $swiftCertificateBoot->boot();
    do_action('swift_certificate_manager_loaded', __FILE__);
});

register_activation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/ActivationHandler.php');
    \SwiftCertificateManager\Hooks\Handlers\ActivationHandler::activate($network_wide);
});

register_deactivation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFT_CERTIFICATE_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/DeactivationHandler.php');
    \SwiftCertificateManager\Hooks\Handlers\DeactivationHandler::deActivate($network_wide);
});

// disabled admin-notice
add_action('admin_init', function () {
    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['page'] ) && 'wscm-swift-certificate-manager' === sanitize_text_field( wp_unslash( $_GET['page'] ) )) {
        remove_all_actions( 'admin_notices' );
    }
    // phpcs:enable WordPress.Security.NonceVerification.Recommended
});