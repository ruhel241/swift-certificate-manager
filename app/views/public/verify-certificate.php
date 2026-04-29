<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wscm-verify-form-wrapper">
    <div class="wscm-card">
        <h2 class="wscm-title">Verify Certificate</h2>
        <div class="wscm-verify-certificate-message"></div>
        <form id="verifyForm" class="wscm-form" method="get">
            <label>Certificate Code</label>
            <input type="text" id="certificate_code" name="certificate_code" placeholder="Enter certificate code" required>
            <button type="submit">Verify</button>
        </form>
        <div class="wscm-loader wscm-loading-spinner" style="display:none;">
            <img src="<?php echo esc_url(SWIFT_CERTIFICATE_PLUGIN_URL.'assets/public/images/loading.gif'); ?>" alt="Loading..." />
        </div>
        <div class="wscm-result wscm-student-information" style="display:none;">
            <div class="wscm-grid">
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