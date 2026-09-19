/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Layouts_Navigation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Layouts/Navigation */ "./resources/admin/Layouts/Navigation.vue");

// import Clipboard from 'clipboard';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Application',
  components: {
    Navigation: _Layouts_Navigation__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      tableData: [{
        date: '2016-05-03',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles'
      }, {
        date: '2016-05-02',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles'
      }, {
        date: '2016-05-04',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles'
      }, {
        date: '2016-05-01',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles'
      }]
    };
  },
  mounted: function mounted() {
    // var clipboard = new Clipboard('.copy');
    // clipboard.on('success', (e) => {
    //     this.$message({
    //         message: 'Copied to Clipboard!',
    //         type: 'success',
    //         offset: 50
    //     });
    // });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Navigation',
  data: function data() {
    return {
      active: '/',
      items: [],
      imageURL: window.swifcemaAdminVars.images_url,
      hasPro: !!window.swifcemaAdminVars.has_pro
    };
  },
  methods: {
    defaultRoutes: function defaultRoutes() {
      return [
      // {
      //   route: '/',
      //   title: 'Dashboard',
      //   icon: `<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>`
      // },
      // {
      //   route: '/', //create_certificate
      //   title: 'Assign Manually',
      //   icon: `<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.5 4.66671V11.3334C14.5 13.3334 13.5 14.6667 11.1667 14.6667H5.83333C3.5 14.6667 2.5 13.3334 2.5 11.3334V4.66671C2.5 2.66671 3.5 1.33337 5.83333 1.33337H11.1667C13.5 1.33337 14.5 2.66671 14.5 4.66671Z" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.1667 3V4.33333C10.1667 5.06667 10.7667 5.66667 11.5 5.66667H12.8334" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.83331 8.66663H8.49998" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.83331 11.3334H11.1666" stroke="#424145" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>`
      // },
      // {
      //   route: '/manage_certificates',
      //   title: 'Management',
      //   icon: `<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.74664 5.92004H12.2466" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.75336 5.92004L5.25336 6.42004L6.75336 4.92004" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.74664 10.5867H12.2466" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.75336 10.5867L5.25336 11.0867L6.75336 9.58667" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.49998 14.6667H10.5C13.8333 14.6667 15.1666 13.3334 15.1666 10V6.00004C15.1666 2.66671 13.8333 1.33337 10.5 1.33337H6.49998C3.16665 1.33337 1.83331 2.66671 1.83331 6.00004V10C1.83331 13.3334 3.16665 14.6667 6.49998 14.6667Z" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`
      // },
      {
        route: '/',
        title: 'Templates',
        icon: "<svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659\" stroke=\"#424145\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/><path d=\"M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z\" stroke=\"#424145\" stroke-miterlimit=\"10\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/><path d=\"M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993\" stroke=\"#424145\" stroke-miterlimit=\"10\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/></svg>"
      }, {
        route: '/settings',
        title: 'Settings',
        icon: "<svg width=\"17\" height=\"16\" viewBox=\"0 0 17 16\" fill=\"none\"  xmlns=\"http://www.w3.org/2000/svg\">\n                  <path d=\"M8.5 10C9.60457 10 10.5 9.10457 10.5 8C10.5 6.89543 9.60457 6 8.5 6C7.39543 6 6.5 6.89543 6.5 8C6.5 9.10457 7.39543 10 8.5 10Z\" stroke=\"#424145\" stroke-width=\"0.8\" stroke-miterlimit=\"10\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n                  <path d=\"M1.83331 8.58666V7.41333C1.83331 6.72 2.39998 6.14666 3.09998 6.14666C4.30665 6.14666 4.79998 5.29333 4.19331 4.24666C3.84665 3.64666 4.05331 2.86666 4.65998 2.52L5.81331 1.86C6.33998 1.54667 7.01998 1.73333 7.33331 2.26L7.40665 2.38666C8.00665 3.43333 8.99331 3.43333 9.59998 2.38666L9.67331 2.26C9.98665 1.73333 10.6666 1.54667 11.1933 1.86L12.3466 2.52C12.9533 2.86666 13.16 3.64666 12.8133 4.24666C12.2066 5.29333 12.7 6.14666 13.9066 6.14666C14.6 6.14666 15.1733 6.71333 15.1733 7.41333V8.58666C15.1733 9.28 14.6066 9.85333 13.9066 9.85333C12.7 9.85333 12.2066 10.7067 12.8133 11.7533C13.16 12.36 12.9533 13.1333 12.3466 13.48L11.1933 14.14C10.6666 14.4533 9.98665 14.2667 9.67331 13.74L9.59998 13.6133C8.99998 12.5667 8.01331 12.5667 7.40665 13.6133L7.33331 13.74C7.01998 14.2667 6.33998 14.4533 5.81331 14.14L4.65998 13.48C4.05331 13.1333 3.84665 12.3533 4.19331 11.7533C4.79998 10.7067 4.30665 9.85333 3.09998 9.85333C2.39998 9.85333 1.83331 9.28 1.83331 8.58666Z\" stroke=\"#424145\" stroke-width=\"0.8\" stroke-miterlimit=\"10\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n                  </svg>"
      }];
    },
    setMenus: function setMenus() {
      this.items = this.applyFilters('swifcema_top_menus', this.defaultRoutes());
    }
  },
  mounted: function mounted() {
    this.setMenus();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ (() => {


// import LicenseManagement from "./Settings/LicenseManagement.vue";
// import Stripe from '../../Integrations/Stripe';
// import Paypal from '../../Integrations/Paypal'
// import PhotoUploader from "../inputComponent/PhotoUploader.vue";
// import PaymentTransaction from "./Settings/PaymentTransaction.vue";

// export default {
//   components: {
//     LicenseManagement,
//     Stripe,
//     Paypal,
//     PhotoUploader,
//     PaymentTransaction
//   },
//   data() {
//     return {
//       fetching: false,
//       saving: false,
//       settingTabMenu: localStorage.getItem('swifcema_active_menu_settings') || 'general',
//       // activeSettings:
//       activeName: localStorage.getItem('swifcema_active_payment_method') || 'stripe',
//       currencies: window.swifcemaAdminVars.currencies,
//       settings: {
//         preference: 'instructor'
//       },
//       preferences: [
//         {
//           label: 'Company',
//           value: 'company'
//         },
//         {
//           label: 'Instructor',
//           value: 'instructor'
//         },
//       ],
//       hasPro: !!window.swifcemaAdminVars.has_pro,
//       hasProVersion: !!window.swifcemaAdminVars.has_pro_version
//     };
//   },
//   methods: {
//     // payment methods
//     handleClick(tab, event) {
//       localStorage.setItem('swifcema_active_payment_method', this.activeName)
//     },

//     settingTabChangeHandler(val) {
//       localStorage.setItem('swifcema_active_menu_settings', val)
//     },

//     getSettings(){
//       this.fetching = true;
//       this.$post({
//         action: "swifcema_global_settings_admin_ajax",
//         route: "get_settings",
//         nonce: window.swifcemaAdminVars.nonce,
//       })
//           .then((response) => {
//             this.settings = response.data.settings;
//           })
//           .fail((error) => {
//             this.$handleError(error);
//           })
//           .always(() => {
//             setTimeout(() => {
//               this.fetching = false;
//             }, 1000);
//           });
//     },
//     saveSettings() {
//       this.saving = true;
//       this.$post({
//         action: "swifcema_global_settings_admin_ajax",
//         route: "save_settings",
//         settings: this.settings,
//         nonce: window.swifcemaAdminVars.nonce,
//       })
//           .then((response) => {
//             this.getSettings();
//             // setTimeout(() => {
//             //   // this.fetching = true;
//             //   // location.reload();
//             // }, 1000);
//             this.$handleSuccess(response.data.message);
//           })
//           .fail((error) => {
//             this.$handleError(error);
//           })
//           .always(() => {
//             this.saving = false;
//           });
//     },
//   },
//   beforeMount() {
//     if (this.appVars.is_onboarded === 'no'){
//       this.$router.push(
//           {
//             name: 'setup_template',
//             params: {}
//           }
//       )
//     }
//   },
//   mounted() {
//     this.getSettings();
//     jQuery('head title').text('Settings - Swift Certificate Manager');
//   }
// }

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// import UpgradePopup from '../Components/UpgradePopup.vue';
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "templates",
  // components: {
  //   UpgradePopup
  // },
  // props: ['active'],
  data: function data() {
    return {
      // action: false,
      // fetching: false,
      // checkTemplates: false,
      // loading: false,
      templates: [{
        "template_name": "1) Falcon - 1 signature | 1 logo",
        "template_image": "template-1.png",
        "slug": "template-1",
        "pro": 0
      }, {
        "template_name": "2) Falcon - 1 signature | No logo",
        "template_image": "template-2.png",
        "slug": "template-2",
        "pro": 0
      }, {
        "template_name": "3) Falcon - 2 signature | No logo",
        "template_image": "template-3.png",
        "slug": "template-3",
        "pro": 0
      }, {
        "template_name": "4) Merlin - 1 signature | 1 logo",
        "template_image": "template-4.png",
        "slug": "template-4",
        "pro": 1
      }, {
        "template_name": "5) Merlin - 2 signature | 1 logo",
        "template_image": "template-5.png",
        "slug": "template-5",
        "pro": 1
      }, {
        "template_name": "6) Merlin - 2 signature | No logo",
        "template_image": "template-6.png",
        "slug": "template-6",
        "pro": 1
      }, {
        "template_name": "7) Phoenix - 1 signature | 2 logo",
        "template_image": "template-7.png",
        "slug": "template-7",
        "pro": 1
      }, {
        "template_name": "8) Phoenix - 2 signature | 1 logo",
        "template_image": "template-8.png",
        "slug": "template-8",
        "pro": 1
      }, {
        "template_name": "9) Phoenix - 2 signature | 2 logo",
        "template_image": "template-9.png",
        "slug": "template-9",
        "pro": 1
      }, {
        "template_name": "10) Skylark - 2 signature | 1 logo",
        "template_image": "template-10.png",
        "slug": "template-10",
        "pro": 1
      }, {
        "template_name": "11) Skylark - 2 signature | No logo",
        "template_image": "template-11.png",
        "slug": "template-11",
        "pro": 1
      }, {
        "template_name": "12) Hawk - 1 signature | 2 logo",
        "template_image": "template-12.png",
        "slug": "template-12",
        "pro": 1
      }, {
        "template_name": "13) Hawk - 2 signature | No logo",
        "template_image": "template-13.png",
        "slug": "template-13",
        "pro": 1
      }],
      // activeTemplate: '',
      // isOnboarded: window.swifcemaAdminVars.is_onboarded,
      uploadCertificateUrl: window.swifcemaAdminVars.upload_certificate_url
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
  mounted: function mounted() {
    // this.getActivatedTemplate();
    // this.getTemplatesHandler();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=template&id=f734b430":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=template&id=f734b430 ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "swifcema-app"
  }, [_c("div", {
    staticClass: "swifcema-header"
  }, [_c("navigation")], 1), _vm._v(" "), _c("div", {
    staticClass: "swifcema-body"
  }, [_c("router-view", {
    key: _vm.$route.fullPath
  })], 1)]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12":
/*!***************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("el-row", {
    staticClass: "swifcema-header"
  }, [_c("el-col", {
    attrs: {
      span: 4
    }
  }, [_c("div", {
    staticClass: "nav-logo"
  }, [_c("router-link", {
    staticClass: "nav-logo-link",
    attrs: {
      to: "/"
    }
  }, [_c("img", {
    attrs: {
      src: _vm.appVars.images_url + "/logo.png"
    }
  })])], 1)]), _vm._v(" "), _c("el-col", {
    attrs: {
      span: 16
    }
  }, [_c("el-menu", {
    staticClass: "swifcema-navigation",
    attrs: {
      router: true,
      mode: "horizontal",
      "default-active": _vm.active
    }
  }, [this.appVars.is_onboarded === "no" ? _c("el-menu-item", {
    staticClass: "el-menu-item"
  }, [_c("router-link", {
    staticClass: "swifcema-menu-link",
    attrs: {
      to: "/setup_template"
    }
  }, [_c("span", {}, [_c("svg", {
    attrs: {
      width: "16",
      height: "16",
      viewBox: "0 0 16 16",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      d: "M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }), _c("path", {
    attrs: {
      d: "M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z",
      stroke: "#424145",
      "stroke-miterlimit": "10",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }), _c("path", {
    attrs: {
      d: "M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993",
      stroke: "#424145",
      "stroke-miterlimit": "10",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  })])]), _vm._v("\n          Setup Template\n        ")])], 1) : _vm._e(), _vm._v(" "), _vm._l(_vm.items, function (item) {
    return _c("el-menu-item", {
      key: item.route,
      staticClass: "el-menu-item"
    }, [_c("router-link", {
      staticClass: "swifcema-menu-link",
      attrs: {
        to: item.route
      }
    }, [_c("span", {
      domProps: {
        innerHTML: _vm._s(item.icon)
      }
    }), _vm._v("\n            " + _vm._s(item.title) + "\n        ")])], 1);
  })], 2)], 1), _vm._v(" "), _c("el-col", {
    attrs: {
      span: 4
    }
  }, [!_vm.hasPro ? _c("div", {
    staticClass: "swifcema-nav-pro-btn"
  }, [_c("a", {
    staticClass: "nav-logo-link",
    attrs: {
      href: "https://swiftcertificate.com/",
      target: "_blank"
    }
  }, [_c("el-button", {
    staticClass: "swifcema-pro-btn"
  }, [_c("svg", {
    attrs: {
      width: "20",
      height: "20",
      viewBox: "0 0 20 20",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      d: "M13.9166 15.8167H6.08325C5.73325 15.8167 5.34159 15.5417 5.22492 15.2083L1.77492 5.55834C1.28326 4.17501 1.85826 3.75001 3.04159 4.60001L6.29159 6.92501C6.83325 7.30001 7.44992 7.10834 7.68325 6.50001L9.14992 2.59167C9.61659 1.34167 10.3916 1.34167 10.8583 2.59167L12.3249 6.50001C12.5583 7.10834 13.1749 7.30001 13.7083 6.92501L16.7583 4.75001C18.0583 3.81667 18.6833 4.29168 18.1499 5.80001L14.7833 15.225C14.6583 15.5417 14.2666 15.8167 13.9166 15.8167Z",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      d: "M5.41675 18.3333H14.5834",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      d: "M7.91675 11.6667H12.0834",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  })]), _vm._v("\n          " + _vm._s("Upgrade to Pro") + "\n        ")])], 1)]) : _vm._e()])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8":
/*!**************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_vm._v("Vue Load")]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3":
/*!*************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c,
    _setup = _vm._self._setupProxy;
  return _c("div", {
    staticClass: "swifcema-settings-wrap"
  }, [_c("div", {
    staticClass: "header"
  }, [_c("div", {
    staticClass: "setting_header"
  }, [_c("h1", [_vm._v("Settings")]), _vm._v(" "), _c("p", [_vm._v("Manage your settings and payment method here ")]), _vm._v(" "), _c("el-radio-group", {
    staticStyle: {
      "margin-bottom": "30px"
    }
  }, [_c("el-radio-button", {
    attrs: {
      label: "general"
    }
  }, [_vm._v("General")])], 1)], 1)]), _vm._v(" "), _c("div", {
    staticClass: "swifcema-card"
  }, [_c("div", {
    staticClass: "settings-item"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Select Your Preferences")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("\n            Company Name")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("\n            Signature\n          ")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form",
    staticStyle: {
      display: "flex",
      "justify-content": "center",
      "align-items": "center"
    }
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("\n            Signature Image\n          ")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("\n           Signature Image Enable\n          ")]), _vm._v(" "), _c("el-checkbox", {
    attrs: {
      "true-label": "yes",
      "false-label": "no"
    }
  }, [_vm._v("\n            Enable Signature Image\n          ")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "settings-item"
  }, [_c("h3", {
    staticClass: "title"
  }, [_vm._v("Currency Setting")]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Default Currency")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Certificate Price")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text",
      placeholder: "Enter amount ex: 10"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "settings-item"
  }, [_c("h3", {
    staticClass: "title"
  }, [_vm._v("Certificate Information")]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Order Certificate URL")]), _vm._v(" "), _c("div", {
    staticClass: "setting-copy-field"
  }, [_c("el-input", {
    attrs: {
      type: "text",
      placeholder: "Enter student name",
      disabled: ""
    }
  }), _vm._v(" "), _c("el-tooltip", {
    attrs: {
      effect: "dark",
      content: "Click To Copy",
      title: "Click To Copy",
      placement: "top"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Verify Certificate URL")]), _vm._v(" "), _c("div", {
    staticClass: "setting-copy-field"
  }, [_c("el-input", {
    attrs: {
      type: "text",
      placeholder: "verify url",
      disabled: ""
    }
  }), _vm._v(" "), _c("el-tooltip", {
    attrs: {
      effect: "dark",
      content: "Click To Copy",
      title: "Click To Copy",
      placement: "top"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Order Certificate Shortcode")]), _vm._v(" "), _c("div", {
    staticClass: "setting-copy-field"
  }, [_c("el-input", {
    attrs: {
      type: "text",
      placeholder: "Enter order url",
      disabled: ""
    }
  }), _vm._v(" "), _c("el-tooltip", {
    attrs: {
      effect: "dark",
      content: "Click To Copy",
      title: "Click To Copy",
      placement: "top"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Verify Certificate Shortcode")]), _vm._v(" "), _c("div", {
    staticClass: "setting-copy-field"
  }, [_c("el-input", {
    attrs: {
      type: "text"
    }
  }), _vm._v(" "), _c("el-tooltip", {
    attrs: {
      effect: "dark",
      content: "Click To Copy",
      title: "Click To Copy",
      placement: "top"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Certificate Code Prefix")]), _vm._v(" "), _c("el-input", {
    attrs: {
      type: "text",
      placeholder: "Enter certificate code prefix"
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Clear Cache")]), _vm._v(" "), _c("el-checkbox", {
    staticClass: "swifcema_checkbox",
    attrs: {
      "true-label": "yes",
      "false-label": "no",
      label: "Clearing for whole cache"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "settings-item"
  }, [_c("h3", {
    staticClass: "title"
  }, [_vm._v("Certificate Reviews")]), _vm._v(" "), _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Share Swift Certificate Manager Plugin")]), _vm._v(" "), _c("div", {
    staticClass: "swifcema-socia-icon"
  }, [_c("a", {
    staticClass: "swifcema-twitter",
    attrs: {
      href: "#"
    }
  }, [_c("svg", {
    attrs: {
      viewBox: "0 0 20 17",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M12.2252 0.300602C13.0771 -0.0334262 14.0083 -0.0906208 14.8928 0.136754C15.6361 0.327823 16.3164 0.712098 16.8697 1.24937C17.0788 1.16822 17.2359 1.08636 17.4384 0.972246C17.5028 0.935949 17.572 0.8962 17.6484 0.852366C17.9575 0.674859 18.3833 0.430358 19.0785 0.0768431C19.3248 -0.0483658 19.6214 0.00234362 19.8149 0.202732C20.0083 0.40312 20.0553 0.708222 19.9314 0.960163C19.8348 1.15674 19.7335 1.39078 19.6151 1.66415L19.6109 1.67379C19.4933 1.94535 19.3619 2.24839 19.215 2.55388C18.9698 3.06388 18.6651 3.6169 18.2687 4.08832C18.2876 4.25704 18.2973 4.42679 18.2979 4.5968L18.2979 4.59897C18.2979 9.85576 15.8382 13.6919 12.3212 15.615C8.81976 17.5296 4.33465 17.5134 0.328377 15.2269C0.0699886 15.0794 -0.0560402 14.7689 0.0237777 14.4766C0.103596 14.1842 0.368377 13.9863 0.66373 13.9984C2.26733 14.0639 3.85328 13.7004 5.26936 12.9526C3.83753 12.1165 2.83617 11.1008 2.16028 10.0045C1.33017 8.65796 1.0152 7.22929 0.958167 5.94022C0.901258 4.65402 1.10021 3.49332 1.31029 2.65882C1.41571 2.24004 1.52499 1.89928 1.6089 1.66084C1.65089 1.54152 1.68663 1.44752 1.71253 1.38186C1.72548 1.34903 1.73597 1.32325 1.74356 1.30491L1.75272 1.28301L1.75557 1.27633L1.75654 1.27406L1.75691 1.27321C1.75706 1.27285 1.7572 1.27253 2.34048 1.53885L1.7572 1.27253C1.85059 1.05666 2.04979 0.909076 2.27866 0.886194C2.50752 0.863312 2.73068 0.968667 2.86283 1.16199C3.66218 2.33132 4.73061 3.27941 5.97298 3.92182C7.02979 4.46829 8.18455 4.77914 9.36173 4.837V4.6294C9.35044 3.69434 9.61848 2.77816 10.1298 2.0044C10.6419 1.22938 11.3734 0.634631 12.2252 0.300602ZM2.57248 2.88493C2.56372 2.91838 2.55495 2.95247 2.54621 2.98719C2.35736 3.73739 2.18397 4.76249 2.23344 5.88067C2.28279 6.99597 2.55292 8.19026 3.23877 9.30277C3.92204 10.4111 5.0422 11.4781 6.85502 12.3058C7.06681 12.4025 7.21093 12.6095 7.23155 12.8467C7.25216 13.0838 7.14603 13.3138 6.95427 13.4475C5.80899 14.2462 4.52923 14.8004 3.19048 15.088C6.18543 16.091 9.25034 15.8085 11.7214 14.4573C14.7999 12.774 17.0209 9.39739 17.0213 4.60015C17.0206 4.39753 17.0016 4.19542 16.9645 3.9964C16.9245 3.7814 16.9916 3.56008 17.1433 3.40639C17.4599 3.08565 17.7301 2.65138 17.976 2.16473C17.6431 2.349 17.3634 2.47854 16.8734 2.63013C16.633 2.7045 16.3725 2.62718 16.2077 2.43256C15.781 1.92846 15.2138 1.57117 14.583 1.40901C13.9521 1.24685 13.288 1.28764 12.6805 1.52587C12.0729 1.76409 11.5512 2.18826 11.186 2.741C10.8207 3.29375 10.6295 3.94839 10.6383 4.61641L10.6384 4.6252L10.6383 5.49951C10.6383 5.85505 10.3625 6.14582 10.0166 6.15503C8.41572 6.19768 6.82945 5.83293 5.39903 5.09328C4.32967 4.54032 3.37223 3.79067 2.57248 2.88493Z",
      fill: "#5B2DE0"
    }
  })])]), _vm._v(" "), _c("a", {
    staticClass: "swifcema-facebook",
    attrs: {
      href: "#"
    }
  }, [_c("svg", {
    attrs: {
      viewBox: "0 0 9 16",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M3.37258 1.25331C4.14898 0.450829 5.202 0 6.3 0H8.46C8.75823 0 9 0.249888 9 0.55814V3.53488C9 3.84314 8.75823 4.09302 8.46 4.09302H6.3C6.25226 4.09302 6.20647 4.11262 6.17272 4.14752C6.13896 4.18241 6.12 4.22973 6.12 4.27907V5.95349H8.46C8.62628 5.95349 8.78329 6.03267 8.88563 6.16814C8.98796 6.30361 9.0242 6.48026 8.98387 6.647L8.26387 9.62374C8.20378 9.87221 7.98778 10.0465 7.74 10.0465H6.12V15.4419C6.12 15.7501 5.87823 16 5.58 16H2.7C2.40176 16 2.16 15.7501 2.16 15.4419V10.0465H0.54C0.241766 10.0465 0 9.79662 0 9.48837V6.51163C0 6.20338 0.241766 5.95349 0.54 5.95349H2.16V4.27907C2.16 3.14419 2.59618 2.05579 3.37258 1.25331ZM6.3 1.11628C5.48843 1.11628 4.71011 1.4495 4.13625 2.04264C3.56239 2.63578 3.24 3.44025 3.24 4.27907V6.51163C3.24 6.81988 2.99823 7.06977 2.7 7.06977H1.08V8.93023H2.7C2.99823 8.93023 3.24 9.18012 3.24 9.48837V14.8837H5.04V9.48837C5.04 9.18012 5.28176 8.93023 5.58 8.93023H7.31838L7.76838 7.06977H5.58C5.28176 7.06977 5.04 6.81988 5.04 6.51163V4.27907C5.04 3.93367 5.17275 3.60242 5.40904 3.35819C5.64534 3.11395 5.96582 2.97674 6.3 2.97674H7.92V1.11628H6.3Z",
      fill: "#5B2DE0"
    }
  })])]), _vm._v(" "), _c("a", {
    staticClass: "swifcema-youtube",
    attrs: {
      href: "#"
    }
  }, [_c("svg", {
    attrs: {
      viewBox: "0 0 20 16",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      d: "M11.8605 7.99993L8.60465 10.0381V5.96172L11.8605 7.99993Z",
      fill: "#5B2DE0"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M8.25447 10.6992C8.46957 10.836 8.73486 10.8369 8.9508 10.7017L12.2066 8.66355C12.424 8.52746 12.5581 8.27421 12.5581 7.99993C12.5581 7.72564 12.424 7.47239 12.2066 7.3363L8.9508 5.2981C8.73486 5.16292 8.46957 5.16389 8.25447 5.30065C8.03937 5.4374 7.90698 5.68926 7.90698 5.96172V10.0381C7.90698 10.3106 8.03937 10.5624 8.25447 10.6992ZM9.30233 8.72106V7.27879L10.4543 7.99993L9.30233 8.72106Z",
      fill: "#5B2DE0"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M6.34092 0.0671471C7.6007 0.0281116 8.89185 0 10 0C11.1081 0 12.3993 0.0281115 13.6591 0.067147L13.7103 0.0687327C14.9929 0.108454 16.0269 0.140476 16.8422 0.288195C17.6912 0.442002 18.3964 0.735501 18.9603 1.37093C19.5256 2.00807 19.7726 2.79605 19.8885 3.73876C20 4.64614 20 5.7952 20 7.22314V8.77686C20 10.2048 20 11.3538 19.8885 12.2612C19.7726 13.2039 19.5256 13.9919 18.9603 14.629C18.3964 15.2644 17.6912 15.5579 16.8423 15.7118C16.0269 15.8595 14.9929 15.8915 13.7103 15.9312L13.6592 15.9328C12.3994 15.9719 11.1082 16 10 16C8.89182 16 7.60063 15.9719 6.34082 15.9328L6.28967 15.9312C5.00706 15.8915 3.97308 15.8595 3.15773 15.7118C2.30879 15.5579 1.60357 15.2644 1.03973 14.629C0.47438 13.9919 0.227445 13.2039 0.111535 12.2612C-3.33301e-05 11.3538 -1.83102e-05 10.2048 4.86016e-07 8.77684V7.22316C-1.83102e-05 5.79521 -3.33405e-05 4.64614 0.111536 3.73876C0.227447 2.79605 0.474385 2.00807 1.03974 1.37093C1.60359 0.735501 2.30882 0.442002 3.15778 0.288195C3.97313 0.140476 5.00712 0.108454 6.28973 0.0687327L6.34092 0.0671471ZM10 1.52865C8.91061 1.52865 7.63415 1.55634 6.38037 1.59519C5.03448 1.63689 4.09596 1.66764 3.38544 1.79636C2.6977 1.92096 2.31872 2.12264 2.04025 2.43647C1.76329 2.74859 1.58906 3.1729 1.49439 3.94283C1.39683 4.7363 1.39535 5.78211 1.39535 7.27892V8.72108C1.39535 10.2179 1.39683 11.2637 1.49439 12.0571C1.58906 12.827 1.76328 13.2513 2.04024 13.5635C2.31871 13.8773 2.69769 14.079 3.38541 14.2036C4.09592 14.3323 5.03441 14.3631 6.38029 14.4048C7.63409 14.4437 8.91058 14.4713 10 14.4713C11.0894 14.4713 12.3659 14.4437 13.6197 14.4048C14.9656 14.3631 15.9041 14.3323 16.6146 14.2036C17.3023 14.079 17.6813 13.8773 17.9598 13.5635C18.2367 13.2513 18.4109 12.827 18.5056 12.0571C18.6032 11.2637 18.6047 10.2179 18.6047 8.72108V7.27892C18.6047 5.78211 18.6032 4.7363 18.5056 3.94283C18.4109 3.1729 18.2367 2.74859 17.9597 2.43647C17.6813 2.12264 17.3023 1.92096 16.6146 1.79636C15.904 1.66764 14.9655 1.63689 13.6196 1.59519C12.3658 1.55634 11.0894 1.52865 10 1.52865Z",
      fill: "#5B2DE0"
    }
  })])]), _vm._v(" "), _c("a", {
    staticClass: "swifcema-instagram",
    attrs: {
      href: "#"
    }
  }, [_c("svg", {
    attrs: {
      viewBox: "0 0 16 16",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M8 5.33333C6.52724 5.33333 5.33333 6.52724 5.33333 8C5.33333 9.47276 6.52724 10.6667 8 10.6667C9.47276 10.6667 10.6667 9.47276 10.6667 8C10.6667 6.52724 9.47276 5.33333 8 5.33333ZM4.10256 8C4.10256 5.84751 5.84751 4.10256 8 4.10256C10.1525 4.10256 11.8974 5.84751 11.8974 8C11.8974 10.1525 10.1525 11.8974 8 11.8974C5.84751 11.8974 4.10256 10.1525 4.10256 8Z",
      fill: "#5B2DE0"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M4.71795 1.23077C2.79203 1.23077 1.23077 2.79203 1.23077 4.71795V11.2821C1.23077 13.208 2.79203 14.7692 4.71795 14.7692H11.2821C13.208 14.7692 14.7692 13.208 14.7692 11.2821V4.71795C14.7692 2.79203 13.208 1.23077 11.2821 1.23077H4.71795ZM0 4.71795C0 2.1123 2.1123 0 4.71795 0H11.2821C13.8877 0 16 2.1123 16 4.71795V11.2821C16 13.8877 13.8877 16 11.2821 16H4.71795C2.1123 16 0 13.8877 0 11.2821V4.71795Z",
      fill: "#5B2DE0"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      "fill-rule": "evenodd",
      "clip-rule": "evenodd",
      d: "M12.9327 3.02886C13.1853 3.25622 13.2058 3.64532 12.9784 3.89794L12.9702 3.90706C12.7429 4.15968 12.3538 4.18016 12.1012 3.9528C11.8485 3.72544 11.8281 3.33633 12.0554 3.08371L12.0636 3.0746C12.291 2.82198 12.6801 2.8015 12.9327 3.02886Z",
      fill: "#5B2DE0"
    }
  })])])])]), _vm._v(" "), _vm._m(1)]), _vm._v(" "), _c("div", {
    staticClass: "settings-item"
  }, [_c("div", {
    staticClass: "swifcema_action_btn"
  }, [_c("el-button", {
    staticClass: "swifcema-primary-btn svg-span-btn"
  }, [_c("svg", {
    attrs: {
      width: "16",
      height: "16",
      viewBox: "0 0 20 20",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg"
    }
  }, [_c("path", {
    attrs: {
      d: "M10.0001 18.3333C14.5834 18.3333 18.3334 14.5833 18.3334 9.99999C18.3334 5.41666 14.5834 1.66666 10.0001 1.66666C5.41675 1.66666 1.66675 5.41666 1.66675 9.99999C1.66675 14.5833 5.41675 18.3333 10.0001 18.3333Z",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }), _vm._v(" "), _c("path", {
    attrs: {
      d: "M6.45825 10L8.81659 12.3583L13.5416 7.64166",
      stroke: "#424145",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  })]), _vm._v("\n            Save Settings\n          ")])], 1)])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c,
    _setup = _vm._self._setupProxy;
  return _c("div", {
    staticClass: "header-title"
  }, [_c("h3", {
    staticClass: "title"
  }, [_vm._v("General Information")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c,
    _setup = _vm._self._setupProxy;
  return _c("div", {
    staticClass: "setting-form"
  }, [_c("h4", {
    staticClass: "label"
  }, [_vm._v("Review Us")]), _vm._v(" "), _c("a", {
    staticClass: "swifcema-wordpress-icon",
    attrs: {
      href: "#"
    }
  }, [_c("span", {
    staticClass: "dashicons dashicons-wordpress"
  }), _vm._v(" "), _c("span", {
    staticStyle: {
      color: "#000"
    }
  }, [_vm._v("Review On Wordpress")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae":
/*!**************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "swifcema-templates"
  }, [_c("div", {
    staticClass: "title header"
  }, [_c("h1", [_vm._v("Templates")]), _vm._v(" "), _c("div", {
    staticClass: "btn-handler"
  }, [_c("el-button", {
    staticClass: "capsule-btn",
    attrs: {
      icon: "el-icon-service",
      round: ""
    }
  }, [_vm._v("\n        Order Customized Certificates\n      ")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "templates-wrap"
  }, [_c("div", {
    staticClass: "templates"
  }, [_c("el-row", {
    attrs: {
      gutter: 20
    }
  }, _vm._l(_vm.templates, function (template, index) {
    return _c("el-col", {
      key: index,
      staticClass: "mb20 pro-template",
      attrs: {
        span: 6
      }
    }, [_c("el-card", {
      staticClass: "box-card",
      attrs: {
        "body-style": {
          padding: "0px"
        }
      }
    }, [_c("div", {
      staticClass: "template-image"
    }, [_c("img", {
      staticClass: "image",
      attrs: {
        src: _vm.uploadCertificateUrl + template.template_image
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "title",
      staticStyle: {
        padding: "0px 10px",
        "text-align": "center"
      }
    }, [_c("p", [_vm._v(_vm._s(template.template_name))])]), _vm._v(" "), _c("div", {
      staticClass: "card-actions"
    }, [_c("a", {
      staticClass: "el-button capsule-btn el-button--default is-round",
      attrs: {
        href: _vm.uploadCertificateUrl + template.template_image,
        download: ""
      }
    }, [_vm._v("Download Template")]), _vm._v(" "), _c("el-button", {
      staticClass: "capsule-btn",
      attrs: {
        round: "",
        icon: "el-icon-view"
      },
      on: {
        click: function click($event) {
          return _vm.gotoCustomizations(template.id);
        }
      }
    }, [_vm._v("\n                View\n              ")])], 1)])], 1);
  }), 1)], 1)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/admin/Bits/routes.js":
/*!****************************************!*\
  !*** ./resources/admin/Bits/routes.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Modules_Dashboard__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Modules/Dashboard */ "./resources/admin/Modules/Dashboard.vue");
/* harmony import */ var _Modules_Settings__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../Modules/Settings */ "./resources/admin/Modules/Settings.vue");
/* harmony import */ var _Modules_Templates__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Modules/Templates */ "./resources/admin/Modules/Templates.vue");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ([
// {
//     name: 'dashboard',
//     path: '/',
//     component: Dashboard,
//     exact: true
// },
{
  name: 'templates',
  path: '/',
  component: _Modules_Templates__WEBPACK_IMPORTED_MODULE_2__["default"],
  exact: true
}, {
  name: 'settings',
  path: '/settings',
  component: _Modules_Settings__WEBPACK_IMPORTED_MODULE_1__["default"],
  exact: true
}]);

/***/ }),

/***/ "./resources/admin/Application.vue":
/*!*****************************************!*\
  !*** ./resources/admin/Application.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Application.vue?vue&type=template&id=f734b430 */ "./resources/admin/Application.vue?vue&type=template&id=f734b430");
