<template>
  <div class="wscm-customization">
      <div class="title header">
        <h1>Edit {{ info.status.charAt(0).toUpperCase() + info.status.slice(1) }} Customize Certificate</h1>
        <div class="header-buttons">
          <el-button class="capsule-btn" icon="el-icon-view" round @click="previewCertificate">Preview</el-button>
          <el-button
              class="wscm-primary-btn"
              type="success"
              icon="el-icon-circle-plus-outline"
              round
              @click="updateCustomizations"
          >
            {{ $t("Update Customization Certificate") }}
          </el-button>
        </div>
      </div>
      <CustomizationsComponent
        :fetching="fetching"
        :redesigning="redesigning"
        :template="template"
        :fonts="fonts"
        :settings="settings"
        :certificateCodePrefix="certificateCodePrefix"
        :verifyCertificateUrl="verifyCertificateUrl"
        @redesignCertificate="redesignCertificate"
      />
  </div>
</template>

<script>
import CustomizationsComponent from '../Components/CustomizationsComponent.vue';

export default {
  name: "edit_certificate_customizations",
  components: {
    CustomizationsComponent
  },
  data() {
    return {   
        saving: false,
        fetching: false,
        redesigning: false,
        infoId: parseInt(this.$route.params.info_id),
        template: "",
        fonts: {},
        info: {
          status: ''
        },
        settings: {
          instructor_active_signature: 'no',
          auth_active_signature: 'no',
          qr_code_url: ''
        },
        certificateCodePrefix: window.SwiftCertificateManagerAdminVars.globalSettings.certificate_code_prefix || '',
        verifyCertificateUrl: window.SwiftCertificateManagerAdminVars.globalSettings.verify_certificate_url || 'https://example.com/',
    };
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
    getTemplate() {
      this.fetching = true;
      this.$get({
        action: "wscm_generate_admin_ajax",
        route: "get_customization_certificate",
        info_id: this.infoId,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
          .then((response) => {
            this.info = response.data.info
            this.template = response.data.template;
            this.fonts = response.data.fonts;
            this.settings = jQuery.parseJSON(response.data.info.settings);
            this.settings.qr_code_url = this.verifyCertificateUrl + '?code=' + this.settings.certificate_code;
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            setTimeout(() => {
                 this.fetching = false;
            }, 500);
          });
    },

    updateCustomizations() {
      this.saving = true;
      this.fetching = true;
      this.$post({
        action: "wscm_generate_admin_ajax",
        route: "update_customization_certificate",
        settings: this.settings,
        info_id: this.infoId,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
          .then((response) => {
            this.getTemplate();
            this.$handleSuccess(response.data.message);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
              this.saving = false;
              this.fetching = false;
          });
    },

    redesignCertificate() {
      this.fetching = true;
      this.redesigning = true;
      this.$post({
        action: "wscm_generate_admin_ajax",
        route: "redesign_template",
        info_id: this.infoId,
        template_id: this.settings.template_id,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
          .then((response) => {
            this.getTemplate();
            this.$handleSuccess(response.data.message);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            this.fetching = false;
            this.redesigning = false;
          });
    },

  },
  beforeMount() {
    if (this.appVars && this.appVars.is_onboarded === 'no') {
      this.$router.push(
          {
            name: 'setup_template',
            params: {}
          }
      )
    }
  },
  mounted() {  
    this.getTemplate();
    jQuery('head title').text('Edit Customizations Certificate - Swift Certificate Manager');
  },
};
</script>