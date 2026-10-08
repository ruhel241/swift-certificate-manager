<template>
  <div class="swifcema-finishing-setup">
    <div class="cong_wrap" v-loading="action">
      <div class="title-box">
        <h1 class="title">Congratulations! you are ready to generate certificate</h1>
      </div>
      <div class="cong_img_box">
        <img :src="imageUrl+'/frame.webp'" alt="">
      </div>
      <div class="setup_next_process">
        <div class="setup-number">
          <span class="setup-count">0{{active}}</span>
          <span>/03</span>
        </div>
        <div class="swifcema_button_group">
          <el-button class="capsule-button" round @click="backBtnHandler">Back</el-button>
          <button class="el-button swifcema-primary-btn el-button--default" @click="finishHandler">Finish Setup</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { templates } from '../Pieces/data';
export default {
  name: "step-4",
  props: ['active'],
  data() {
    return {
      saving: false,
      action: false,
      imageUrl: window.swifcemaAdminVars.images_url,
      isOnboarded: 'yes',
    };
  },
  methods: {
    finishHandler() {
      this.action = true;
      // this.$emit('saveOnBoardingHandler');
      this.saveOnBoarded();
      setTimeout(() => {
        this.action = false;
        localStorage.removeItem('swifcema_step_active');
        localStorage.removeItem('swifcema_onboarding_info');
        location.reload();
      }, 1000);
    },

    saveOnBoarded() {
      this.saving = true;
      this.$post({
        action: "swifcema_onboarding_info_ajax",
        route: "save_onboarded",
        is_onboarded: this.isOnboarded,
        nonce: window.swifcemaAdminVars.nonce,
      })
          .then((response) => {
            // console.log(response.data.message);
            // this.$handleSuccess(response.data.message);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            this.saving = false;
          });
    },

    backBtnHandler() {
      if (this.active > 0) {
        this.$emit('updateActive', this.active - 1);
      }
    },
  }
}
</script>
