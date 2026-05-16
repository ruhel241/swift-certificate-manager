=== Swift Certificate Manager ===
Contributors: arimtiaz, ruhel241
Tags: certificate, online course, education, course, certificates
Requires at least: 5.5
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Swift Certificate Manager is a freemium WordPress plugin for certificate generation, certificate validation, and certificate request processing.

== Description ==

Swift Certificate Manager allows you to create certificates manually, manage certificate requests, offer public verification pages, and provide a dedicated certificate request form. The Pro version also enables paid certificate requests via Stripe and PayPal.

The plugin supports both small instructors and large training organisations that need a structured, easy-to-use certificate workflow.

### **Main capabilities**

* Create certificates manually  
* Save certificates as drafts  
* Download certificates as PDF  
* Email certificates to learners **\[Pro\]**  
* Edit certificate information **\[Pro\]**  
* Customise certificate design (fonts, layout, signature, positioning) **\[Pro\]**  
* Add unique verification codes  
* Verify certificates through a public page  
* Accept certificate requests from students  
* Enable Stripe & PayPal for paid certificates **\[Pro\]**  
* Manage created certificates and requests  
* Use built-in certificate templates (Free \+ Pro options)  
* Activate Pro with a License key


## **Use Case**

For example, an instructor teaching online and offline wants to issue certificates with a unique verification code. Students may request certificates directly from the website, and the instructor can approve the requests from the admin dashboard.

With Swift Certificate Manager, the instructor can:

* manually create certificates  
* let students request certificates online  
* collect certificate fees **(Pro required for payment gateways)**  
* approve requests from the backend  
* send certificates by email **\[Pro\]**  
* allow public verification of every certificate


## **Features**

## **LMS-Independent**

Swift Certificate Manager works with or without LMS plugins. No LMS data is required.

## **Manual Certificate Assignment**

You can enter certificate details manually and generate a certificate instantly.

Fields include:

* Course name  
* Student name  
* Graduation date  
* Email address

You can also save the information as a draft.

## **Certificate Drafts**

Certificate entries can be saved as drafts and completed later.

## **PDF Download**

Downloaded PDF certificates are available in both Free and Pro.

## **Email Delivery \[Pro\]**

Emailing certificates directly to the student is a Pro-only feature.

## **Certificate Customisation \[Pro\]**

Customisation options include:

* font family  
* font weight  
* text size  
* text positioning  
* signature & signature image

All certificate customisation controls are exclusive to Pro.

## **Certificate Templates**

The plugin includes ready-made certificate templates.

* **Templates 1–3**: Free  
* **Templates 4+**: Pro  
* **Order Customised Certificates**: Pro

## **Certificate Verification**

Each certificate includes a unique code. Anyone can verify using the Verification Page.

## **Online Certificate Requests**

The plugin automatically provides a request page where learners can apply for certificates.

### **Payments**

* Payment gateways (Stripe & PayPal) require **Pro**  
* Request page itself is free, but processing payments requires Pro

## **Admin Request Approval Workflow**

Admin can approve certificate requests, generate certificates, and deliver certificates.

## **Certificate Management**

The Management section includes:

* View created certificates (Free)  
* View certificate requests (Free)  
* View drafts (Free)

Pro-only actions include:

* Edit a generated certificate  
* Delete entries  
* Export CSV

## **Pro Licence Activation**

Enter your License key in the License Management tab to unlock Pro features.


## **Free vs Pro**

### **Free Version**

* Manual certificate creation  
* Save as draft  
* PDF download  
* View certificate records  
* Search & filter  
* First 3 certificate templates  
* General settings  
* Payment Transaction log (view only)  
* Public Verify Certificate page  
* Public Request Certificate page  
* License Management (for upgrading)

### **Pro Version**

* Email Certificate  
* Edit Certification Info  
* Customise Certificate  
* Edit generated certificates  
* Delete certificate entries  
* Export CSV  
* Templates 4+  
* Order Customised Certificates  
* Enable Stripe & PayPal payment gateways  
* Accept paid certificate requests

== Installation ==

This section describes how to install the plugin and get it working.
e.g.

1. Upload the plugin files to the /wp-content/plugins/ directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the ‘Plugins’ screen in WordPress

Swift Certificate Manager will now appear on your dashboard.

## **Getting Started**

After installation:

1. Open **Swift Certificate Manager**  
2. Go to **Settings**  
3. Add instructor details  
4. Add signature or signature image  
5. Set default currency & certificate price  
6. (Pro) Enable Stripe/PayPal  
7. Choose a certificate template  
8. Start creating or accepting certificate requests


## **Admin Menu Overview**

* **Assign Manually**  
* **Management**  
* **Templates**  
* **Settings**


## **1\. Assign Manually**

### **Fields**

* Course Name  
* Student Name  
* Graduation Date  
* Email

### **Actions**

