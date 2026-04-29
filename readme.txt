=== Swift Certificate Manager ===
Contributors: arimtiaz, ruhel241
Tags: certificate, online course, education, course, certificates
Requires at least: 5.5
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Swift Certificate Manager Plugin is designed to simplify the creation, management, customisation, and verification of certificates

== Description ==

Swift Certificate Manager is a freemium WordPress plugin for certificate generation, certificate validation, and paid certificate requests. It is designed for educators, trainers, coaches, institutions, and course providers who want to issue professional certificates directly from their website. Unlike many certificate tools, Swift Certificate Manager does **not require an LMS** to function. It works independently, making it ideal for websites that offer online or offline training, workshops, coaching, tutoring, or professional development programs.

Swift Certificate Manager allows you to generate certificates manually, manage certificate requests, collect certificate fees online, and let anyone verify a certificate using a unique verification code. It is suitable for both small independent instructors and larger organizations that need a simple certificate issuance workflow without the complexity of a full learning management system

### Main capabilities
 - Generate certificates without an LMS 
 - Assign certificates manually 
 - Save certificate entries as drafts 
 - Download certificates as PDF 
 - Email certificates to learners 
 - Add verification codes to certificates 
 - Verify certificates through a public verification page 
 - Accept online certificate requests 
 - Charge students a certification fee 
 - Manage requests and approvals from the WordPress dashboard 
 - Use built-in certificate templates 
 - Enable Stripe and PayPal payments 
 - Upgrade to Pro for premium templates and expanded access

## Use Case

Suppose an instructor runs a training website and also teaches students offline. After a learner completes a course, the instructor wants to issue a signed certificate. The certificate should include a unique code so employers, clients, or third parties can verify its authenticity on the website.

With Swift Certificate Manager, the instructor can:

- create certificates manually
- allow students to request certificates online
- collect certificate fees
- approve requests from the admin panel
- generate and send certificates by email
- let visitors verify the certificate using a dedicated verification URL

## Features

## LMS-Independent
Swift Certificate Manager works with or without a learning management system. It does not rely on LMS course completion data to function.

## Manual Certificate Assignment
You can manually enter certificate details and generate a certificate instantly. Supported fields include:
- Course name
- Student name
- Graduation date
- Email address
You can either create the certificate immediately or save the entry as a draft for later. ## Certificate Drafts
Certificate entries can be saved as drafts before final generation. This is useful when information is incomplete or needs review before issuance.

## PDF Download
Generated certificates can be downloaded as PDF files.

## Email Delivery
Certificates can be emailed directly to students from the plugin interface.

## Certificate Customization
Certificate appearance can be adjusted through the customization interface. Available options may include:

- font family
- font weight
- text sizing
- field positioning
- signature
- signature image

## Certificate Templates
The plugin includes certificate templates out of the box.

- Free version: selected free templates
- Pro version: full template library

## Certificate Verification
Each certificate includes a unique verification code. Anyone can use the verification page on the website to confirm whether a certificate is valid.

## Online Certificate Requests
The plugin can automatically create a certificate request page so students can request their certificate online.

## Payment Collection
Swift Certificate Manager supports online payments through:

- Stripe
- PayPal

## Admin Request Approval Workflow
When a student submits a paid certificate request, the plugin records it in the dashboard. The administrator can then review and approve the request before generating the certificate.

## Certificate Management
The plugin includes certificate management tools for:

- viewing created certificates
- viewing certificate requests
- viewing saved drafts
- editing certificate information
- recreating certificates
- exporting records as CSV
- deleting certificate records

## Pro License Activation
A valid license key can be entered in the License Management section to unlock Pro features.

## Free vs Pro ### Free Version
The free version includes:

- 10 certificate generations per month
- 5 payment transactions per month
- access to selected free templates ### Pro Version
The Pro version includes:

- access to all certificate templates
- higher usage potential
- premium feature access
- Pro activation through license key



== Installation ==

1. Download the plugin ZIP file.
2. Go to **Plugins > Add New > Upload Plugin**.
3. Upload the ZIP file.
4. Click **Install Now**.
5. Activate the plugin.

