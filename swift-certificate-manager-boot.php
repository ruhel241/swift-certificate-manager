<?php

defined( 'ABSPATH' ) || die;

class SwiftCertificateManagerBoot {

	public function boot() {
		if ( is_admin() ) {
			$this->adminHooks();
		}
	}

	public function adminHooks() {
		$menu = new arimtiaz\swiftcertificatemanager\Hooks\Handlers\AdminPageHandler();
		$menu->register();
	}
}