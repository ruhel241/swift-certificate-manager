=== Swift Certificate Manager ===
Contributors: arimtiaz, ruhel241
Tags: certificate, online course, education, course, certificates
Requires at least: 5.5
Tested up to: 7.1.1
Requires PHP: 7.4
Stable tag: 1.0.3
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

Swift Certificate Manager uses Vue.js, npm, Laravel Mix, Webpack, Babel, and Sass to build the production JavaScript and CSS assets distributed with the plugin.

The complete human-readable source code and build configuration are publicly available in the following source repository:

Source Code Repository:
https://github.com/ruhel241/swift-certificate-manager

The repository contains the original source files used to generate the compiled JavaScript and CSS files included in the plugin distribution.

=== Source and Generated Assets ===

The production JavaScript files are generated from the following human-readable source files:

* resources/admin/boot.js -> assets/admin/js/boot.js
* resources/admin/start.js -> assets/admin/js/start.js

The production CSS files are generated from:

* resources/scss/admin.scss -> assets/admin/css/swifcema-admin.css
* resources/scss/public.scss -> assets/public/css/swifcema-public.css

Other assets are copied from the source/dependency directories during the build process:

* resources/admin/images/ -> assets/admin/images/
* node_modules/element-ui/lib/theme-chalk/fonts/ -> assets/admin/css/fonts/

The generated files in the `assets/` directory are production files and should not be edited directly. Developers should modify the corresponding human-readable source files and rebuild the assets using the project's build tools.

=== Build Configuration ===

The repository includes the configuration and dependency files required to build the plugin:

* package.json
* package-lock.json
* webpack.mix.js
* composer.json
* composer.lock
* build.sh

=== Build Instructions ===

1. Clone the repository.

2. Install PHP dependencies:

composer install

3. Install JavaScript dependencies:

npm install

4. Build production JavaScript and CSS assets:

npm run production

5. Build the complete production plugin package:

./build.sh

The `build.sh` script generates the production assets, installs optimized Composer dependencies, and creates the distributable plugin ZIP package.

=== Source Availability ===

The distributed plugin contains compiled production assets for performance and compatibility. The corresponding human-readable source code and build configuration are maintained in the public repository above and can be reviewed, modified, and rebuilt by developers.

== Screenshots ==

== Changelog ==

= 1.0.3 =
* Improved plugin compatibility and security.
* Updated plugin naming and prefixes.
* Minor bug fixes and improvements.

== Upgrade Notice ==

= 1.0.3 =
This version includes compatibility, security, and general improvements.