== Frequently Asked Questions ==

= Does Swift Certificate Manager require an LMS? =
No. Swift Certificate Manager works independently and does not need LMS data to generate or validate certificates.

= Can I use it for offline courses? =
Yes. It is suitable for both online and offline learning programs.

= Can students request certificates themselves? =
Yes. You can create a request page where students can apply for a certificate and pay the fee online.

= Can certificates be verified online? =
Yes. Every certificate can include a verification code that can be checked through the verification page on your website.

= Can I email certificates to students? =
Yes. Generated certificates can be emailed directly to learners.

= Can I download certificates as PDF? =
Yes. Certificates can be downloaded as PDF files.

= Which payment gateways are supported? =
Swift Certificate Manager supports Stripe and PayPal.

= What happens in the free version? =
The free version allows up to 10 certificate generations per month and up to 5 transactions per month, with limited template access.

= How do I unlock premium templates? =
Enter a valid Pro license key in the License Management tab.


Troubleshooting
Certificate request form is not showing
Check that:

* the correct shortcode is used

* the page is published

* the plugin is active

* cache is cleared if needed


Verification page is not working
Check that:

* the verify page URL is configured correctly

* the verification shortcode is added to the page

* the certificate code exists in the system


Payments are not being recorded
Check that:

* Stripe or PayPal is enabled

* gateway settings are saved correctly

* the payment account is active

* transaction records are being reviewed in the Payment Transaction tab


Certificate email is not delivered
Check that:

* the student email is entered correctly

* your WordPress email sending setup is working properly

* SMTP is configured if required by your hosting environment


Pro features are not unlocked
Check that:

* the license key is correct
* the key was entered in the License Management tab
* the license verification completed successfully

== Best Practices ==

* Set a consistent certificate code prefix
* Use a branded template
* upload a clean signature image for better presentation
* test the request page before publishing
* test Stripe and PayPal configuration before accepting payments
* verify your public verification page using a sample certificate
* export records regularly if you manage many certificates 


## Getting Started

After installation, configure the plugin in this order:

1.Open **Swift Certificate Manager**
2.Go to **Settings**
3.Enter your instructor or issuer details
4.Set certificate price and currency
5.Configure signature options
6.Enable Stripe and/or PayPal if you want paid certificate requests
7.Select a certificate template
8.Create certificates manually or accept certificate requests online

## Admin Menu Overview 

Swift Certificate Manager includes four main admin sections:

- Assign Manually
- Management
- Templates
- Settings

## 1. Assign Manually

Use this section to manually create a certificate. ### Available fields
- Course Name
- Student Name
- Graduation Date
- Email

### Available actions

- Create certificate
- Save as draft

Once a certificate is generated, you can also:

- edit certificate information
- customize certificate design
- download the certificate
- email the certificate ### Typical workflow
1.Enter course and student details
2.Click **Create Certificate**
3.Review the generated certificate
4.Customize if needed
5.Download or email the certificate

---

## 2. Management

The Management section helps you manage all certificate records from one place. ### Tabs commonly available
-Created
-Request
-Drafts

### Available actions

- View certificate records
- Search and filter entries
- Edit certificate data
- Recreate a certificate
- Export CSV
- Delete specific certificate records

### Created tab
Shows all generated certificates.

### Request tab
Shows certificate requests submitted by students through the request page.

### Drafts tab
Shows certificate entries saved as drafts for later completion.

---

## 3. Templates

The Templates section lets you browse and select available certificate designs. ### Available actions
-Preview template
-Use template
-Set active template
-Upgrade to Pro for premium templates

This allows users to maintain a professional and branded certificate appearance.

---

## 4. Settings

The Settings section contains four tabs:

-General
-Payment Methods
-Payment Transaction
-License Management

---

## General Settings

The General tab stores your core certificate and issuer settings. ### Common options
#### Issuer / Instructor details
- preference selection
- instructor name
- instructor signature
- signature image upload
- enable signature image

#### Currency settings
- default currency

- certificate price

