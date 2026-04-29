<template>
  <div class="wpsc-settings-wrap">
      <div class="header">
        <div class="setting_header">
          <!-- {{ settings }} -->
          <h1>Settings</h1>
          <p>Manage your settings and payment method here </p>
          <el-radio-group v-model="settingTabMenu" @change="settingTabChangeHandler" style="margin-bottom: 30px;">
            <el-radio-button label="general">General</el-radio-button>
            <el-radio-button label="payment_methods">Payment Methods</el-radio-button>
            <el-radio-button label="payment_transaction">Payment Transaction</el-radio-button>
            <el-radio-button label="license_management" v-if="hasProVersion">License Management</el-radio-button>
          </el-radio-group>
        </div>
      </div>

      <div class="wpsc-card" v-if="settingTabMenu === 'general'" v-loading="fetching">
        <div class="settings-item">
          <div class="header-title">
            <h3 class="title">General Information</h3>
          </div>
          <div class="setting-form">
            <h4 class="label">Select Your Preferences</h4>
            <el-select v-model="settings.preference" placeholder="Select">
              <el-option
                  v-for="item in preferences"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
              </el-option>
            </el-select>
          </div>

          <div class="setting-form">
            <h4 class="label">
              {{ settings.preference.charAt(0).toUpperCase() + settings.preference.slice(1) }}
              Name</h4>
            <el-input
                type="text"
                v-model="settings[settings.preference + '_name']"
                :placeholder="'Enter ' + settings.preference + ' name'">
            </el-input>
          </div>

          <div class="setting-form">
            <h4 class="label">
              {{ settings.preference.charAt(0).toUpperCase() + settings.preference.slice(1) }} Signature
            </h4>
            <el-input
                type="text"
                v-model="settings[settings.preference + '_signature']"
                :placeholder="'Enter ' + settings.preference + ' signature'">
            </el-input>
          </div>

          <div class="setting-form" style="display: flex; justify-content: center; align-items: center">
            <h4 class="label">
              {{ settings.preference.charAt(0).toUpperCase() + settings.preference.slice(1) }} Signature Image
            </h4>
            <PhotoUploader v-model="settings[settings.preference + '_signature_img']"/>
          </div>

          <div class="setting-form">
            <h4 class="label">
             {{ settings.preference.charAt(0).toUpperCase() + settings.preference.slice(1) }} Signature Image Enable
            </h4>
            <el-checkbox 
              v-model="settings[settings.preference + '_signature_img_enable']"
              true-label="yes"
              false-label="no">
              Enable Signature Image
            </el-checkbox>
          </div>
        </div>

        <div class="settings-item">
          <h3 class="title">Currency Setting</h3>
          <div class="setting-form">
            <h4 class="label">Default Currency</h4>
            <el-select v-model="settings.currency" filterable placeholder="Select Currency">
              <el-option
                  v-for="(currency, key) in currencies"
                  :key="key"
                  :label="currency"
                  :value="key">
              </el-option>
            </el-select>
          </div>
          <div class="setting-form">
            <h4 class="label">Certificate Price</h4>
            <el-input type="text" v-model="settings.certificate_payment" placeholder="Enter amount ex: 10"></el-input>
          </div>
        </div>

        <div class="settings-item">
          <h3 class="title">Certificate Information</h3>
          <div class="setting-form">
             <h4 class="label">Order Certificate URL</h4>
             <div class="setting-copy-field">
               <el-input type="text" placeholder="Enter student name" v-model="settings.order_certificate_url" disabled></el-input>
               <el-tooltip effect="dark"
                           content="Click To Copy"
                           title="Click To Copy"
                           placement="top">
                 <code class="copy short-link-copy"
                       :data-clipboard-text='getCopyUrlLink(settings.order_certificate_url)'>
                   <i class="el-icon-document-copy"></i>
                 </code>
               </el-tooltip>
             </div>
          </div>

          <div class="setting-form">
            <h4 class="label">Verify Certificate URL</h4>
            <div class="setting-copy-field">
              <el-input type="text" placeholder="verify url" v-model="settings.verify_certificate_url" disabled></el-input>
              <el-tooltip effect="dark"
                          content="Click To Copy"
                          title="Click To Copy"
                          placement="top">
                <code class="copy short-link-copy"
                      :data-clipboard-text='getCopyUrlLink(settings.verify_certificate_url)'>
                  <i class="el-icon-document-copy"></i>
                </code>
              </el-tooltip>
            </div>
          </div>

          <div class="setting-form">
            <h4 class="label">Order Certificate Shortcode</h4>
            <div class="setting-copy-field">
              <el-input type="text" placeholder="Enter order url" v-model="settings.order_certificate_shortcode" disabled></el-input>
              <el-tooltip effect="dark"
                          content="Click To Copy"
                          title="Click To Copy"
                          placement="top">
                <code class="copy short-link-copy"
                      :data-clipboard-text='getCopyUrlLink(settings.order_certificate_shortcode)'>
                  <i class="el-icon-document-copy"></i>
                </code>
              </el-tooltip>
            </div>
          </div>

          <div class="setting-form">
            <h4 class="label">Verify Certificate Shortcode</h4>
            <div class="setting-copy-field">
              <el-input type="text"  v-model="settings.verify_certificate_shortcode" disabled></el-input>
              <el-tooltip effect="dark"
                          content="Click To Copy"
                          title="Click To Copy"
                          placement="top">
                <code class="copy short-link-copy"
                      :data-clipboard-text='getCopyUrlLink(settings.verify_certificate_shortcode)'>
                  <i class="el-icon-document-copy"></i>
                </code>
              </el-tooltip>
            </div>
          </div>

          <div class="setting-form">
            <h4 class="label">Certificate Code Prefix</h4>
            <el-input type="text" placeholder="Enter certificate code prefix" v-model="settings.certificate_code_prefix"></el-input>
          </div>
          <div class="setting-form">
            <h4 class="label">Clear Cache</h4>
            <el-checkbox v-model="settings.clear_cache" class="wscm_checkbox" true-label="yes" false-label="no" label="Clearing for whole cache"></el-checkbox>
          </div>
        </div>

        <div class="settings-item">
          <h3 class="title">Certificate Reviews</h3>
          <div class="setting-form">
            <h4 class="label">Share Swift Certificate Manager Plugin</h4>
            <div class="wscm-socia-icon">
              <a class="wscm-twitter" href="#">
                <svg viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2252 0.300602C13.0771 -0.0334262 14.0083 -0.0906208 14.8928 0.136754C15.6361 0.327823 16.3164 0.712098 16.8697 1.24937C17.0788 1.16822 17.2359 1.08636 17.4384 0.972246C17.5028 0.935949 17.572 0.8962 17.6484 0.852366C17.9575 0.674859 18.3833 0.430358 19.0785 0.0768431C19.3248 -0.0483658 19.6214 0.00234362 19.8149 0.202732C20.0083 0.40312 20.0553 0.708222 19.9314 0.960163C19.8348 1.15674 19.7335 1.39078 19.6151 1.66415L19.6109 1.67379C19.4933 1.94535 19.3619 2.24839 19.215 2.55388C18.9698 3.06388 18.6651 3.6169 18.2687 4.08832C18.2876 4.25704 18.2973 4.42679 18.2979 4.5968L18.2979 4.59897C18.2979 9.85576 15.8382 13.6919 12.3212 15.615C8.81976 17.5296 4.33465 17.5134 0.328377 15.2269C0.0699886 15.0794 -0.0560402 14.7689 0.0237777 14.4766C0.103596 14.1842 0.368377 13.9863 0.66373 13.9984C2.26733 14.0639 3.85328 13.7004 5.26936 12.9526C3.83753 12.1165 2.83617 11.1008 2.16028 10.0045C1.33017 8.65796 1.0152 7.22929 0.958167 5.94022C0.901258 4.65402 1.10021 3.49332 1.31029 2.65882C1.41571 2.24004 1.52499 1.89928 1.6089 1.66084C1.65089 1.54152 1.68663 1.44752 1.71253 1.38186C1.72548 1.34903 1.73597 1.32325 1.74356 1.30491L1.75272 1.28301L1.75557 1.27633L1.75654 1.27406L1.75691 1.27321C1.75706 1.27285 1.7572 1.27253 2.34048 1.53885L1.7572 1.27253C1.85059 1.05666 2.04979 0.909076 2.27866 0.886194C2.50752 0.863312 2.73068 0.968667 2.86283 1.16199C3.66218 2.33132 4.73061 3.27941 5.97298 3.92182C7.02979 4.46829 8.18455 4.77914 9.36173 4.837V4.6294C9.35044 3.69434 9.61848 2.77816 10.1298 2.0044C10.6419 1.22938 11.3734 0.634631 12.2252 0.300602ZM2.57248 2.88493C2.56372 2.91838 2.55495 2.95247 2.54621 2.98719C2.35736 3.73739 2.18397 4.76249 2.23344 5.88067C2.28279 6.99597 2.55292 8.19026 3.23877 9.30277C3.92204 10.4111 5.0422 11.4781 6.85502 12.3058C7.06681 12.4025 7.21093 12.6095 7.23155 12.8467C7.25216 13.0838 7.14603 13.3138 6.95427 13.4475C5.80899 14.2462 4.52923 14.8004 3.19048 15.088C6.18543 16.091 9.25034 15.8085 11.7214 14.4573C14.7999 12.774 17.0209 9.39739 17.0213 4.60015C17.0206 4.39753 17.0016 4.19542 16.9645 3.9964C16.9245 3.7814 16.9916 3.56008 17.1433 3.40639C17.4599 3.08565 17.7301 2.65138 17.976 2.16473C17.6431 2.349 17.3634 2.47854 16.8734 2.63013C16.633 2.7045 16.3725 2.62718 16.2077 2.43256C15.781 1.92846 15.2138 1.57117 14.583 1.40901C13.9521 1.24685 13.288 1.28764 12.6805 1.52587C12.0729 1.76409 11.5512 2.18826 11.186 2.741C10.8207 3.29375 10.6295 3.94839 10.6383 4.61641L10.6384 4.6252L10.6383 5.49951C10.6383 5.85505 10.3625 6.14582 10.0166 6.15503C8.41572 6.19768 6.82945 5.83293 5.39903 5.09328C4.32967 4.54032 3.37223 3.79067 2.57248 2.88493Z" fill="#5B2DE0"/>
                </svg>
              </a>
              <a class="wscm-facebook" href="#">
                <svg viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" clip-rule="evenodd" d="M3.37258 1.25331C4.14898 0.450829 5.202 0 6.3 0H8.46C8.75823 0 9 0.249888 9 0.55814V3.53488C9 3.84314 8.75823 4.09302 8.46 4.09302H6.3C6.25226 4.09302 6.20647 4.11262 6.17272 4.14752C6.13896 4.18241 6.12 4.22973 6.12 4.27907V5.95349H8.46C8.62628 5.95349 8.78329 6.03267 8.88563 6.16814C8.98796 6.30361 9.0242 6.48026 8.98387 6.647L8.26387 9.62374C8.20378 9.87221 7.98778 10.0465 7.74 10.0465H6.12V15.4419C6.12 15.7501 5.87823 16 5.58 16H2.7C2.40176 16 2.16 15.7501 2.16 15.4419V10.0465H0.54C0.241766 10.0465 0 9.79662 0 9.48837V6.51163C0 6.20338 0.241766 5.95349 0.54 5.95349H2.16V4.27907C2.16 3.14419 2.59618 2.05579 3.37258 1.25331ZM6.3 1.11628C5.48843 1.11628 4.71011 1.4495 4.13625 2.04264C3.56239 2.63578 3.24 3.44025 3.24 4.27907V6.51163C3.24 6.81988 2.99823 7.06977 2.7 7.06977H1.08V8.93023H2.7C2.99823 8.93023 3.24 9.18012 3.24 9.48837V14.8837H5.04V9.48837C5.04 9.18012 5.28176 8.93023 5.58 8.93023H7.31838L7.76838 7.06977H5.58C5.28176 7.06977 5.04 6.81988 5.04 6.51163V4.27907C5.04 3.93367 5.17275 3.60242 5.40904 3.35819C5.64534 3.11395 5.96582 2.97674 6.3 2.97674H7.92V1.11628H6.3Z" fill="#5B2DE0"/>
                </svg>
              </a>
              <a class="wscm-youtube" href="#">
                <svg viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.8605 7.99993L8.60465 10.0381V5.96172L11.8605 7.99993Z" fill="#5B2DE0"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25447 10.6992C8.46957 10.836 8.73486 10.8369 8.9508 10.7017L12.2066 8.66355C12.424 8.52746 12.5581 8.27421 12.5581 7.99993C12.5581 7.72564 12.424 7.47239 12.2066 7.3363L8.9508 5.2981C8.73486 5.16292 8.46957 5.16389 8.25447 5.30065C8.03937 5.4374 7.90698 5.68926 7.90698 5.96172V10.0381C7.90698 10.3106 8.03937 10.5624 8.25447 10.6992ZM9.30233 8.72106V7.27879L10.4543 7.99993L9.30233 8.72106Z" fill="#5B2DE0"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M6.34092 0.0671471C7.6007 0.0281116 8.89185 0 10 0C11.1081 0 12.3993 0.0281115 13.6591 0.067147L13.7103 0.0687327C14.9929 0.108454 16.0269 0.140476 16.8422 0.288195C17.6912 0.442002 18.3964 0.735501 18.9603 1.37093C19.5256 2.00807 19.7726 2.79605 19.8885 3.73876C20 4.64614 20 5.7952 20 7.22314V8.77686C20 10.2048 20 11.3538 19.8885 12.2612C19.7726 13.2039 19.5256 13.9919 18.9603 14.629C18.3964 15.2644 17.6912 15.5579 16.8423 15.7118C16.0269 15.8595 14.9929 15.8915 13.7103 15.9312L13.6592 15.9328C12.3994 15.9719 11.1082 16 10 16C8.89182 16 7.60063 15.9719 6.34082 15.9328L6.28967 15.9312C5.00706 15.8915 3.97308 15.8595 3.15773 15.7118C2.30879 15.5579 1.60357 15.2644 1.03973 14.629C0.47438 13.9919 0.227445 13.2039 0.111535 12.2612C-3.33301e-05 11.3538 -1.83102e-05 10.2048 4.86016e-07 8.77684V7.22316C-1.83102e-05 5.79521 -3.33405e-05 4.64614 0.111536 3.73876C0.227447 2.79605 0.474385 2.00807 1.03974 1.37093C1.60359 0.735501 2.30882 0.442002 3.15778 0.288195C3.97313 0.140476 5.00712 0.108454 6.28973 0.0687327L6.34092 0.0671471ZM10 1.52865C8.91061 1.52865 7.63415 1.55634 6.38037 1.59519C5.03448 1.63689 4.09596 1.66764 3.38544 1.79636C2.6977 1.92096 2.31872 2.12264 2.04025 2.43647C1.76329 2.74859 1.58906 3.1729 1.49439 3.94283C1.39683 4.7363 1.39535 5.78211 1.39535 7.27892V8.72108C1.39535 10.2179 1.39683 11.2637 1.49439 12.0571C1.58906 12.827 1.76328 13.2513 2.04024 13.5635C2.31871 13.8773 2.69769 14.079 3.38541 14.2036C4.09592 14.3323 5.03441 14.3631 6.38029 14.4048C7.63409 14.4437 8.91058 14.4713 10 14.4713C11.0894 14.4713 12.3659 14.4437 13.6197 14.4048C14.9656 14.3631 15.9041 14.3323 16.6146 14.2036C17.3023 14.079 17.6813 13.8773 17.9598 13.5635C18.2367 13.2513 18.4109 12.827 18.5056 12.0571C18.6032 11.2637 18.6047 10.2179 18.6047 8.72108V7.27892C18.6047 5.78211 18.6032 4.7363 18.5056 3.94283C18.4109 3.1729 18.2367 2.74859 17.9597 2.43647C17.6813 2.12264 17.3023 1.92096 16.6146 1.79636C15.904 1.66764 14.9655 1.63689 13.6196 1.59519C12.3658 1.55634 11.0894 1.52865 10 1.52865Z" fill="#5B2DE0"/>
                </svg>
              </a>
              <a class="wscm-instagram" href="#">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8 5.33333C6.52724 5.33333 5.33333 6.52724 5.33333 8C5.33333 9.47276 6.52724 10.6667 8 10.6667C9.47276 10.6667 10.6667 9.47276 10.6667 8C10.6667 6.52724 9.47276 5.33333 8 5.33333ZM4.10256 8C4.10256 5.84751 5.84751 4.10256 8 4.10256C10.1525 4.10256 11.8974 5.84751 11.8974 8C11.8974 10.1525 10.1525 11.8974 8 11.8974C5.84751 11.8974 4.10256 10.1525 4.10256 8Z" fill="#5B2DE0"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4.71795 1.23077C2.79203 1.23077 1.23077 2.79203 1.23077 4.71795V11.2821C1.23077 13.208 2.79203 14.7692 4.71795 14.7692H11.2821C13.208 14.7692 14.7692 13.208 14.7692 11.2821V4.71795C14.7692 2.79203 13.208 1.23077 11.2821 1.23077H4.71795ZM0 4.71795C0 2.1123 2.1123 0 4.71795 0H11.2821C13.8877 0 16 2.1123 16 4.71795V11.2821C16 13.8877 13.8877 16 11.2821 16H4.71795C2.1123 16 0 13.8877 0 11.2821V4.71795Z" fill="#5B2DE0"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9327 3.02886C13.1853 3.25622 13.2058 3.64532 12.9784 3.89794L12.9702 3.90706C12.7429 4.15968 12.3538 4.18016 12.1012 3.9528C11.8485 3.72544 11.8281 3.33633 12.0554 3.08371L12.0636 3.0746C12.291 2.82198 12.6801 2.8015 12.9327 3.02886Z" fill="#5B2DE0"/>
                </svg>
              </a>
            </div>
          </div>
          <div class="setting-form">
            <h4 class="label">Review Us</h4>
            <a class="wscm-wordpress-icon" href="#">
              <span class="dashicons dashicons-wordpress"></span>
              <span style="color: #000">Review On Wordpress</span>
            </a>
          </div>
          <div class="setting-form">
            <h4 class="label">Subscribe To Newsletter</h4>
            <el-input type="email" placeholder="Enter email address" v-model="settings.newsletter"></el-input>
          </div>
          <div class="setting-form">
            <h4 class="label"></h4>
            <el-checkbox
              v-model="settings.terms_and_condition"
              true-label="yes"
              false-label="no"
            >
              I agree to the 
              <a 
                href="https://swiftcertificate.com/terms"
                target="_blank"
                rel="noopener noreferrer"
              >
                terms and conditions
              </a>.
            </el-checkbox>
          </div>
        </div>
        
        <div class="settings-item">
          <div class="wscm_action_btn">
            <el-button class="wscm-primary-btn svg-span-btn" @click="saveSettings()">
              <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.0001 18.3333C14.5834 18.3333 18.3334 14.5833 18.3334 9.99999C18.3334 5.41666 14.5834 1.66666 10.0001 1.66666C5.41675 1.66666 1.66675 5.41666 1.66675 9.99999C1.66675 14.5833 5.41675 18.3333 10.0001 18.3333Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.45825 10L8.81659 12.3583L13.5416 7.64166" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Save Settings
            </el-button>
          </div>
        </div>
      </div>

      <div class="wpsc-card" v-if="settingTabMenu === 'payment_methods'">
        <div class="settings-item">
          <div class="header-title">
            <h3 class="title">Payment Method</h3>
          </div>
          <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="Stripe" name="stripe">
              <stripe/>
            </el-tab-pane>
            <el-tab-pane label="Paypal" name="paypal">
              <paypal/>
            </el-tab-pane>
          </el-tabs>
        </div>
      </div>

      <div v-if="settingTabMenu === 'payment_transaction'">
        <payment-transaction/>
      </div>

      <div v-if="settingTabMenu === 'license_management' && hasProVersion">
        <license-management/>
      </div>
  </div>
