<template>
    <div class="wpsc-assign-certificate" style="margin-top: 24px;">
        <InformationForm
            ref="informationForm"
            :info="info"
            :saving="saving"
        />

        <div class="title footer">
          <div style="padding-left: 10px"></div>

          <div class="group-buttons">
              <el-button class="capsule-btn defult-svg-span-btn" round @click="saveHandler('draft')">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M18.3334 8.33332V12.5C18.3334 16.6667 16.6667 18.3333 12.5001 18.3333H7.50008C3.33341 18.3333 1.66675 16.6667 1.66675 12.5V7.49999C1.66675 3.33332 3.33341 1.66666 7.50008 1.66666H11.6667" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M18.3334 8.33332H15.0001C12.5001 8.33332 11.6667 7.49999 11.6667 4.99999V1.66666L18.3334 8.33332Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M5.83325 10.8333H10.8333" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M5.83325 14.1667H9.16659" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Save as Draft
              </el-button>

              <el-button class="wscm-primary-btn svg-span-btn" round @click="saveHandler('assign')">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.5 5.83332V14.1667C17.5 16.6667 16.25 18.3333 13.3333 18.3333H6.66667C3.75 18.3333 2.5 16.6667 2.5 14.1667V5.83332C2.5 3.33332 3.75 1.66666 6.66667 1.66666H13.3333C16.25 1.66666 17.5 3.33332 17.5 5.83332Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12.9166 1.66666V8.21664C12.9166 8.58331 12.4832 8.76664 12.2166 8.52497L10.2833 6.74168C10.1249 6.59168 9.8749 6.59168 9.71656 6.74168L7.78327 8.52497C7.51661 8.76664 7.08325 8.58331 7.08325 8.21664V1.66666H12.9166Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M11.0417 11.6667H14.5834" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M7.5 15H14.5833" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Create Certificate
              </el-button>
          </div>
        </div>
    </div>
</template>

<script>
import InformationForm from './_informationForm.vue';

export default {
    name: 'assign-manually',
    components: {
        InformationForm
    },

    data() {
        return {
            saving: false,
            info: {
                course_name: '',
                student_name: '',
                graduation_date: '',
                student_email: '',
                status: 'assign',
                payment_status: 'free'
            },
            hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro
        }
    },

    methods: {
        async saveHandler(status) {
            this.info.status = status;

            const valid = await this.$refs.informationForm.validateForm();

            if (!valid) {
                this.$handleError('Please fill in all required fields.');
                return;
            }

            this.saving = true;

            this.$post({
                action: 'swift_certificate_manager_generate_admin_ajax',
                route: 'save_certificate_info',
                info: this.info,
                nonce: window.SwiftCertificateManagerAdminVars.nonce
            })
                .then(response => {
                    this.$handleSuccess(response.data.message);

                    this.$router.push({
                        name: 'view_certificate',
                        params: {
                            info: response.data.info,
                            info_id: response.data.info.id,
                        }
                    });
                })
                .fail(error => {
                    this.$handleError(error);
                })
                .always(() => {
                    this.saving = false;
                });
        },
    },

    mounted() {
        jQuery('head title').text('Assign Certificate Manually - Swift Certificate Manager');
    },
}
</script>