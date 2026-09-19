=== Swift Certificate Manager ===
Contributors: arimtiaz, ruhel241
Tags: certificate, online course, education, course, certificates
Requires at least: 5.5
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Swift Certificate Manager is a freemium WordPress plugin for certificate generation, certificate validation, and certificate request processing.

== Description ==

Swift Certificate Manager helps you create, manage, and verify certificates directly from your WordPress website.

The plugin provides tools for:

* Creating certificates manually.
* Managing certificate records.
* Processing certificate requests.
* Providing a public certificate verification page.
* Providing a certificate request form.
* Validating certificate information.
* Managing generated certificates from the WordPress dashboard.

Swift Certificate Manager is designed for educational websites, online courses, training programs, and other websites that need a simple certificate management system.

== Features ==

* Certificate generation
* Certificate management
* Certificate verification
* Public certificate verification
* Certificate request form
* Certificate request management
* Manual certificate creation
* Easy WordPress dashboard integration

== Installation ==

1. Upload the `swift-certificate-manager` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. Configure the plugin from the WordPress dashboard.
4. Create and manage your certificates.

== Frequently Asked Questions ==

= Can I verify certificates publicly? =

Yes. Swift Certificate Manager provides a public certificate verification feature.

= Can users request certificates? =

Yes. The plugin provides a certificate request form that can be used to collect certificate requests.

= Who can use this plugin? =

The plugin is suitable for educational websites, online courses, training programs, and other organizations that issue certificates.

== Development ==

Swift Certificate Manager uses modern development tools including Vue.js, npm, Laravel Mix, Webpack, Babel, and Composer to generate the production JavaScript, CSS, and PHP assets distributed with the plugin.

The complete human-readable source code for the compiled and generated assets is publicly available in the following source repository:

Source Code Repository:
https://github.com/ruhel241/swift-certificate-manager

The repository contains the original source files used to generate the distributed plugin assets, as well as the build configuration and dependency definitions required to develop and rebuild the plugin.

Relevant source directories include:

* resources/
* app/
* database/
* languages/
* patches/

Build configuration and dependency files are also included in the repository, including:

* package.json
* webpack.mix.js
* composer.json

=== Build Instructions ===

1. Clone the repository.

2. Install PHP dependencies:

composer install

3. Install JavaScript dependencies:

npm install

4. Build development assets:

npm run dev

5. Build production assets:

npm run production

The JavaScript and CSS files distributed in the plugin's `assets/` directory are generated from the human-readable source code in the repository.

Examples of compiled JavaScript files included in the plugin distribution:

* assets/admin/js/boot.js
* assets/admin/js/start.js
* assets/public/js/swiftcm_request_certificate.js
* assets/public/js/PaymentMethods/paypal-checkout.js
* assets/public/js/PaymentMethods/stripe-checkout.js

Developers should modify the original source files in the repository rather than editing the generated files in the `assets/` directory directly.

=== Third-Party Libraries ===

This plugin includes third-party libraries required for its functionality. Their source and dependency information are maintained in the public repository where applicable.

The plugin-specific code uses the `swiftcm` prefix for plugin-defined functions, classes, hooks, AJAX actions, and options.

=== Composer Autoload ===

This plugin uses Composer for PHP dependency management and autoloading.

PHP dependencies are loaded through:

vendor/autoload.php

To install the required Composer dependencies, run:

composer install

No plugin code is intentionally obfuscated or encrypted. The source code required to review and rebuild the distributed plugin assets is publicly available in the repository above.

=== Compiled Assets ===

All compiled JavaScript and CSS files included in the plugin are generated from the corresponding human-readable source code using the project's build tools, including Laravel Mix and Webpack.



== Screenshots ==

== Changelog ==

= 1.0.2 =
* Improved plugin compatibility and security.
* Updated plugin naming and prefixes.
* Minor bug fixes and improvements.

== Upgrade Notice ==

= 1.0.2 =
This version includes compatibility, security, and general improvements.