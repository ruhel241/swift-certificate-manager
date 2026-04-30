<?php

namespace SwiftCertificateManager\Hooks\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Helpers\PaymentHelper;
use SwiftCertificateManager\Helpers\HelperFunction;
use SwiftCertificateManager\Http\Controllers\AssignCertificateController;
use SwiftCertificateManager\Libs\Translation\TranslationStrings;

class AdminPageHandler
{
    public function register() {
        add_action('admin_menu', array($this, 'addMenuPage'));
    }

    public function addMenuPage()
    {
        $permisison = 'manage_options';

        if (!current_user_can($permisison)) {
            return;
        }

        $menuName = __('Swift Certificate Manager', 'swift-certificate-manager');

        if (defined('SWIFT_CERTIFICATE_MANAGER_PRO')) {
            $menuName =  __('Swift Certificate Manager Pro', 'swift-certificate-manager');
        }
    
        add_menu_page(
            $menuName,
            $menuName,
            $permisison,
            'wscm-swift-certificate-manager',
            [$this, 'renderPage'],
            $this->getMenuIcon(),
            27
        );
        
        add_submenu_page( 
            'wscm-swift-certificate-manager', 
            __('Assign Manually', 'swift-certificate-manager'),
            __('Assign Manually', 'swift-certificate-manager'),
            $permisison,
            'wscm-swift-certificate-manager', 
            array($this, 'renderPage')
        );

        add_submenu_page(
            'wscm-swift-certificate-manager',
            __('Manage Certificates', 'swift-certificate-manager'),
            __('Manage Certificates', 'swift-certificate-manager'),
            $permisison,
            "admin.php?page=wscm-swift-certificate-manager#/manage_certificates",
        );

        add_submenu_page(
            'wscm-swift-certificate-manager',
            __('Templates', 'swift-certificate-manager'),
            __('Templates', 'swift-certificate-manager'),
            $permisison,
            "admin.php?page=wscm-swift-certificate-manager#/templates",
         
        );
        
        add_submenu_page(
            'wscm-swift-certificate-manager',
            __('Settings', 'swift-certificate-manager'),
            __('Settings', 'swift-certificate-manager'),
            $permisison,
            "admin.php?page=wscm-swift-certificate-manager#/settings"
        );

        add_action('admin_enqueue_scripts', [$this, 'loadAssets']);
    }

    public function renderPage()
    {
        echo wp_kses_post("<div class='swift_certificate_manager_wrap'><div id='wp_swift_certificate_manager_app'></div></div>");

        do_action('swift-certificate-manager/admin_app_loaded', true);
    }

    private function getMenuIcon()
    {
        $svg = '<svg width="308" height="305" viewBox="0 0 308 305" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M307.56 75.2541L232.306 1.52588e-05H76.0721C55.8965 1.52588e-05 36.5472 8.0149 22.281 22.2812C8.01469 36.5475 0 55.8965 0 76.0721C0 96.2477 8.01469 115.597 22.281 129.863C36.5472 144.13 55.8965 152.144 76.0721 152.144H0V304.288H231.488C251.664 304.288 271.013 296.274 285.279 282.007C299.546 267.741 307.56 248.392 307.56 228.216C307.56 208.041 299.546 188.692 285.279 174.425C271.013 160.159 251.664 152.144 231.488 152.144H307.56V75.2541ZM156.633 219.261C153.478 207.711 149.557 196.384 144.896 185.355C141.367 178.442 136.462 172.323 130.482 167.374C124.501 162.425 117.572 158.751 110.121 156.578C103.513 154.492 96.4711 154.057 89.6029 152.144H88.9073C116.38 146.232 140.202 137.538 149.765 108.674C152.199 101.198 153.938 93.4601 156.807 85.7225C159.154 126.845 183.758 145.885 222.099 152.492H223.055C181.846 156.143 159.589 177.444 156.633 219.261Z" fill="#5229CA"/>
            <path d="M307.562 75.2541H269.935H237.579C236.181 75.2541 234.84 74.6993 233.852 73.7119C232.863 72.7245 232.308 71.3853 232.308 69.9889V37.6723V0L307.562 75.2541Z" fill="#FFBF03"/>
            </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function loadAssets()
    {
        // phpcs:disable WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['page'] ) && sanitize_text_field( wp_unslash( $_GET['page'] ) ) === 'wscm-swift-certificate-manager') {

            if (function_exists('wp_enqueue_editor')) {
                wp_enqueue_editor();
                wp_enqueue_script('thickbox');
            }
            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            }

            $assetsUrl = SWIFT_CERTIFICATE_MANAGER_PLUGIN_URL.'assets/';
            
            $uploadDir = AvailableOptions::getDirStructure();
            $uploadUrl = AvailableOptions::getDirUrlStructure();

            wp_enqueue_style('swift_certificate_manager_admin',$assetsUrl.'admin/css/admin.css', array(),  SWIFT_CERTIFICATE_MANAGER_VERSION);
            wp_enqueue_script('swift_certificate_manager_admin_boot', $assetsUrl.'admin/js/boot.js', array('jquery'), SWIFT_CERTIFICATE_MANAGER_VERSION, false);
            wp_enqueue_script('swift_certificate_manager_admin_app', $assetsUrl.'admin/js/start.js', array('jquery'), SWIFT_CERTIFICATE_MANAGER_VERSION, true);
           
            $activeTemplate  = get_option('swift_certificate_manager_active_template', 'template-1');
            $isOnboarded     = get_option('swift_certificate_manager_is_onboarded', "no");
            $globalSettings  = get_option('swift_certificate_manager_global_settings', []);

            $templateManager = new TemplatesManager();
            $downloadableTemplates = $templateManager->getDownloadableTemplates();
            
            $i18ns = TranslationStrings::getTranslationStrings();

            $helperFunction = new HelperFunction();

            $SwiftCertificateManagerAdminVars = apply_filters('swift-certificate-manager/admin_app_vars', array(
                'assets_url'             => $assetsUrl,
                'images_url'             => $assetsUrl.'admin/images/',
                'upload_temp_dir'        => $uploadDir['tempDir'],
                'upload_temp_url'        => $uploadUrl['tempUrl'],
                'upload_certificate_url' => $uploadUrl['certificatesUrl'],
                'ajaxurl'                => admin_url('admin-ajax.php'),
                'slug'                   => 'swift-certificate-manager',
                'site_url'               => get_site_url(),
                'i18n'                   => $i18ns,
                'server_time'            => current_time('mysql'),
                'active_template'        => $activeTemplate,
                'nonce'                  => wp_create_nonce('swiftcertificate_admin_nonce'),
                'is_onboarded'           => $isOnboarded ? $isOnboarded : "no",
                'downloadableTemplates'  => count($downloadableTemplates),
                'getSystemStatuses'      => AvailableOptions::getSystemStatuses(),
                'globalSettings'         => $globalSettings,
                'coreTemplates'          => $templateManager->getCoreTemplates(),
                'currencies'             => (new PaymentHelper)->getCurrencies(),
                'has_pro'                => defined('SWIFT_CERTIFICATE_MANAGER_PRO'),
                'has_pro_version'        => defined('SWIFT_CERTIFICATE_MANAGER_PRO_VERSION'),

            ));
    
            wp_localize_script('swift_certificate_manager_admin_boot', 'SwiftCertificateManagerAdminVars', $SwiftCertificateManagerAdminVars);
        }
    }
}