</template>

<script>
import LicenseManagement from "./LicenseManagement.vue";
import Stripe from '../../Integrations/Stripe';
import Paypal from '../../Integrations/Paypal'
import PhotoUploader from "../../inputComponent/PhotoUploader.vue";
import PaymentTransaction from "./PaymentTransaction.vue";

export default {
  components: {
    LicenseManagement,
    Stripe,
    Paypal,
    PhotoUploader,
    PaymentTransaction
  },
  data() {
    return {
      fetching: false,
      saving: false,
      settingTabMenu: localStorage.getItem('wscm_active_menu_settings') || 'general',
      // activeSettings:
      activeName: localStorage.getItem('wscm_active_payment_method') || 'stripe',
      currencies: window.SwiftCertificateManagerAdminVars.currencies,
      settings: {
        preference: 'instructor'
      },
      preferences: [
        {
          label: 'Company',
          value: 'company'
        },
        {
          label: 'Instructor',
          value: 'instructor'
        },
      ],
      hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro,
      hasProVersion: !!window.SwiftCertificateManagerAdminVars.has_pro_version
    };
  },
  methods: {
    // payment methods
    handleClick(tab, event) {
      localStorage.setItem('wscm_active_payment_method', this.activeName)
    },
   
    settingTabChangeHandler(val) {
      localStorage.setItem('wscm_active_menu_settings', val)
    },
   
    getSettings(){
      this.fetching = true;
      this.$post({
        action: "swift_certificate_manager_global_settings_admin_ajax",
        route: "get_settings",
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
          .then((response) => {
            this.settings = response.data.settings;
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            setTimeout(() => {
              this.fetching = false;
            }, 1000);
          });
    },
    saveSettings() {
      this.saving = true;
      this.$post({
        action: "swift_certificate_manager_global_settings_admin_ajax",
        route: "save_settings",
        settings: this.settings,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
          .then((response) => {
            this.getSettings();
            // setTimeout(() => {
            //   // this.fetching = true;
            //   // location.reload();
            // }, 1000);
            this.$handleSuccess(response.data.message);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            this.saving = false;
          });
    },
  },
  beforeMount() {
    if (this.appVars.is_onboarded === 'no'){
      this.$router.push(
          {
            name: 'setup_template',
            params: {}
          }
      )
    }
  },
  mounted() {
    this.getSettings();
    jQuery('head title').text('Settings - Swift Certificate Manager');
  }
}
</script>