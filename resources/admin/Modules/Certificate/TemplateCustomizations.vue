<template>
  <div class="wscm-customization">
    <div class="title header">
      <h1>Template Customize Certificate</h1>
      <div class="header-buttons">
        <el-button
            class="wscm-primary-btn"
            type="success"
            icon="el-icon-circle-plus-outline"
            round
            @click="saveCustomizations"
        >
          {{ $t("Save Certificate") }}
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
  name: "template_customizations",
  components: {
    CustomizationsComponent
  },
  data() {
    return {   
        saving: false,
        fetching: false,
        redesigning: false,
        templateID: parseInt(this.$route.params.template_id),
        template: "",
        fonts: {},
        settings: {
          instructor_active_signature: 'no',
          auth_active_signature: 'no',
          qr_code_url: ''
        },
        certificateCodePrefix: window.SwiftCertificateManagerAdminVars.globalSettings.certificate_code_prefix || '',
        verifyCertificateUrl: window.SwiftCertificateManagerAdminVars.globalSettings.verify_certificate_url || 'https://example.com/',
        globalSettings: window.SwiftCertificateManagerAdminVars.globalSettings,
    };
  },
  watch: {
    globalSettings: {
      immediate: true,
      deep: true,
      handler(newVal) {
        this.globalSettingsInfoUpdate(newVal);
      }
    }
  },
  methods: { 
      getTemplate() {
        this.fetching = true;
        this.$get({
          action: "wscm_template_admin_ajax",
          route: "get_template",
          template_id: this.templateID,
          nonce: window.SwiftCertificateManagerAdminVars.nonce,
        })
            .then((response) => {
              this.template = response.data.template;
              this.fonts = response.data.fonts;
              this.settings = jQuery.parseJSON(response.data.template.settings);
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
      saveCustomizations() {
        this.saving = true;
        this.fetching = true;
        this.template.settings = this.settings;
        this.$post({
          action: "wscm_template_admin_ajax",
          route: "update_template",
          template: this.template,
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
        this.template.settings = this.settings;
        this.redesigning = true;
        this.$post({
          action: "wscm_template_admin_ajax",
          route: "redesign_template",
          template_id: this.templateID,
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

      globalSettingsInfoUpdate() {
        setTimeout(() => {
          this.settings.instructor_name = this.globalSettings[this.globalSettings.preference + '_name'];
          this.settings.instructor_signature = this.globalSettings[this.globalSettings.preference + '_signature'];
          this.settings.instructor_signature_img = this.globalSettings[this.globalSettings.preference + '_signature_img'];
          this.settings.instructor_signature_img_enable = this.globalSettings[this.globalSettings.preference + '_signature_img_enable'];
        }, 500);
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
    jQuery('head title').text('Template Customizations Certificate - Swift Certificate Manager');
  },
};
</script>