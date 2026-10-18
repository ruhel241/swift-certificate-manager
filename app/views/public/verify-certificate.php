<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="swifcema-verify-form-wrapper">
    <div class="swifcema-card">
        <h2 class="swifcema-title"><?php echo esc_html__( 'Verify Certificate', 'swift-certificate-manager' ); ?></h2>
        <div class="swifcema-verify-certificate-message"></div>
        <form id="verifyForm" class="swifcema-form" method="get">
            <label><?php echo esc_html__( 'Certificate Code', 'swift-certificate-manager' ); ?></label>
            <input type="text" id="certificate_code" name="certificate_code" placeholder="<?php echo esc_attr__( 'Enter certificate code', 'swift-certificate-manager' ); ?>" required>
            <button type="submit"><?php echo esc_html__( 'Verify', 'swift-certificate-manager' ); ?></button>
        </form>
        <div class="swifcema-loader swifcema-loading-spinner" style="display:none;">
            <img src="<?php echo esc_url(SWIFCEMA_PLUGIN_URL.'assets/public/images/loading.gif'); ?>" alt="<?php echo esc_attr__( 'Loading...', 'swift-certificate-manager' ); ?>" />
        </div>
        <div class="swifcema-result swifcema-student-information" style="display:none;">
            <div class="swifcema-grid">
                <div class="item student_name">
                    <span class="label"><?php echo esc_html__( 'Student Name', 'swift-certificate-manager' ); ?></span>
                    <span class="value"></span>
                </div>
                <div class="item course_name">
                    <span class="label"><?php echo esc_html__( 'Certificate', 'swift-certificate-manager' ); ?></span>
                    <span class="value"></span>
                </div>
                <div class="item student_email">
                    <span class="label"><?php echo esc_html__( 'Email', 'swift-certificate-manager' ); ?></span>
                    <span class="value"></span>
                </div>
                <div class="item graduation_date">
                    <span class="label"><?php echo esc_html__( 'Graduation Date', 'swift-certificate-manager' ); ?></span>
                    <span class="value"></span>
                </div>
                <div class="item full certificate_code">
                    <span class="label"><?php echo esc_html__( 'Certificate Code', 'swift-certificate-manager' ); ?></span>
                    <span class="value"></span>
                </div>
            </div>
        </div>
    </div>
</div>