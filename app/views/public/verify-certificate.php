<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="swifcema-verify-form-wrapper">
    <div class="swifcema-card">
        <h2 class="swifcema-title">Verify Certificate</h2>
        <div class="swifcema-verify-certificate-message"></div>
        <form id="verifyForm" class="swifcema-form" method="get">
            <label>Certificate Code</label>
            <input type="text" id="certificate_code" name="certificate_code" placeholder="Enter certificate code" required>
            <button type="submit">Verify</button>
        </form>
        <div class="swifcema-loader swifcema-loading-spinner" style="display:none;">
            <img src="<?php echo esc_url(SWIFCEMA_PLUGIN_URL.'assets/public/images/loading.gif'); ?>" alt="Loading..." />
        </div>
        <div class="swifcema-result swifcema-student-information" style="display:none;">
            <div class="swifcema-grid">
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