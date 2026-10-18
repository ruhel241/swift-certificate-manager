<?php

namespace Arimtiaz\SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DeactivationHandler
{
    /**
     * Runs on plugin deactivation.
     *
     * Only the scheduled task is removed. Generated certificates, templates,
     * settings and database tables are kept so nothing is lost when the plugin
     * is deactivated temporarily. Everything is removed by uninstall.php when
     * the plugin is deleted.
     *
     * @param bool $network_wide Whether the plugin is deactivated network wide.
     */
    public static function deActivate($network_wide)
    {
        wp_clear_scheduled_hook('swifcema_cleanup_tmp_dir');
    }
}