/* harmony import */ var _Application_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Application.vue?vue&type=script&lang=js */ "./resources/admin/Application.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Application_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__.render,
  _Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/Application.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/Layouts/Navigation.vue":
/*!************************************************!*\
  !*** ./resources/admin/Layouts/Navigation.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation.vue?vue&type=template&id=1be81d12 */ "./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12");
/* harmony import */ var _Navigation_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navigation.vue?vue&type=script&lang=js */ "./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navigation_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__.render,
  _Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/Layouts/Navigation.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/Modules/Dashboard.vue":
/*!***********************************************!*\
  !*** ./resources/admin/Modules/Dashboard.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=bf6626f8 */ "./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
  _Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__.render,
  _Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/Modules/Dashboard.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/Modules/Settings.vue":
/*!**********************************************!*\
  !*** ./resources/admin/Modules/Settings.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Settings.vue?vue&type=template&id=475560e3 */ "./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3");
/* harmony import */ var _Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Settings.vue?vue&type=script&lang=js */ "./resources/admin/Modules/Settings.vue?vue&type=script&lang=js");
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__.render,
  _Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/Modules/Settings.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/Modules/Templates.vue":
/*!***********************************************!*\
  !*** ./resources/admin/Modules/Templates.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Templates.vue?vue&type=template&id=7f6c2aae */ "./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae");
