<template>
  <div class="wpsc-templates">
    <div class="title header">
      <h1>Templates</h1>
      <!-- {{ templates }} -->
      <div class="btn-handler">
        <!-- <el-button icon="el-icon-refresh" round @click="saveTemplatesHandlerByApi" v-if="downloadableTemplates">
          Fetch Templates
        </el-button> -->
        <el-button class="capsule-btn" icon="el-icon-service" round  @click="upgradePopupHandler">
          Order Customized Certificates
        </el-button>
        <UpgradePopup 
          :upgradePopupVisible="upgradePopupVisible"
          @close="upgradePopupVisible = false"
        />
      </div>
    </div>

    <div class="templates-wrap">
      <div class="wscm_downloader_wrapper" v-if="downloadableTemplates">
        <div class="wscm_templates_installation_message">
          <h2 class="wscm_title">Templates Are Required To Generate Certificates.</h2>
          <p class="mb10" style="margin-bottom: 30px;">
            This module requires you to download the certificate templates. Please click the button below to download the required template files. This is a one-time setup.
          </p>

          <el-button
              class="wscm-pro-btn"
              round
              @click="saveTemplatesHandlerByApi"
              v-if="isOnboarded === 'yes'"
          >
            Install Templates
          </el-button>
        </div>
      </div>

      <div class="templates" v-if="!downloadableTemplates">
        <el-row :gutter="20" v-if="templates && templates.length">
          <el-col :span="6" class="mb20 pro-template" v-for="(template, index) in templates" :key="index">
            <el-card class="box-card" :body-style="{ padding: '0px' }">
              <div class="template-image">
                <img :src="uploadCertificateUrl+template.template_image" class="image"/>
              </div>
              <div class="title" style="padding: 0px 10px; text-align: center;">
                <p>{{ template.title }}</p>
              </div>
              <div class="card-actions">
                <el-button
                    class="wscm-primary-btn"
                    v-if="activeTemplate === template.slug"
                    type="success"
                    round
                    style="width: 100%"
                >
                  Active Template
                </el-button>
                <el-button
                    v-else
                    class="capsule-btn"
                    round
                    @click="saveActivatedTemplate(template.slug)"
                    style="width: 100%"
                    :disabled="hasProHandler(template)"
                >
                  Use This Template
                </el-button>
                <el-button
                    class="capsule-btn"
                    round
                    @click="gotoCustomizations(template.id)"
                    v-if="isOnboarded === 'yes'"
                    :disabled="hasProHandler(template)"
                    icon="el-icon-view"
                >
                  View
                </el-button>
              </div>
              <div class="template-overlay" v-if="hasProHandler(template)">
                <a href="/#">
                  <button class="upgrade-btn">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M13.9166 15.8167H6.08325C5.73325 15.8167 5.34159 15.5417 5.22492 15.2083L1.77492 5.55834C1.28326 4.17501 1.85826 3.75001 3.04159 4.60001L6.29159 6.92501C6.83325 7.30001 7.44992 7.10834 7.68325 6.50001L9.14992 2.59167C9.61659 1.34167 10.3916 1.34167 10.8583 2.59167L12.3249 6.50001C12.5583 7.10834 13.1749 7.30001 13.7083 6.92501L16.7583 4.75001C18.0583 3.81667 18.6833 4.29168 18.1499 5.80001L14.7833 15.225C14.6583 15.5417 14.2666 15.8167 13.9166 15.8167Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M5.41675 18.3333H14.5834" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M7.91675 11.6667H12.0834" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ 'Upgrade to Pro' }}
                  </button>
                </a>
              </div>
            </el-card>
          </el-col>
        </el-row>
        <el-skeleton :rows="10" animated v-else style="background-color: #ffffff; padding: 20px"/>
      </div>

      <div class="setup_next_process" v-if="isOnboarded === 'no'">
        <div class="setup-number">
          <span class="setup-count">0{{ active }}</span>
          <span>/03</span>
        </div>
        <div class="wscm_button_group">
          <el-button class="capsule-button" round @click="backBtnHandler">Back</el-button>
          <el-button class="wscm-primary-btn" round @click="saveTemplatesHandlerByApi" v-if="downloadableTemplates">Install Templates</el-button>
          <el-button class="wscm-primary-btn" round @click="nextBtnHandler" v-else>Next</el-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UpgradePopup from '../Components/UpgradePopup.vue';
