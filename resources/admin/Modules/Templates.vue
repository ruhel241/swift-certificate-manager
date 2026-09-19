<template>
  <div class="swifcema-templates">
    <div class="title header">
      <h1>Templates</h1>
      <!-- {{ templates }} -->
      <div class="btn-handler">
        <!-- <el-button icon="el-icon-refresh" round @click="saveTemplatesHandler" v-if="downloadableTemplates">
          Fetch Templates
        </el-button> -->
        <el-button class="capsule-btn" icon="el-icon-service" round>
          Order Customized Certificates
        </el-button>
        <!-- <UpgradePopup 
          :upgradePopupVisible="upgradePopupVisible"
          @close="upgradePopupVisible = false"
        /> -->
      </div>
    </div>

    <div class="templates-wrap">
      <div class="templates">
        <el-row :gutter="20">
          <el-col :span="6" class="mb20 pro-template" v-for="(template, index) in templates" :key="index">
            <el-card class="box-card" :body-style="{ padding: '0px' }">
              <div class="template-image">
                <img :src="uploadCertificateUrl+template.template_image" class="image"/>
              </div>
              <div class="title" style="padding: 0px 10px; text-align: center;">
                <p>{{ template.template_name }}</p>
              </div>
              <div class="card-actions">
                <a class="el-button capsule-btn el-button--default is-round" :href="uploadCertificateUrl+template.template_image" download>Download Template</a>
                <!-- <el-button
                    class="capsule-btn"
                    round
                    style="width: 100%"
                >
                  Download Template
                </el-button> -->
                <el-button
                    class="capsule-btn"
                    round
                    @click="gotoCustomizations(template.id)"
                    icon="el-icon-view"
                >
                  View
                </el-button>
              </div>
            </el-card>
          </el-col>
        </el-row>
        <!-- <el-skeleton :rows="10" animated v-else style="background-color: #ffffff; padding: 20px"/> -->
      </div>
    </div>
  </div>
</template>