/* harmony import */ var _Templates_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Templates.vue?vue&type=script&lang=js */ "./resources/admin/Modules/Templates.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Templates_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__.render,
  _Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/Modules/Templates.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/Application.vue?vue&type=script&lang=js":
/*!*****************************************************************!*\
  !*** ./resources/admin/Application.vue?vue&type=script&lang=js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Application_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Application.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Application_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js":
/*!************************************************************************!*\
  !*** ./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Navigation.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/Modules/Settings.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/admin/Modules/Settings.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Settings.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0___default())); 

/***/ }),

/***/ "./resources/admin/Modules/Templates.vue?vue&type=script&lang=js":
/*!***********************************************************************!*\
  !*** ./resources/admin/Modules/Templates.vue?vue&type=script&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Templates_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Templates.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Templates_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/Application.vue?vue&type=template&id=f734b430":
/*!***********************************************************************!*\
  !*** ./resources/admin/Application.vue?vue&type=template&id=f734b430 ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Application_vue_vue_type_template_id_f734b430__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Application.vue?vue&type=template&id=f734b430 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Application.vue?vue&type=template&id=f734b430");


/***/ }),

/***/ "./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12":
/*!******************************************************************************!*\
  !*** ./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12 ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_1be81d12__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Navigation.vue?vue&type=template&id=1be81d12 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Layouts/Navigation.vue?vue&type=template&id=1be81d12");


/***/ }),

