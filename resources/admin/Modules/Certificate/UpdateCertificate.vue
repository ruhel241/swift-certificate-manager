<template>
    <div class="swiftcm-assign-certificate">
        <div class="title header">
            <h1>
                {{ $t('Upadte Certificate Manually') }}
            </h1>
            <div class="header-buttons">
                <el-button class="capsule-btn" icon="el-icon-view" round @click="previewCertificate">Preview</el-button>
                <el-button class="capsule-btn" icon="el-icon-document" round @click="updateHandler('draft')">Update as Draft</el-button>
                <el-button class="swiftcm-primary-btn" icon="el-icon-refresh-right" round @click="updateHandler('assign')">Update Certificate Info</el-button>
            </div>
        </div>
        <InformationForm
            :info="info"
            :saving="saving"
        />
    </div>
</template>

<script>
import InformationForm from '../Components/_informationForm.vue';

export default {
    name: 'update-certificate-manually',
    components: {
        InformationForm
    },
    data() {
        return {
            saving: false,
            info: {
                course_name:'',
                student_name:'',
                student_email:'',
                graduation_date:'',
                status: '',
            },

            infoId: parseInt(this.$route.params.info_id)
        }
    },

    methods: {
        previewCertificate() {
            this.$router.push({
                name: 'view_certificate',
                params: {
                    info_id: this.infoId,
                }
            })
        },
        updateHandler(status) {
            this.info.status = status;
          
            this.saving = true;
        
            if (this.info.course_name == '') {
                this.$notify({
                    title: 'Error',
                    message: this.$t('Please write the infomation'),
                    type: 'error'
                });
                return;
            }

            this.$post({
                action: 'swiftcm_generate_admin_ajax',
                route: 'update_certificate_info',
                info: this.info,
                info_id: this.infoId,
                nonce: window.swiftcmAdminVars.nonce
            })
                .then(response => {
                    this.$handleSuccess(response.data.message);
                     this.$router.push({
                        name: 'view_certificate',
                        params: {
                            info_id: response.data.info.id,
                        }
                    })
                })
                .fail(error => {
                    this.$handleError(error);
                })
                .always(() => {
                    this.saving = false;
                });
        },

        fetchInfo() {
            this.saving = true;
            this.$post({
                action: 'swiftcm_generate_admin_ajax',
                route: 'get_certificate_info',
                info_id: this.infoId, 
                nonce: window.swiftcmAdminVars.nonce
            })
              .then(response => {
                  this.info = response.data.info
              })
              .fail(error => {
                  this.$handleError(error);
              })
              .always(() => {
                  this.saving = false;
              });
        }

    },

    mounted() {
        if (this.infoId) {
            this.fetchInfo();
        }
        
        jQuery('head title').text('Update Certificate - Swift Certificate Manager');
    },
    beforeMount() {
      if(this.appVars.is_onboarded === 'no'){
        this.$router.push(
            {
              name: 'setup_template',
              params: {}
            }
        )
      }
    },
}
</script>