<script>
// import UpgradePopup from '../Components/UpgradePopup.vue';
export default {
  name: "templates",
  // components: {
  //   UpgradePopup
  // },
  // props: ['active'],
  data() {
    return {
      // action: false,
      // fetching: false,
      // checkTemplates: false,
      // loading: false,
      templates: [
          {
            "template_name": "1) Falcon - 1 signature | 1 logo",
            "template_image": "template-1.png",
            "slug": "template-1",
            "pro": 0
          },
          {
            "template_name": "2) Falcon - 1 signature | No logo",
            "template_image": "template-2.png",
            "slug": "template-2",
            "pro": 0
          },
          {
            "template_name": "3) Falcon - 2 signature | No logo",
            "template_image": "template-3.png",
            "slug": "template-3",
            "pro": 0
          },
          {
            "template_name": "4) Merlin - 1 signature | 1 logo",
            "template_image": "template-4.png",
            "slug": "template-4",
            "pro": 1
          },
          {
            "template_name": "5) Merlin - 2 signature | 1 logo",
            "template_image": "template-5.png",
            "slug": "template-5",
            "pro": 1
          },
          {
            "template_name": "6) Merlin - 2 signature | No logo",
            "template_image": "template-6.png",
            "slug": "template-6",
            "pro": 1
          },
          {
            "template_name": "7) Phoenix - 1 signature | 2 logo",
            "template_image": "template-7.png",
            "slug": "template-7",
            "pro": 1
          },
          {
            "template_name": "8) Phoenix - 2 signature | 1 logo",
            "template_image": "template-8.png",
            "slug": "template-8",
            "pro": 1
          },
          {
            "template_name": "9) Phoenix - 2 signature | 2 logo",
            "template_image": "template-9.png",
            "slug": "template-9",
            "pro": 1
          },
          {
            "template_name": "10) Skylark - 2 signature | 1 logo",
            "template_image": "template-10.png",
            "slug": "template-10",
            "pro": 1
          },
          {
            "template_name": "11) Skylark - 2 signature | No logo",
            "template_image": "template-11.png",
            "slug": "template-11",
            "pro": 1
          },
          {
            "template_name": "12) Hawk - 1 signature | 2 logo",
            "template_image": "template-12.png",
            "slug": "template-12",
            "pro": 1
          },
          {
            "template_name": "13) Hawk - 2 signature | No logo",
            "template_image": "template-13.png",
            "slug": "template-13",
            "pro": 1
          }
      ],
      // activeTemplate: '',
      // isOnboarded: window.swifcemaAdminVars.is_onboarded,
      uploadCertificateUrl: window.swifcemaAdminVars.upload_certificate_url,
      // downloadableTemplates: 1,
      // coreTemplates: window.swifcemaAdminVars.coreTemplates,
      // hasPro: !!window.swifcemaAdminVars.has_pro,
      // upgradePopupVisible: false
    };
  },
  methods: {
    // upgradePopupHandler() {
    //   if (!this.hasPro) {
    //     this.upgradePopupVisible = true;
    //   } else {
    //     window.open('https://swiftcertificate.com/order-certificate', '_blank');
    //   }
    // },
    // hasProHandler(template) {
    //   return template.pro == 1 && !this.hasPro;
    // },
   
    // nextBtnHandler() {
    //   if (this.active < 3) {
    //     this.$emit('updateActive', this.active + 1);
    //   }
    // },
    // backBtnHandler() {
    //   if (this.active > 0) {
    //     this.$emit('updateActive', this.active - 1);
    //   }
    // },
    // gotoCustomizations(id) {
    //   this.$router.push({
    //     name: 'template_customizations',
    //     params: {
    //       template_id: id
    //     }
    //   })
    // },
    // getActivatedTemplate() {
    //   this.fetching = true;
    //   this.$get({
    //     action: 'swifcema_template_admin_ajax',
    //     route: 'get_active_template',
    //     nonce: window.swifcemaAdminVars.nonce
    //   })
    //       .then(response => {
            // this.activeTemplate = response.data.active_template
    //       })
    //       .fail(error => {
    //         this.$handleError(error);
    //       })
    //       .always(() => {
    //         this.fetching = false;
    //       });
    // },
    // saveActivatedTemplate(slug) {
    //   this.action = true;
    //   this.$post({
    //     action: 'swifcema_template_admin_ajax',
    //     route: 'save_active_template',
    //     slug: slug,
    //     nonce: window.swifcemaAdminVars.nonce
    //   })
    //       .then(response => {
    //         this.getActivatedTemplate();
    //         this.$handleSuccess(response.data.message);
    //       })
    //       .fail(error => {
    //         this.$handleError(error);
    //       })
    //       .always(() => {
    //         this.action = false;
    //       });
    // },
    // saveTemplatesHandler() {
    //   // Loader only first time
    //   this.loading = true;
    //   const loadingInstance = this.$loading({
    //       fullscreen: true,
    //       text: 'Installing templates, do not refresh the page, please wait...',
    //       spinner: 'el-icon-loading',
    //       background: 'rgba(0, 0, 0, 0.7)',
    //       customClass: 'swifcema-text-loading'
    //   });
      
    //   this.$post({
    //       action: 'swifcema_template_admin_ajax',
    //       route: 'save_templates',
    //       nonce: window.swifcemaAdminVars.nonce
    //   })
    //   .then(response => {
    //     setTimeout(() => {
    //       loadingInstance.close();
    //       this.loading = false;
    //       this.$handleSuccess(response.data.message);
    //       window.location.reload();
    //     }, 5000);
    //   })
    //   .fail(error => {
    //       loadingInstanceg.close();
    //       this.loading = false;
    //       this.$handleError(error);
    //   });
    // },

    // getTemplatesHandler() {
    //   this.fetching = true;
    //   this.$get({
    //     action: 'swifcema_template_admin_ajax',
    //     route: 'get_templates',
    //     nonce: window.swifcemaAdminVars.nonce
    //   })
    //       .then(response => {
    //         this.templates = response.data.templates
    //       })
    //       .fail(error => {
    //         this.$handleError(error);
    //       })
    //       .always(() => {
    //         this.fetching = false;
    //       });
    // }
  },
  mounted() {
    // this.getActivatedTemplate();
    // this.getTemplatesHandler();
  }
};
</script>