/***/ "./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8":
/*!*****************************************************************************!*\
  !*** ./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8 ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_bf6626f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Dashboard.vue?vue&type=template&id=bf6626f8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Dashboard.vue?vue&type=template&id=bf6626f8");


/***/ }),

/***/ "./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3":
/*!****************************************************************************!*\
  !*** ./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Settings_vue_vue_type_template_id_475560e3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Settings.vue?vue&type=template&id=475560e3 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Settings.vue?vue&type=template&id=475560e3");


/***/ }),

/***/ "./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae":
/*!*****************************************************************************!*\
  !*** ./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Templates_vue_vue_type_template_id_7f6c2aae__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Templates.vue?vue&type=template&id=7f6c2aae */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/Modules/Templates.vue?vue&type=template&id=7f6c2aae");


/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent(
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */,
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options =
    typeof scriptExports === 'function' ? scriptExports.options : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) {
    // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
          injectStyles.call(
            this,
            (options.functional ? this.parent : this).$root.$options.shadowRoot
          )
        }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection(h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing ? [].concat(existing, hook) : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!**********************************!*\
  !*** ./resources/admin/start.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Bits_routes__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Bits/routes */ "./resources/admin/Bits/routes.js");

var vueRouter = new window.SwiftCertificateManager.Router({
  routes: window.SwiftCertificateManager.applyFilters('swifcema_global_routes', _Bits_routes__WEBPACK_IMPORTED_MODULE_0__["default"])
});

// window.SwiftCertificateManager.Vue.prototype.$get = window.SwiftCertificateManager.$get;
// window.SwiftCertificateManager.Vue.prototype.$post = window.SwiftCertificateManager.$post;
// window.SwiftCertificateManager.Vue.prototype.$put = window.SwiftCertificateManager.$put;
// window.SwiftCertificateManager.Vue.prototype.$del = window.SwiftCertificateManager.$del;

// window.SwiftCertificateManager.Vue.prototype.$bus = new window.SwiftCertificateManager.Vue();

new window.SwiftCertificateManager.Vue({
  el: '#wp_swifcema_app',
  render: function render(h) {
    return h((__webpack_require__(/*! ./Application */ "./resources/admin/Application.vue")["default"]));
  },
  router: vueRouter,
  mounted: function mounted() {}
});
})();

/******/ })()
;