* Create Certificate  
* Save as Draft

Once generated:

* Download PDF (Free \+ Pro)  
* Email Certificate **\[Pro\]**  
* Edit Info **\[Pro\]**  
* Customise Certificate **\[Pro\]**

### **Typical Workflow**

1. Enter details  
2. Create certificate  
3. Review  
4. (Pro) Customise  
5. Download or email


## **2\. Management**

Tabs include:

* Created  
* Request  
* Drafts

Free:

* view all certificates  
* search & filter

Pro:

* edit certificate  
* delete record  
* export CSV  
* edit certification info


## **3\. Templates**

You can:

* preview templates  
* set active template  
* upgrade for premium templates

### **Free Templates**

Templates 1–3

### **Pro Templates**

Template 4+  
Order custom-designed certificates


## **4\. Settings**

### **General Settings (Free)**

Includes:

* instructor details  
* signature options  
* signature image upload  
* default currency  
* certificate price  
* certificate code prefix  
* order / verify URLs  
* shortcodes  
* clear cache

### **Payment Methods (Pro)**

Enables:

* Stripe  
* PayPal

### **Payment Transaction (Free)**

Shows:

* successful  
* pending  
* failed payments

### **License Management**

Enter License key to unlock Pro.


## **Public Pages**

### **Certificate Request Page**

Students can submit certificate requests.  
(Free)  
Payments require Pro.

### **Certificate Verification Page**

Public page for verifying certificates with a unique code.  
(Free)


## **Shortcodes**

### **Request Certificate Form**

```
[swiftcm form="request-swift-certificate-manager"]
```

### **Verify Certificate Form**

```
[swiftcm form="verify-swift-certificate-manager"]
```


## **Typical Workflow**

### **Manual Certificate Workflow**

1. Go to Assign Manually  
2. Enter details  
3. Save or create  
4. Review certificate  
5. (Pro) Customise  
6. Download or email

### **Paid Certificate Request Workflow**

1. Student submits form  
2. Student pays **(Pro)**  
3. Request appears in dashboard  
4. Admin approves  
5. Certificate generated  
6. Certificate emailed or downloaded

### **Certificate Verification Workflow**

1. Visitor enters certificate code  
2. System validates  
3. Displays certificate details


## **Configuration Recommendations**

* Set instructor name  
* Upload clean signature  
* Set currency & certificate price  
* Add certificate code prefix  
* Configure template  
* (Pro) Enable payment gateways  
* Verify both public pages


## **Example Applications**

* Course completion  
* Workshops  
* Seminars  
* Coaching  
* Tutoring  
* Corporate training  
* Attendance certificates  
* Appreciation certificates


## **FAQ**

**Does it require an LMS?**  
No.

**Is it suitable for offline training?**  
Yes.

**Can students request certificates?**  
Yes.

**Can certificates be verified online?**  
Yes.

**Can certificates be emailed?**  
Yes, with Pro.

**Are PDFs downloadable?**  
Yes.

**Which gateways are supported?**  
Stripe and PayPal (Pro).


**How do I unlock Pro templates?**  
Activate with a License key.


## **Troubleshooting**

* Form not showing  
* Verification not working  
* Payments not recorded  
* Emails not delivered  
* Pro not unlocked

(Each with recommendations matching your previous style.)


## **Best Practices**

* Use certificate code prefix  
* Upload clean signature image  
* Test payment gateway (Pro)  
* Verify public pages  
* Export records often (Pro)


== Remote Templates ==

This plugin includes an optional feature that allows administrators to download additional certificate templates from an official public GitHub repository.
Remote requests are only made when the administrator explicitly chooses to download a template.
No personal or sensitive user data is transmitted during this process.
Downloaded templates are stored locally in the WordPress uploads directory.

== Development ==

This plugin uses modern JavaScript tooling (Vue.js + Laravel Mix + Webpack).

### Source Code
Full source code is available at:
https://github.com/ruhel241/swift-certificate-manager

### Build Instructions

To build the plugin assets locally:

1. Install dependencies
   npm install

2. Build for development
   npm run dev

3. Build for production
   npm run production

### Notes

All compiled assets in /assets are generated from the source code using Laravel Mix.

## **Changelog**

### **1.0.0**

* Manual certificate support  
* Drafts  
* PDF download  
* Email delivery (Pro)  
* Templates  
* Request workflow  
* Stripe / PayPal support (Pro)  
* Verification page  
* Pro activation


## **License**

Swift Certificate Manager is distributed as a freemium plugin with Free & Pro tiers.


## **Support**

Contact the official Swift Certificate Manager support team.


## **Credits**

Designed for trainers, educators, and institutions needing a simple certification system.


## **Summary**

Swift Certificate Manager provides a complete workflow for issuing, validating, and managing certificates online, with optional Pro features for payment processing, template expansion, and advanced editing.