<template>
    <div class="swiftcm_main_container" v-loading="fetching">
      <div class="swiftcm_wrapper swiftcm_payment_settings" v-loading="saving">
        <h3 class="swiftcm_title">
          Paypal Gateway Settings:
        </h3>
        <div class="payment_item">
          <label class="label">Status</label>
          <el-checkbox class="swiftcm_checkbox" true-label="yes" false-label="no" label="Enable paypal payment method." v-model="settings.enable"></el-checkbox>
        </div>

        <div class="payment_item" v-if="settings.enable === 'yes'">
          <label class="label">Paypal Payment Mode</label>
          <el-radio-group v-model="settings.payment_mode" class="swiftcm-payment-mode-select">
            <el-radio label="test">Sandbox Mode</el-radio>
            <el-radio label="live">Live Mode</el-radio>
          </el-radio-group>
        </div>

        <div class="swiftcm_section_body" v-if="settings.enable === 'yes'">
          <el-form :label-position="labelPosition" rel="paypal_settings" label-width="220px">
            <div v-if="settings.payment_mode !== 'live'" class="swiftcm_settings_section">
                <h3>Paypal Test Keys</h3>
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
            <div v-else class="swiftcm_settings_section">
              <h3>Paypal Live Keys</h3>
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
            <!-- <el-tabs v-model="settings.payment_type">
              <el-tab-pane label="PayPal Pro" name="pro">
                <div v-if="settings.payment_mode !== 'live'" class="swiftcm_settings_section">
                  <h3>Paypal Test Keys</h3>
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
                <div v-else class="swiftcm_settings_section">
                  <h3>Paypal Live Keys</h3>
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
              </el-tab-pane>
              <el-tab-pane label="PayPal Standard" name="standard">
                <div class="swiftcm_settings_section">
                  <h3>PayPal Standard</h3>
                  <div class="settings-item">
                    <div class="setting-form">
                      <h4 class="label">Paypal Email</h4>
                      <el-input type="text" size="small" v-model="settings.paypal_email" placeholder="Paypal Email Address"/>
                    </div>
                    <div class="setting-form">
                      <h4 class="label" style="width: 45%">Disable PayPal IPN Verification</h4>
                      <el-switch active-value="yes" inactive-value="no" v-model="settings.disable_ipn_verification"/>
                    </div>
                    <div class="setting-form">
                      <p>If you are unable to use Payment Data Transfer and payments are not getting marked as
                        complete, then check this box. This forces the site to use a slightly less secure method of
                        verifying purchases.</p>
                    </div>
                  </div>
                </div>
              </el-tab-pane>
            </el-tabs> -->

            <!-- <div class="swiftcm_settings_section">
              <p>Please use IPN url to get marked paid on you site.</p>
              <b>IPN URL: </b>
              <el-tooltip effect="dark"
                          content="Click to copy"
                          title="Click to copy"
                          placement="top">
                <code class="copy"
                      data-clipboard-action="copy"
                      :data-clipboard-text='webhook_url'>
                  <i class="el-icon-document"></i> {{webhook_url}}
                </code>
              </el-tooltip>
            </div> -->
          </el-form>
        </div>

        <div class="swiftcm_action_btn">
          <el-button class="swiftcm-primary-btn svg-span-btn" @click="saveSettings()">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.0001 18.3333C14.5834 18.3333 18.3334 14.5833 18.3334 9.99999C18.3334 5.41666 14.5834 1.66666 10.0001 1.66666C5.41675 1.66666 1.66675 5.41666 1.66675 9.99999C1.66675 14.5833 5.41675 18.3333 10.0001 18.3333Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M6.45825 10L8.81659 12.3583L13.5416 7.64166" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Save Paypal Settings
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
  name: 'paypal_settings',
  components: {
    UpgradePopup
  },
  data() {
      return {
          settings: {
            payment_type: 'pro', //standard
          },
          saving: false,
          fetching: false,
          labelPosition: 'right',
          webhook_url: '',
          upgradePopupVisible: false,
          hasPro: !!window.swiftcmAdminVars.has_pro
      }
  },
  methods: {
      getSettings() {
          this.fetching = true;
          this.$get({
              action: 'swiftcm_payment_settings_admin_ajax',
              route: 'get_payment_settings',
              method: 'paypal',
              nonce: window.swiftcmAdminVars.nonce
          })
              .then((response) => {
                  this.settings = response.data.settings;
                  this.webhook_url = response.data.webhook_url;
              })
              .fail(error => {
                  this.$message.error(error.responseJSON.data.message);
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
              action: 'swiftcm_payment_settings_admin_ajax',
              route: 'save_payment_settings',
              method: 'paypal',
              settings: this.settings,
              nonce: window.swiftcmAdminVars.nonce
          })
              .then(response => {
                  this.$handleSuccess(response?.data?.message);
              })
              .fail(error => {
                  this.$message.error(error?.responseJSON?.data?.message);
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
.swiftcm_payment_settings {
  .el-tabs__item.is-top.is-active {
    border-bottom: solid;
  }
}
</style>