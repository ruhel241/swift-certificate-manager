<?php 
/*
Plugin Name: Swift Certificate Manager
Plugin URI: https://wordpress.org/plugins/swift-certificate-manager/
Description: Issue, manage, and verify professional digital certificates directly from your WordPress site.
Version: 2.0.0
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

define('SWIFCEMA_VERSION', '2.0.0');
defined('SWIFCEMA_LITE') or define('SWIFCEMA_LITE', true);
define('SWIFCEMA_UPLOAD_DIR', 'swifcema_templates_upload_dir');
define('SWIFCEMA_PLUGIN_FILE_PATH', plugin_basename(__FILE__));
define('SWIFCEMA_PLUGIN_URL', plugin_dir_url(__FILE__));
define("SWIFCEMA_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

require_once SWIFCEMA_PLUGIN_DIR_PATH . 'app/Helpers/global_functions.php';
require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function () {
    require_once SWIFCEMA_PLUGIN_DIR_PATH . 'swift-certificate-manager-boot.php';
    $swiftCertificateBoot = new SwiftCertificateManagerBoot();
    $swiftCertificateBoot->boot();
    do_action('swifcema_loaded', __FILE__);
});

register_activation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFCEMA_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/ActivationHandler.php');
    Arimtiaz\SwiftCertificateManager\Hooks\Handlers\ActivationHandler::activate($network_wide);
});

register_deactivation_hook(__FILE__, function ($network_wide) {
    require_once(SWIFCEMA_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/DeactivationHandler.php');
    Arimtiaz\SwiftCertificateManager\Hooks\Handlers\DeactivationHandler::deActivate($network_wide);
});