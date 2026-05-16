<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="swiftcm-verify-form-wrapper">
    <div class="swiftcm-card">
        <h2 class="swiftcm-title">Verify Certificate</h2>
        <div class="swiftcm-verify-certificate-message"></div>
        <form id="verifyForm" class="swiftcm-form" method="get">
            <label>Certificate Code</label>
            <input type="text" id="certificate_code" name="certificate_code" placeholder="Enter certificate code" required>
            <button type="submit">Verify</button>
        </form>
        <div class="swiftcm-loader swiftcm-loading-spinner" style="display:none;">
            <img src="<?php echo esc_url(SWIFT_CERTIFICATE_MANAGER_PLUGIN_URL.'assets/public/images/loading.gif'); ?>" alt="Loading..." />
        </div>
        <div class="swiftcm-result swiftcm-student-information" style="display:none;">
            <div class="swiftcm-grid">
                <div class="item student_name">
                    <span class="label">Student Name</span>
                    <span class="value"></span>
                </div>
                <div class="item course_name">
                    <span class="label">Certificate</span>
                    <span class="value"></span>
                </div>
                <div class="item student_email">
                    <span class="label">Email</span>
                    <span class="value"></span>
                </div>
                <div class="item graduation_date">
                    <span class="label">Graduation Date</span>
                    <span class="value"></span>
                </div>
                <div class="item full certificate_code">
                    <span class="label">Certificate Code</span>
                    <span class="value"></span>
                </div>
            </div>
        </div>
    </div>
</div>