export default {
  name: "step-2",
  components: {
    UpgradePopup
  },
  props: ['active'],
  data() {
    return {
      action: false,
      fetching: false,
      checkTemplates: false,
      loading: false,
      templates: [],
      activeTemplate: '',
      isOnboarded: window.SwiftCertificateManagerAdminVars.is_onboarded,
      uploadCertificateUrl: window.SwiftCertificateManagerAdminVars.upload_certificate_url,
      downloadableTemplates: parseInt(window.SwiftCertificateManagerAdminVars.downloadableTemplates),
      coreTemplates: window.SwiftCertificateManagerAdminVars.coreTemplates,
      hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro,
      upgradePopupVisible: false
    };
  },
  methods: {
    upgradePopupHandler() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
      } else {
        window.open('https://swiftcertificate.com/order-certificate', '_blank');
      }
    },
    hasProHandler(template) {
      return template.pro == 1 && !this.hasPro;
    },
   
    nextBtnHandler() {
      if (this.active < 3) {
        this.$emit('updateActive', this.active + 1);
      }
    },
    backBtnHandler() {
      if (this.active > 0) {
        this.$emit('updateActive', this.active - 1);
      }
    },
    gotoCustomizations(id) {
      this.$router.push({
        name: 'template_customizations',
        params: {
          template_id: id
        }
      })
    },
    getActivatedTemplate() {
      this.fetching = true;
      this.$get({
        action: 'swift_certificate_manager_template_admin_ajax',
        route: 'get_active_template',
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            this.activeTemplate = response.data.active_template
          })
          .fail(error => {
            this.$handleError(error);
          })
          .always(() => {
            this.fetching = false;
          });
    },
    saveActivatedTemplate(slug) {
      this.action = true;
      this.$post({
        action: 'swift_certificate_manager_template_admin_ajax',
        route: 'save_active_template',
        slug: slug,
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            this.getActivatedTemplate();
            this.$handleSuccess(response.data.message);
          })
          .fail(error => {
            this.$handleError(error);
          })
          .always(() => {
            this.action = false;
          });
    },
    saveTemplatesHandlerByApi() {
      // Show loading spinner
      this.loading = true;
      // Create a fullscreen loading instance
      const loadingInstance = this.$loading({
        fullscreen: true,
        text: 'Installing templates, do not refresh the page, please wait...',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)',
        customClass: 'wscm-text-loading'
      });

      this.$post({
        action: 'swift_certificate_manager_template_admin_ajax',
        route: 'save_templates_by_api',
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            if(response.data.downloaded_files && response.data.downloaded_files.length) {
              // Continue downloading
              this.saveTemplatesHandlerByApi();
            } else {
              // All Done
              loadingInstance.close();
              this.loading = false;

              this.$handleSuccess(response.data.message);

              setTimeout(() => {
                window.location.reload();
              }, 1000);
            }
          })
          .fail(error => {
            loadingInstance.close();
            this.loading = false;
            this.$handleError(error);
          });
    },
    getTemplatesHandler() {
      this.fetching = true;
      this.$get({
        action: 'swift_certificate_manager_template_admin_ajax',
        route: 'get_templates',
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            this.templates = response.data.templates
          })
          .fail(error => {
            this.$handleError(error);
          })
          .always(() => {
            this.fetching = false;
          });
    }
  },
  mounted() {
    this.getActivatedTemplate();
    this.getTemplatesHandler();
  }
};
</script>