#### Certificate page details
- order certificate URL
- verify certificate URL
- order certificate shortcode
- verify certificate shortcode

#### Certificate code settings
- certificate code prefix

#### Maintenance
- clear cache

## Payment Methods

Swift Certificate Manager supports two payment gateways:

- Stripe
- PayPal

In this section, you can enable or disable each payment method and save gateway settings. Use this section when you want students to pay before requesting a certificate.


## Payment Transaction

The Payment Transaction tab shows transaction records and statuses. ### Transaction visibility may include
- successful payments
- pending payments
- failed payments

This helps administrators monitor payment activity related to certificate requests.

## License Management

The License Management tab is used to activate Swift Certificate Manager Pro. ### Steps
1.Enter your license key
2.Click the verification button
3.Activate Pro features

Once activated, premium features and full template access become available.


## Public Pages

Swift Certificate Manager automatically creates or supports pages for:

- certificate request
- certificate verification
These pages help automate the certificate workflow for both students and administrators. ### Certificate Request Page
Students can request their certificate and pay the fee from this page.

### Certificate Verification Page
Visitors can enter a certificate code to verify the authenticity of a certificate.

## Shortcodes
Swift Certificate Manager provides shortcodes for public certificate workflows. ### Order Certificate Shortcode
Use the order/request shortcode to display the certificate request form on a page.

Example:
[swift_certificate_manager form="request-swift-certificate-manager"]

Verify Certificate Shortcode

Use the verification shortcode to display the certificate verification form on a page. Example:
[swift_certificate_manager form="verify-swift-certificate-manager"]

Note: Exact shortcode output and page slugs depend on your plugin setup and page configuration.


Typical Workflow

Manual Certificate Workflow
1.Go to Assign Manually

2.Enter certificate details

3.Save as draft or create certificate

4.Review the generated certificate

5.Customize layout if required

6.Download or email the certificate


Paid Certificate Request Workflow
1.Student visits the certificate request page

2.Student submits required details

3.Student pays certificate fee via Stripe or PayPal

4.Plugin records the request

5.Admin reviews the request from the dashboard

6.Admin approves the request

7.Certificate is generated

8.Certificate is emailed or downloaded


Certificate Verification Workflow
1.Visitor opens the verification page

2.Visitor enters the certificate code

3.Website validates the certificate record

4.Verification result is displayed


Configuration Recommendations
For best results, configure the following immediately after installation:

* instructor name

* signature or signature image

* certificate price

* default currency

* certificate code prefix

* payment gateway settings

* active certificate template

* request and verification pages




Example Applications
Swift Certificate Manager is suitable for:

* coaching programs

* design or IT training

* vocational courses

* tutoring businesses

* workshop completion certificates

* seminar attendance certificates

* online academies

* offline institutions

* corporate training certificates

* appreciation certificates



== Screenshots ==

1. Certificate creation panel
2. Certificate preview
3. Certificate management dashboard
4. Payment settings
5. Verification page

== Changelog ==

= 1.0.0 =
Changelog

* Initial release

* Manual certificate assignment

* Draft support

* Certificate generation

* PDF download

* Email delivery

* Certificate templates

* Certificate request workflow

* Stripe support

* PayPal support

* Transaction view

* Verification page support

* Pro license activation

License
Swift Certificate Manager is distributed as a freemium plugin.

* Free version: limited monthly certificate generation and transactions

* Pro version: premium templates and expanded features through license activation


Please refer to the official product licensing terms for commercial usage and upgrade conditions.


Support
For plugin setup, account issues, licensing, payment configuration, or template access, please contact the official Swift Certificate Manager support channel.


Credits
Developed for educators, trainers, and institutions that need a lightweight and reliable certificate workflow without LMS dependency.


Summary
Swift Certificate Manager is a flexible WordPress plugin for issuing, validating, and selling certificates online. It combines manual certificate creation, student request handling, payment processing, certificate verification, and template-based customization in one streamlined system.

== Upgrade Notice ==

= 1.0.0 =
Initial release of Swift Certificate Manager.
