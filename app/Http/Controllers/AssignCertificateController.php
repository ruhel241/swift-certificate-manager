<?php

namespace SwiftCertificateManager\Http\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SwiftCertificateManager\Helpers\ArrayHelper as Arr;
use SwiftCertificateManager\Models\Payment;
use SwiftCertificateManager\Models\SwiftCertificateManagerGenerate;
use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;
use SwiftCertificateManager\Hooks\Handlers\AdminPageHandler;
use SwiftCertificateManager\Models\SwiftCertificateManagerTemplates;
use SwiftCertificateManager\Helpers\HelperFunction;

class AssignCertificateController
{
    public function register() {
        add_action('wp_ajax_wscm_generate_admin_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
        // Nonce check
        if (!check_ajax_referer('swiftcertificate_admin_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid nonce', 'swift-certificate-manager')
            ], 403);
        }

        // Permission check
        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                'message' => __('Unauthorized access', 'swift-certificate-manager')
            ], 403);
        }

        // Route sanitize
        $route = sanitize_text_field(wp_unslash($_REQUEST['route'] ?? ''));

        // Route map
        $maps = [
            'get_certificate_infos'            => 'getCertificateInfos',
            'get_certificate_info'             => 'getCertificateInfoByID',
            'get_customization_certificate'    => 'getCustomizationCertificate',
            'update_customization_certificate' => 'updateCustomizationCertificate',
            'save_certificate_info'            => 'saveCertificateInfo',
            'update_certificate_info'          => 'updateCertificateInfo',
            'maybe_delete_infos'               => 'maybeDeleteInfos',
            'sending_email_certificate'        => 'sendingEmailCertificate',
            'get_csv_download'                 => 'getCsvDownload',
            'redesign_template'                => 'redesignTemplate',
        ];

        // Validate route
        if (!isset($maps[$route])) {
            wp_send_json_error([
                'message' => __('Invalid route', 'swift-certificate-manager')
            ], 400);
        }

        // call method
        do_action('swift-certificate-manager/assi_doing_ajax_forms_' . $route);

        // Pass raw request (sanitize inside method)
        $this->{$maps[$route]}($_REQUEST);

        do_action('swift-certificate-manager/assign_admin_ajax_handler_catch', $route);
    }

    public function getCertificateInfos($request)
    {
        $params = [
            'search'        => sanitize_text_field($request['search'] ?? ''),
            'status'        => sanitize_text_field($request['status'] ?? ''),
            'current_page'  => isset($request['current_page']) ? max(1, absint($request['current_page'])) : 1,
            'per_page'      => isset($request['per_page']) ? max(1, absint($request['per_page'])) : 10,
        ];

        $infos  = new SwiftCertificateManagerGenerate();
        $result = $infos->getDatas($params);

        wp_send_json_success([
            'message'      => __("Get Informations", 'swift-certificate-manager'),
            'infos'        => $result['infos'],
            'total'        => absint($result['total']),
            'last_page'    => absint($result['last_page']),
            'current_page' => absint($result['current_page']),
        ], 200);
    }

    public function getCertificateInfoByID($request)
    {
        $SwiftCertificateManagerGenerate = new SwiftCertificateManagerGenerate();
        $SwiftCertificateManagerPayment  = new Payment();

        // ✅ safer sanitize
        $id = absint($request['info_id'] ?? 0);

        // invalid id
        if (!$id) {
            wp_send_json_error([
                'message' => __('Invalid ID', 'swift-certificate-manager'),
            ], 400);
        }

        $info = $SwiftCertificateManagerGenerate->getInfo($id);

        // not found
        if (!$info) {
            wp_send_json_error([
                'message' => __('Data not found', 'swift-certificate-manager'),
            ], 404);
        }

        // convert after check
        $info = (array) $info;

        // payment data
        $info['payment_transaction'] = $SwiftCertificateManagerPayment
            ->getQuery()
            ->where('request_id', $id)
            ->first();

        wp_send_json_success([
            'message' => __("Get Information", 'swift-certificate-manager'),
            'info'    => $info,
        ], 200);
    }

    public function getCustomizationCertificate($request)
    {
        $SwiftCertificateManagerPayment   = new Payment();
        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();
        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();

        // ✅ safe ID
        $id = absint($request['info_id'] ?? 0);

        if (!$id) {
            wp_send_json_error([
                'message' => __('Invalid ID', 'swift-certificate-manager')
            ], 400);
        }

        // get data
        $info = $SwiftCertificateManagerGenerate->getInfo($id);

        if (!$info) {
            wp_send_json_error([
                'message' => __('Data not found', 'swift-certificate-manager')
            ], 404);
        }

        $info = (array) $info;

        // safe JSON decode
        $infoSettings = json_decode($info['settings'] ?? '', true);
        $infoSettings = is_array($infoSettings) ? $infoSettings : [];

        $templateId = absint($infoSettings['template_id'] ?? 0);

        // safe template fetch
        $getTemplate = $templateId
            ? $SwiftCertificateManagerTemplates->getTemplate($templateId)
            : null;

        wp_send_json_success([
            'message'  => __("Get Information", 'swift-certificate-manager'),
            'info'     => $info,
            'template' => $getTemplate,
            'fonts'    => AvailableOptions::getInstalledFonts()
        ], 200);
    }

    public function updateCustomizationCertificate($request)
    {
        $SwiftCertificateManagerGenerate = new SwiftCertificateManagerGenerate();

        // ✅ safe ID
        $id = absint($request['info_id'] ?? 0);

        if (!$id) {
            wp_send_json_error([
                'message' => __('Invalid ID', 'swift-certificate-manager')
            ], 400);
        }

        // check existing record
        $info = $SwiftCertificateManagerGenerate->getInfo($id);

        if (!$info) {
            wp_send_json_error([
                'message' => __('Data not found', 'swift-certificate-manager')
            ], 404);
        }

        // ✅ safe settings
        $settings = isset($request['settings']) && is_array($request['settings'])
            ? $request['settings']
            : [];

        $updateData = [
            'student_name'    => sanitize_text_field($settings['student_name'] ?? ''),
            'course_name'     => sanitize_text_field($settings['course_name'] ?? ''),
            'graduation_date' => sanitize_text_field($settings['graduation_date'] ?? ''),
            'settings'        => wp_json_encode($settings),
            'updated_at'      => gmdate('Y-m-d H:i:s'),
        ];

        $SwiftCertificateManagerGenerate->updateInfo($id, $updateData);

        wp_send_json_success([
            'message' => __("Successfully updated", 'swift-certificate-manager')
        ], 200);
    }

    public function saveCertificateInfo($request)
    {
        $infoRaw = isset($request['info']) ? (array) $request['info'] : [];

        $info = [
            'student_name'    => sanitize_text_field($infoRaw['student_name'] ?? ''),
            'student_email'   => sanitize_email($infoRaw['student_email'] ?? ''),
            'course_name'     => sanitize_text_field($infoRaw['course_name'] ?? ''),
            'status'          => sanitize_text_field($infoRaw['status'] ?? ''),
            'payment_status'  => sanitize_text_field($infoRaw['payment_status'] ?? ''),
            'graduation_date' => sanitize_text_field($infoRaw['graduation_date'] ?? ''),
        ];

        $status        = $info['status'];
        $paymentStatus = $info['payment_status'];

        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();
        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();
        $helperFunction            = new HelperFunction();


        // Settings
        $globalSettings        = get_option('swift_certificate_manager_global_settings', []);
        $certificateCodePrefix = $globalSettings['certificate_code_prefix'] ?? '';

        // Generate code
        $certificateCode = $helperFunction->generateCertificateCode($certificateCodePrefix);

        // Template
        $activeTemplate = get_option('swift_certificate_manager_active_template', 'template-1');
        $getTemplate    = $SwiftCertificateManagerTemplates->getTemplateSlug($activeTemplate);
        $settings       = json_decode($getTemplate->settings, true);

        $preference = $globalSettings['preference'] ?? 'instructor';

        // Date format
        $graduationDate = !empty($info['graduation_date'])
            ? gmdate("d F Y", strtotime($info['graduation_date']))
            : gmdate("d F Y");

        // Build settings
        $settings['student_name']             = $info['student_name'];
        $settings['course_name']              = $info['course_name'];
        $settings['graduation_date']          = $graduationDate;
        $settings['certificate_code']         = $certificateCode;
        $settings['instructor_name']          = $globalSettings[$preference . '_name'] ?? '';
        $settings['instructor_signature']     = $globalSettings[$preference . '_signature'] ?? '';
        $settings['instructor_signature_img'] = $globalSettings[$preference . '_signature_img'] ?? '';
        $settings['template_id']              = $getTemplate->id ?? 0;

        // Insert data
        $data = [
            'status'           => $status,
            'student_name'     => $info['student_name'],
            'student_email'    => $info['student_email'],
            'course_name'      => $info['course_name'],
            'payment_status'   => $paymentStatus,
            'graduation_date'  => $graduationDate,
            'certificate_code' => $certificateCode,
            'qr_code_url'      => esc_url_raw(get_site_url() . '/verify-form/?code=' . urlencode($certificateCode)),
            'settings'         => wp_json_encode($settings),
            'created_at'       => gmdate('Y-m-d H:i:s'),
            'updated_at'       => gmdate('Y-m-d H:i:s'),
        ];

        $certificateGenerateId = $SwiftCertificateManagerGenerate->insertGetId($data);
        $certificateData       = $SwiftCertificateManagerGenerate->getInfo($certificateGenerateId);

        // Message
        $message = ($status === 'draft')
            ? __("Successfully draft", 'swift-certificate-manager')
            : __("Successfully created", 'swift-certificate-manager');

        wp_send_json_success([
            'message' => $message,
            'info'    => $certificateData
        ], 200);
    }

    public function sendingEmailCertificate($request)
    {
        $info = isset($request['info']) && is_array($request['info'])
            ? $request['info']
            : [];

        $pdfData     = $this->getPDFandImageURL($request);
        $pdfFilePath = $pdfData['pdf_data']['pdf_file_path'] ?? '';

        $studentName     = sanitize_text_field($info['student_name'] ?? '');
        $studentEmail    = sanitize_email($info['student_email'] ?? '');
        $graduationDate  = sanitize_text_field($info['graduation_date'] ?? '');
        $certificateCode = sanitize_text_field($info['certificate_code'] ?? '');
        $courseName      = sanitize_text_field($info['course_name'] ?? '');

        if (empty($studentEmail) || !is_email($studentEmail)) {
            wp_send_json_error(['message' => 'Invalid email address']);
        }

        if (empty($pdfFilePath) || !file_exists($pdfFilePath)) {
            wp_send_json_error(['message' => 'PDF not found']);
        }

        $to      = $studentEmail;
        $subject = '[Swift Certificate Manager] PDF Attachment';

        $body  = 'Hi ' . esc_html($studentName) . ", Here's your certificate.<br><br>";
        $body .= $this->emailHtmlBody([
            'student_name'     => $studentName,
            'student_email'    => $studentEmail,
            'graduation_date'  => $graduationDate,
            'certificate_code' => $certificateCode,
            'course_name'      => $courseName,
        ]);

        $headers     = ['Content-Type: text/html; charset=UTF-8'];
        $attachments = [$pdfFilePath];

        $send = wp_mail($to, $subject, $body, $headers, $attachments);

        if (!$send) {
            wp_send_json_error(['message' => 'Failed to send email']);
        }

        wp_send_json_success(['message' => 'Email sent successfully']);
    }

    public function emailHtmlBody($data) {
        $studentName     = esc_html($data['student_name']);
        $studentEmail    = esc_html($data['student_email']);
        $graduationDate  = esc_html($data['graduation_date']);
        $certificateCode = esc_html($data['certificate_code']);
        $courseName      = esc_html($data['course_name']);
        $verifyUrl       = esc_url(get_site_url() . '/verify-swift-certificate-manager/?code=' . urlencode($data['certificate_code']));
        
        return "
        <div style='background-color:#f5f7fa; padding:30px 20px; font-family:Arial, sans-serif;'>
            <div style='max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:rgba(0, 0, 0, 0.24) 0px 3px 8px;'>
                <!-- Header -->
                <div style='background:#4f46e5; color:#ffffff; padding:20px; text-align:center;'>
                    <h2 style='margin:0; font-size:22px;'>🎓 Certificate Issued</h2>
                    <p style='margin:5px 0 0; font-size:14px;'>Congratulations on your achievement!</p>
                </div>

                <!-- Body -->
                <div style='padding:25px; color:#333;'>
                    <p style='font-size:15px;'>Hi <strong>" . esc_html($studentName) . "</strong>,</p>
                    <p style='font-size:14px; line-height:1.6;'>
                        We're happy to inform you that your certificate has been successfully generated.
                        You can find your details below.
                    </p>

                    <!-- Table -->
                    <table style='width:100%; border-collapse:collapse; margin:20px 0; font-size:14px; text-align:left;'>
                        <tr style='background:#f1f5f9;'>
                            <th style='border:1px solid #e5e7eb; padding:8px;'>Student</th>
                            <td style='border:1px solid #ddd; padding:8px;'>$studentName</td>
                        </tr>
                        <tr>
                            <th style='border:1px solid #e5e7eb; padding:8px;'>Course</th>
                            <td style='border:1px solid #ddd; padding:8px;'> $courseName </td>
                        </tr>
                        <tr style='background:#f9fafb;'>
                            <th style='border:1px solid #e5e7eb; padding:8px;'>Email</th>
                            <td style='border:1px solid #ddd; padding:8px;'> $studentEmail </td>
                        </tr>
                        <tr>
                            <th style='border:1px solid #e5e7eb; padding:8px;'>Graduation Date</th>
                            <td style='border:1px solid #ddd; padding:8px;'> $graduationDate </td>
                        </tr>
                        <tr style='background:#f1f5f9;'>
                            <th style='border:1px solid #e5e7eb; padding:8px;'>Certificate Code</th>
                            <th style='border:1px solid #ddd; padding:8px;'> $certificateCode </th>
                        </tr>
                    </table>

                    <p style='font-size:14px;'>
                        Please find your certificate attached with this email.
                    </p>

                    <!-- Button -->
                    <div style='text-align:center; margin:25px 0;'>
                        <a href='" . esc_url(get_site_url() . '/verify-swift-certificate-manager/?code=' . urlencode($certificateCode)) . "' style='background:#4f46e5; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:5px; font-size:14px; display:inline-block;'>
                            Verify Certificate
                        </a>
                    </div>

                    <p style='font-size:13px; color:#666;'>
                        If you have any questions, feel free to contact us.
                    </p>

                </div>

                <!-- Footer -->
                <div style='background:#f9fafb; text-align:center; padding:15px; font-size:12px; color:#888;'>
                    © " . esc_html(get_bloginfo('name')) . " — All rights reserved
                </div>
            </div>
        </div>";    
    }

    public function getPDFandImageURL($request) {
        // Check if we have the necessary data
        if (!isset($request['certificate_data'])) {
            wp_send_json_error(['message' => 'No certificate data provided']);
            return;
        }

        $info = $request['info'];
        // Get image data from POST
        $image_data = $request['certificate_data'];

        // Get student name and course name for the filename
        $studentName     = isset($info['student_name']) ? sanitize_title($info['student_name']) : 'certificate';
        $certificateCode = isset($info['certificate_code']) ? sanitize_text_field($info['certificate_code']) : '';

        // Get uploads directory
        $upload_dir = wp_upload_dir();
        $certificates_dir = $upload_dir['basedir'] .'/'. SWIFT_CERTIFICATE_MANAGER_UPLOAD_DIR .'/temp';

        // Create certificates directory if it doesn't exist
        if (!file_exists($certificates_dir)) {
            wp_mkdir_p($certificates_dir);
            file_put_contents($certificates_dir . '/index.php', '<?php // Silence is golden');
        }

        // Extract base64 data properly
        if (preg_match('/^data:image\/(jpeg|png|jpg);base64,(.+)$/i', $image_data, $matches)) {
            $image_type = $matches[1];
            $image_data = $matches[2];
        } else {
            // Try with a simpler approach if the regex fails
            $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
            $image_data = str_replace('data:image/png;base64,', '', $image_data);
            $image_data = str_replace(' ', '+', $image_data);
            $image_type = 'jpeg'; // Default to JPEG
        }

        // Decode the base64 data
        $raw_data = base64_decode($image_data, true);

        if ($raw_data === false) {
            wp_send_json_error(['message' => 'Invalid image data']);
            return;
        }

        // Generate a unique filename using student name and certificate code
        $imageFileName = $studentName . '-' . $certificateCode . ".png"; // Using PNG for compatibility
        // image file path
        $imageFilePath = $certificates_dir .'/'. $imageFileName; // Using PNG for compatibility

        // first of all old image file delete if same name exist.
        if (!empty($imageFileName)) {
            AvailableOptions::removedFile($imageFileName);
        }
        
        if (file_put_contents($imageFilePath, $raw_data) === false) {
            wp_send_json_error(['message' => 'Failed to process image']);
            return;
        }

        // image URL and path
        $imageData = [
            'image_file_path' => $imageFilePath,
            'image_name'      => $imageFileName,
            'image_url'       => str_replace(ABSPATH, site_url('/') , $imageFilePath),
        ];

        // Generate PDF directly from the image data
        $pdfData = $this->generatePDFbyImageData($raw_data, $studentName, $certificateCode);

        return [
            'image_data' => $imageData,
            'pdf_data'   => $pdfData
        ];
    }

    public function generatePDFbyImageData($imageData, $studentName, $certificateCode) {
        $getDirStructure = AvailableOptions::getDirStructure();
        $uploadDir       = rtrim($getDirStructure['tempDir'], '/') . '/';
        $currentTime     = time();

        $pdfFileName     = $studentName . '-' . $certificateCode. ".pdf";
        $pdfFilePath     = $uploadDir . $pdfFileName;

        // first of all old pdf file delete if same name exist.
        if (!empty($pdfFileName)) {
            AvailableOptions::removedFile($pdfFileName);
        }

        try {
            $image = @imagecreatefromstring($imageData);
            if (!$image) {
                return false;
            }

            $imgW = imagesx($image);
            $imgH = imagesy($image);

            // // ✅ Create temp png for FPDF Image()
            $temp_png = $uploadDir . 'temp_' . $currentTime . '.png';
            imagepng($image, $temp_png);
            imagedestroy($image);

            // ✅ IMPORTANT: Use custom page size EXACTLY as image size (no white bars)
            // Use unit "pt" so we can pass pixel-like values safely
            $orientation = ($imgW > $imgH) ? 'L' : 'P';
            $pdf = new \FPDF($orientation, 'pt', array($imgW, $imgH));
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage($orientation, array($imgW, $imgH));

            // ✅ Full-bleed: image fills entire PDF page
            $pdf->Image($temp_png, 0, 0, $imgW, $imgH);

            $pdf->Output($pdfFilePath, 'F');

            wp_delete_file($temp_png);
            
            $pdfData = [
                'pdf_file_path' => $pdfFilePath,
                'pdf_name'      => $pdfFileName,
                'pdf_url'       => str_replace(ABSPATH, site_url('/') , $pdfFilePath)
            ];

            return $pdfData;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateCertificateInfo($request)
    {
        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();
        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();

        // ✅ safe ID
        $id = absint($request['info_id'] ?? 0);

        if (!$id) {
            wp_send_json_error([
                'message' => __('Invalid ID', 'swift-certificate-manager')
            ], 400);
        }

        // check record exists
        $info = $SwiftCertificateManagerGenerate->getInfo($id);

        if (!$info) {
            wp_send_json_error([
                'message' => __('Data not found', 'swift-certificate-manager')
            ], 404);
        }

        // ✅ safe input data
        $infoData = isset($request['info']) && is_array($request['info'])
            ? $request['info']
            : [];

        // settings
        $activeTemplate = get_option('swift_certificate_manager_active_template', 'template-1');
        $getTemplate    = $SwiftCertificateManagerTemplates->getTemplateSlug($activeTemplate);

        $settings = json_decode($getTemplate->settings ?? '', true);
        $settings = is_array($settings) ? $settings : [];

        $globalSettings = get_option('swift_certificate_manager_global_settings', []);
        $preference     = $globalSettings['preference'] ?? '';

        // build settings safely
        $settings['student_name']     = sanitize_text_field($infoData['student_name'] ?? '');
        $settings['course_name']      = sanitize_text_field($infoData['course_name'] ?? '');
        $settings['graduation_date']  = sanitize_text_field($infoData['graduation_date'] ?? '');

        $settings['instructor_name']                 = $globalSettings[$preference . '_name'] ?? '';
        $settings['instructor_signature']            = $globalSettings[$preference . '_signature'] ?? '';
        $settings['instructor_signature_img']        = $globalSettings[$preference . '_signature_img'] ?? '';
        $settings['instructor_signature_img_enable'] = $globalSettings[$preference . '_signature_img_enable'] ?? '';
        $settings['template_id']                     = $getTemplate->id ?? 0;

        // update data
        $updateData = [
            'status'          => sanitize_text_field($infoData['status'] ?? ''),
            'student_name'    => sanitize_text_field($infoData['student_name'] ?? ''),
            'student_email'   => sanitize_email($infoData['student_email'] ?? ''),
            'course_name'     => sanitize_text_field($infoData['course_name'] ?? ''),
            'graduation_date' => sanitize_text_field($infoData['graduation_date'] ?? ''),
            'settings'        => wp_json_encode($settings),
            'updated_at'      => gmdate('Y-m-d H:i:s')
        ];

        $SwiftCertificateManagerGenerate->updateInfo($id, $updateData);

        $message = (($infoData['status'] ?? '') === 'draft')
            ? __("Successfully updated draft", 'swift-certificate-manager')
            : __("Successfully updated", 'swift-certificate-manager');

        wp_send_json_success([
            'message' => $message,
            'info'    => $SwiftCertificateManagerGenerate->getInfo($id)
        ], 200);
    }

    public function maybeDeleteInfos($request)
    {
        $SwiftCertificateManagerGenerate = new SwiftCertificateManagerGenerate();

        // ✅ safe action type (whitelist)
        $actionType = sanitize_text_field($request['action_type'] ?? '');

        $allowedActions = ['delete', 'draft', 'publish'];

        if (!in_array($actionType, $allowedActions, true)) {
            wp_send_json_error([
                'message' => __('Invalid action type', 'swift-certificate-manager')
            ], 400);
        }

        // ✅ safe bulk IDs
        $infoIds = $request['info_ids'] ?? [];

        if (!is_array($infoIds)) {
            wp_send_json_error([
                'message' => __('Invalid data format', 'swift-certificate-manager')
            ], 400);
        }

        // sanitize IDs
        $infoIds = array_map('absint', $infoIds);
        $infoIds = array_filter($infoIds); // remove 0 values

        if (empty($infoIds)) {
            wp_send_json_error([
                'message' => __('No valid items selected', 'swift-certificate-manager')
            ], 400);
        }

        // DELETE action
        if ($actionType === 'delete') {
            $SwiftCertificateManagerGenerate->deleteInfo($infoIds);

            wp_send_json_success([
                'message' => __('Selected infos successfully deleted', 'swift-certificate-manager')
            ], 200);
        }

        // UPDATE STATUS action
        $SwiftCertificateManagerGenerate->updateStatus($infoIds, $actionType);

        wp_send_json_success([
            'message' => __('Selected infos successfully updated', 'swift-certificate-manager')
        ], 200);
    }

    // download CSV File
    public function getCsvDownload($request)
    {
        try {
            // optional: ensure no previous output
            if (ob_get_length()) {
                ob_end_clean();
            }

            $certificateService = new SwiftCertificateManagerGenerate();

            // Note: request sanitization handled inside getDatas()
            $result       = $certificateService->getDatas($request);
            $certificates = $result['infos'] ?? [];

            if (empty($certificates)) {
                wp_send_json_error([
                    'message' => __('No certificate data available for export', 'swift-certificate-manager')
                ], 404);
            }

            $date     = gmdate('Y-m-d');
            $filename = sanitize_file_name("swift-certificate-manager-export-{$date}.csv");

            // headers check
            if (!headers_sent()) {
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Pragma: no-cache');
                header('Expires: 0');
            }

            $output = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // headers
            fputcsv($output, [
                __('Serial', 'swift-certificate-manager'),
                __('Course Name', 'swift-certificate-manager'),
                __('Student Name', 'swift-certificate-manager'),
                __('Student Email', 'swift-certificate-manager'),
                __('Graduation Date', 'swift-certificate-manager'),
                __('Certificate Code', 'swift-certificate-manager'),
                __('Status', 'swift-certificate-manager'),
                __('Payment Status', 'swift-certificate-manager'),
                __('Created At', 'swift-certificate-manager')
            ]);

            foreach ($certificates as $index => $certificate) {
                $row = [
                    $index + 1,
                    $this->sanitizeCsvField($certificate->course_name ?? ''),
                    $this->sanitizeCsvField($certificate->student_name ?? ''),
                    $this->sanitizeCsvField($certificate->student_email ?? ''),
                    $this->sanitizeCsvField($certificate->graduation_date ?? ''),
                    $this->sanitizeCsvField($certificate->certificate_code ?? ''),
                    $this->sanitizeCsvField($certificate->status ?? ''),
                    $this->sanitizeCsvField($certificate->payment_status ?? ''),
                    $this->sanitizeCsvField($certificate->created_at ?? '')
                ];

                fputcsv($output, $row);
            }

            fclose($output);
            exit;

        } catch (Exception $e) {
            wp_send_json_error([
                'message' => __('Failed to generate CSV export', 'swift-certificate-manager')
            ], 500);
        }
    }
    /**
     * Sanitize field values for CSV export to prevent formula injection
     *
     * @param string $field Field value to sanitize
     * @return string Sanitized field value
     */
    private function sanitizeCsvField($field)
    {
        $field = (string)$field;

        // Prevent formula injection in Excel by prefixing fields that start with =, +, -, or @
        if (preg_match('/^[=\+\-@]/', $field)) {
            $field = "'" . $field;
        }

        return $field;
    }
    
    // when user want to redesign certificate from single customization page.
    public function redesignTemplate($request)
    {
        // ✅ validate template_id
        $templateId = absint($request['template_id'] ?? 0);

        if (!$templateId) {
            wp_send_json_error([
                'message' => __('Template ID is required', 'swift-certificate-manager')
            ], 400);
        }

        // ✅ validate info_id
        $infoId = absint($request['info_id'] ?? 0);

        if (!$infoId) {
            wp_send_json_error([
                'message' => __('Invalid info ID', 'swift-certificate-manager')
            ], 400);
        }

        $SwiftCertificateManagerTemplates = new SwiftCertificateManagerTemplates();
        $SwiftCertificateManagerGenerate  = new SwiftCertificateManagerGenerate();

        // ✅ get template
        $getTemplate = $SwiftCertificateManagerTemplates->getTemplate($templateId);

        if (!$getTemplate) {
            wp_send_json_error([
                'message' => __('Template not found', 'swift-certificate-manager')
            ], 404);
        }

        // ✅ safe slug
        $slug = sanitize_key($getTemplate->slug ?? '');

        // ✅ get info
        $info = $SwiftCertificateManagerGenerate->getInfo($infoId);

        if (!$info) {
            wp_send_json_error([
                'message' => __('Certificate data not found', 'swift-certificate-manager')
            ], 404);
        }

        $info = (array) $info;

        // ✅ safe config
        $getConfig = AvailableOptions::getConfig();
        $settings  = isset($getConfig[$slug]) && is_array($getConfig[$slug])
            ? wp_unslash($getConfig[$slug])
            : [];

        // sanitize + override dynamic values
        $settings['student_name']     = sanitize_text_field($info['student_name'] ?? '');
        $settings['course_name']      = sanitize_text_field($info['course_name'] ?? '');
        $settings['graduation_date']  = sanitize_text_field($info['graduation_date'] ?? '');
        $settings['certificate_code'] = sanitize_text_field($info['certificate_code'] ?? '');
        $settings['template_id']      = $templateId;

        // update
        $updateData = [
            'settings'   => wp_json_encode($settings),
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $SwiftCertificateManagerGenerate->updateInfo($infoId, $updateData);

        wp_send_json_success([
            'message' => __('Successfully Redesign Certificate', 'swift-certificate-manager')
        ]);
    }
}