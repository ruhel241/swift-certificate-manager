<?php 
/*
Plugin Name: Swift Certificate Manager
Plugin URI: https://wordpress.org/plugins/swift-certificate-manager/
Description: Issue, manage, and verify professional digital certificates directly from your WordPress site.
Version: 1.0.3
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

define('SWIFCEMA_VERSION', '1.0.3');
defined('SWIFCEMA_LITE') or define('SWIFCEMA_LITE', true);
define('SWIFCEMA_UPLOAD_DIR', 'swifcema_templates_upload_dir');
define('SWIFCEMA_PLUGIN_FILE_PATH', plugin_basename(__FILE__));
define('SWIFCEMA_PLUGIN_URL', plugin_dir_url(__FILE__));
define("SWIFCEMA_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function () {
    require_once SWIFCEMA_PLUGIN_DIR_PATH . 'swift-certificate-manager-boot.php';
    $swiftCertificateBoot = new SwiftCertificateManagerBoot();
    $swiftCertificateBoot->boot();
});
