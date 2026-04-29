<?php

defined( 'ABSPATH' ) || die;

class SwiftCertificateManagerBoot {

	public function boot() {
		if ( is_admin() ) {
			$this->adminHooks();
		}

		$this->publicHooks();
		// $this->registerIpnHooks();
	}

	public function adminHooks() {
		$menu = new SwiftCertificateManager\Hooks\Handlers\AdminPageHandler();
		$menu->register();

		$ajaxAssignController = new SwiftCertificateManager\Http\Controllers\AssignCertificateController();
		$ajaxAssignController->register();

		$ajaxTemplateController = new SwiftCertificateManager\Http\Controllers\TemplateController();
		$ajaxTemplateController->register();

		$ajaxSettingsController = new SwiftCertificateManager\Http\Controllers\SettingsController();
		$ajaxSettingsController->register();

		// all actions
		$adminActions = new SwiftCertificateManager\Hooks\actions();
		$adminActions->register();
		
		$onBoardingHandler = new SwiftCertificateManager\Hooks\Handlers\OnboardingHandler();
		$onBoardingHandler->registerEndpoints();
    }

	public function publicHooks() {
		(new SwiftCertificateManager\Hooks\Handlers\FrontendHandler)->register();
	}

	// public function registerIpnHooks() {
    //     // phpcs:disable WordPress.Security.NonceVerification.Recommended -- IPN/webhook listener endpoint does not use WordPress nonces.
    //     $has_ipn_listener = isset( $_GET['swift_certificate_manager_ipn_listener'] );
    //     $has_method       = isset( $_GET['method'] );
    //     // phpcs:enable WordPress.Security.NonceVerification.Recommended

    //     if ( $has_ipn_listener && $has_method ) {
    //         add_action(
    //             'wp',
    //             function () {
    //                 // phpcs:disable WordPress.Security.NonceVerification.Recommended -- IPN/webhook listener endpoint does not use WordPress nonces.
    //                 $payment_method = isset( $_GET['method'] )
    //                     ? sanitize_text_field( wp_unslash( $_GET['method'] ) )
    //                     : '';
    //                 // phpcs:enable WordPress.Security.NonceVerification.Recommended

    //                 if ( '' !== $payment_method ) {
    //                     do_action( 'swift_certificate_manager_ipn_endpoint_' . $payment_method );
    //                 }
    //             }
    //         );
    //     }
    // }
}