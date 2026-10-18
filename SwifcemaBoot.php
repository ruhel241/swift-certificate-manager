<?php

defined( 'ABSPATH' ) || die;

class SwifcemaBoot {

	public function boot() {
		if ( is_admin() ) {
			$this->adminHooks();
		}

		$this->publicHooks();
	}

	public function adminHooks() {
		$menu = new Arimtiaz\SwiftCertificateManager\Hooks\Handlers\AdminPageHandler();
		$menu->register();

		$ajaxAssignController = new Arimtiaz\SwiftCertificateManager\Http\Controllers\AssignCertificateController();
		$ajaxAssignController->register();

		$ajaxTemplateController = new Arimtiaz\SwiftCertificateManager\Http\Controllers\TemplateController();
		$ajaxTemplateController->register();

		$ajaxSettingsController = new Arimtiaz\SwiftCertificateManager\Http\Controllers\SettingsController();
		$ajaxSettingsController->register();

		$onBoardingController = new Arimtiaz\SwiftCertificateManager\Http\Controllers\OnboardingController();
		$onBoardingController->register();

		// all actions
		$adminActions = new Arimtiaz\SwiftCertificateManager\Hooks\actions();
		$adminActions->register();
		
		
    }

	public function publicHooks() {
		(new Arimtiaz\SwiftCertificateManager\Hooks\Handlers\FrontendHandler)->register();
	}
}
