<template>
  <div class="wpsc-fonts-manager">
    <div class="title header" v-if="isOnboarded === 'no'">
      <h1>Fonts Manager</h1>
    </div>

    <div class="fonts-wrap">
      <div class="wscm_fonts_downloader_wrapper">
        <div class="wscm_fonts_installation" v-if="downloadableFiles">
          <h3>Fonts are required for Certificate Generate</h3>
          <p>
            This module requires downloading Fonts for Certificate Generate.
            Please click on the button below to download the required Fonts files.
            This is a one-time job.
          </p>

          <div class="settings-font-manager" v-if="isOnboarded === 'yes'">
            <el-button
                class="wscm-pro-btn"
                round
                @click="downloadFonts"
                :loading="loading"
                :disabled="loading"
            >
              {{ loading ? 'Installing...' : 'Install Fonts' }}
            </el-button>
          </div>
        </div>

        <div class="wscm_fonts_install_preview" v-else>
          <div class="wscm_pdf_system_status">
            <h3 class="mb-3">
              Swift Certificate Manager Fonts is now active
              <span style="color: red;" v-if="!getSystemStatuses.status">
                But a few server extensions are missing
              </span>
            </h3>
            <ul>
              <li v-for="(extension, key) in getSystemStatuses.extensions" :key="key">
                <span v-if="extension.status" class="dashicons dashicons-yes"></span>
                <span v-else class="dashicons dashicons-no-alt"></span>
                {{ extension.label }}
              </li>
            </ul>
            <p v-if="getSystemStatuses.status">
              All looks good! You can now create a new certificate.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="setup_next_process" v-if="isOnboarded === 'no' && !loading">
      <div class="setup-number">
        <span class="setup-count">0{{ active }}</span>
        <span>/04</span>
      </div>
      <div class="wscm_button_group">
        <el-button class="capsule-button" round @click="backBtnHandler">Back</el-button>
        <el-button
            class="wscm-primary-btn"
            round
            @click="downloadFonts"
            v-if="downloadableFiles"
            :loading="loading"
            :disabled="loading"
        >
          {{ loading ? 'Installing...' : 'Install Fonts' }}
        </el-button>
        <el-button class="wscm-primary-btn" round @click="nextBtnHandler" v-else>Next</el-button>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "step-3",
  props: ['active'],
  data() {
    return {
      action: false,
      fetching: false,
      loading: false,
      checkTemplates: false,
      templates: [],
      activeTemplate: '',
      isOnboarded: window.SwiftCertificateManagerAdminVars.is_onboarded,
      uploadCertificateUrl: window.SwiftCertificateManagerAdminVars.upload_certificate_url,
      downloadableFiles: parseInt(window.SwiftCertificateManagerAdminVars.downloadableFiles),
      getSystemStatuses: window.SwiftCertificateManagerAdminVars.getSystemStatuses,
    };
  },
  methods: {
    nextBtnHandler() {
      if (this.active < 4) {
        this.$emit('updateActive', this.active + 1);
      }
    },
    backBtnHandler() {
      if (this.active > 0) {
        this.$emit('updateActive', this.active - 1);
      }
    },

    downloadFonts() {
      // Show loading state
      this.loading = true;
      this.action = true;

      // Create a fullscreen loading instance
      const loadingInstance = this.$loading({
        fullscreen: true,
        text: 'Installing fonts, do not refresh the page, please wait...',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)',
        customClass: 'wscm-text-loading'
      });

      this.$post({
        action: 'swift_certificate_manager_fonts_admin_ajax',
        route: 'download_fonts',
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            if(response.data.downloaded_files && response.data.downloaded_files.length) {
              // Continue downloading
              this.downloadFonts();
            } else {
              // All Done
              loadingInstance.close();
              this.loading = false;
              this.action = false;

              this.$notify({
                title: 'Success',
                message: 'Fonts installed successfully!',
                type: 'success',
                duration: 2000
              });

              setTimeout(() => {
                window.location.reload();
              }, 1000);
            }
          })
          .fail(error => {
            loadingInstance.close();
            this.loading = false;
            this.action = false;
            this.$handleError(error);
          });
    },
  },
  mounted() {
  }
};
</script>

<style lang="scss">

.wscm_fonts_downloader_wrapper {
  background-color: #fff;
  border-radius: 5px;
  margin: 0px auto;
  margin-bottom: 80px;
  //padding: 100px;
  .wscm_fonts_installation {
    width: 60%;
    display: flex;
    flex-direction: column;
    text-align: center;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    padding: 100px 0 100px 0;
    h3 {
      font-size: 23px;
      margin-top: 0;
    }
    p {
      line-height: 24px;
    }
  }
}

.wscm_fonts_install_preview {
  width: 100%;
  padding: 30px;
}

.el-button--success {
  color: #fff;
}
.setup_next_process {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: solid 1px #DDDDDD;
  border-radius: 30px;
  padding: 5px;
  width: 30%;
  margin: 40px auto;
  background: #fff;
  .setup-number {
    margin-left: 4px;
  }
}

.settings-font-manager {
  margin-top: 50px;
}

.wscm_pdf_system_status {
  .dashicons-yes {
    color: #0def0d;
  }
  .dashicons-no-alt {
    color: red;
  }
}

</style>