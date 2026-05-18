<?php 
/*
Plugin Name: Swift Certificate Manager
Plugin URI: https://wordpress.org/plugins/swift-certificate-manager/
Description: The Most certificate generato For WordPress  
Version: 1.0.0
Author: arimtiaz
Author URI: https://profiles.wordpress.org/arimtiaz/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: swift-certificate-manager
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('SWIFTCM_VERSION', '1.0.0');
defined('SWIFTCM_LITE') or define('SWIFTCM_LITE', true);
define('SWIFTCM_UPLOAD_DIR', 'swiftcm_templates_upload_dir');
define('SWIFTCM_PLUGIN_FILE_PATH', plugin_basename(__FILE__));
define('SWIFTCM_PLUGIN_URL', plugin_dir_url(__FILE__));
define("SWIFTCM_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

include 'app/Helpers/global_functions.php';
require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function () {
    require_once SWIFTCM_PLUGIN_DIR_PATH . 'swift-certificate-manager-boot.php';
    $swiftCertificateBoot = new SwiftCertificateManagerBoot();
    $swiftCertificateBoot->boot();
    do_action('swiftcm_loaded', __FILE__);
});

register_activation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFTCM_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/ActivationHandler.php');
    SwiftCertificateManager\Hooks\Handlers\ActivationHandler::activate($network_wide);
});

register_deactivation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFTCM_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/DeactivationHandler.php');
    SwiftCertificateManager\Hooks\Handlers\DeactivationHandler::deActivate($network_wide);
});

// // disabled admin-notice
add_action('admin_init', function () {
    $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';

    if ($page !== 'swiftcm') return;

    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');
});