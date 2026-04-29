<template>
    <div class="wscm_main_container" v-loading="fetching">
        <div class="wscm_wrapper swift_certificate_manager_payment_settings" v-loading="saving">
          <h3 class="wscm_title">
              Stripe Gateway Settings:
          </h3>
          <div class="payment_item">
              <label class="label">Status</label>
              <el-checkbox class="wscm_checkbox" true-label="yes" false-label="no" label="Enable stripe payment method." v-model="settings.enable"></el-checkbox>
          </div>

          <div class="payment_item" v-if="settings.enable === 'yes'">
            <label class="label">Stripe Payment Mode</label>
            <el-radio-group v-model="settings.payment_mode" class="wscm-payment-mode-select">
              <el-radio label="test">Test Mode</el-radio>
              <el-radio label="live">Live Mode</el-radio>
            </el-radio-group>
          </div>

          <div class="wscm_section_body" v-if="settings.enable === 'yes'">
                <el-form :label-position="labelPosition" rel="stripe_settings" :model="settings">
                    <div v-if="settings.payment_mode !== 'live'" class="wscm_settings_section">
                        <h3>Stripe Test Keys</h3>
                      <div class="settings-item">
                        <div class="setting-form">
                          <h4 class="label">Test Publishable key</h4>
                          <el-input type="text" size="small" v-model="settings.test_public_key" placeholder="Test Publishable key"/>
                        </div>
                        <div class="setting-form">
                          <h4 class="label">Test Secret key</h4>
                          <el-input type="text" size="small" v-model="settings.test_secret_key" placeholder="Test Secret key"/>
                        </div>
                      </div>
                    </div>
                    <div v-else class="wscm_settings_section">
                        <h3>Stripe Live Keys</h3>
                        <div class="settings-item">
                          <div class="setting-form">
                            <h4 class="label">Live Publishable key</h4>
                            <el-input type="text" size="small" v-model="settings.live_public_key" placeholder="Live Publishable key"/>
                          </div>
                          <div class="setting-form">
                            <h4 class="label">Live Secret key</h4>
                            <el-input type="text" size="small" v-model="settings.live_secret_key" placeholder="Live Secret key"/>
                          </div>
                        </div>
                    </div>

<!--                    <div class="wscm_settings_section">-->
<!--                        <p>In order for Stripe to function completely for subscription/recurring payments, you must configure your Stripe webhooks. Visit-->
<!--                            your <a href="https://dashboard.stripe.com/account/webhooks" target="_blank" rel="noopener">account-->
<!--                                dashboard</a> to configure them. Please add a webhook endpoint for the URL below.</p>-->
<!--                        <p><b>Webhook URL: </b><code>{{webhook_url}}</code></p>-->
<!--                    </div>-->

                </el-form>
            </div>

          <div class="wscm_action_btn">
              <el-button class="wscm-primary-btn svg-span-btn" @click="saveSettings">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.0001 18.3333C14.5834 18.3333 18.3334 14.5833 18.3334 9.99999C18.3334 5.41666 14.5834 1.66666 10.0001 1.66666C5.41675 1.66666 1.66675 5.41666 1.66675 9.99999C1.66675 14.5833 5.41675 18.3333 10.0001 18.3333Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M6.45825 10L8.81659 12.3583L13.5416 7.64166" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Save Stripe Settings
              </el-button>
            </div>
        </div>
        <UpgradePopup 
            :upgradePopupVisible="upgradePopupVisible"
            @close="upgradePopupVisible = false"
        />
    </div>
</template>
<script>
import UpgradePopup from '../Modules/Components/UpgradePopup.vue';

export default {
  name: 'stripe_settings',
  components: {
    UpgradePopup
  },
  data() {
    return {
      settings: {
        payment_mode: 'live'
      },
      saving: false,
      fetching: false,
      labelPosition: 'right',
      webhook_url: '',
      upgradePopupVisible: false,
      hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro
    }
  },
  methods: {
    getSettings() {
        this.fetching = true;
        this.$get({
            action: 'swift_certificate_manager_payment_settings_admin_ajax',
            route: 'get_payment_settings',
            method: 'stripe',
            nonce: window.SwiftCertificateManagerAdminVars.nonce
        })
            .then((response) => {
                this.settings = response.data.settings;
                this.webhook_url = response.data.webhook_url
            })
            .fail(error => {
                this.$message.error(error?.responseJSON?.data?.message);
            })
            .always(() => {
                this.fetching = false;
            });
    },
    saveSettings() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      }
        this.saving = true;
        this.$post({
            action: 'swift_certificate_manager_payment_settings_admin_ajax',
            settings: this.settings,
            method: 'stripe',
            route: 'save_payment_settings',
            nonce: window.SwiftCertificateManagerAdminVars.nonce
        })
            .then(response => {
              if (response.success) {
                this.$handleSuccess(response.data.message);
              } else {
                this.$handleError(response.data.message);
              }
            })
            .fail(error => {
                this.$handleError(error?.responseJSON?.data?.message);
            })
            .always(() => {
                this.saving = false;
            });
    }
  },
  mounted() {
    if (this.hasPro) {
      this.getSettings();
    }  
  }
}
</script>

<style lang="scss">
//    .swift_certificate_manager_settings_wrap {
//         max-width: 800px;
//         margin: 0 auto;
//         padding:23px 12px;
//    }

   .payment-inactive {
        opacity: 0.7;
   }
  .payment_item {
    display: flex;
    align-items: center;
    width: 50%;
    margin-bottom: 20px;
    .label {
      width: 80%;
    }
  }

  .wscm-payment-mode-select {
    width: 100%;
    label {
      border: solid #ddd;
      padding: 8px 15px;
      border-radius: 20px;
      margin-right: 5px;
      &.is-checked {
        border: solid #20104E;
        .el-radio__inner {
          border-color: #20104E;
          background: #20104E;
        }
        .el-radio__label {
          color: #20104E;
        }
      }
    }
  }
  .wscm_section_body {
    border: solid #ddd;
    border-radius: 10px;
    padding: 10px;
  }
</style>
