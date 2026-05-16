<template>
    <el-row class="swiftcm-header">
      <el-col :span="4">
        <div class="nav-logo">
          <router-link to="/" class="nav-logo-link">
            <img :src="appVars.images_url + '/logo.png'" />
          </router-link>
        </div>
      </el-col>
  
      <el-col :span="16">
        <el-menu
          :router="true"
          mode="horizontal"
          class="swiftcm-navigation"
          :default-active="active"
        >
          <el-menu-item class="el-menu-item" v-if="this.appVars.is_onboarded === 'no'">
            <router-link to="/setup_template" class="swiftcm-menu-link">
              <span class=""><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
              Setup Template
            </router-link>
          </el-menu-item>

          <el-menu-item class="el-menu-item" v-for="item in items" :key="item.route">
            <router-link :to="item.route" class="swiftcm-menu-link">
                <span class="" v-html="item.icon"></span>
                {{ item.title }}
            </router-link>
          </el-menu-item>
        </el-menu>
      </el-col>
      <!-- Pro Button -->
      <el-col :span="4">
        <div class="swiftcm-nav-pro-btn" v-if="!hasPro">
          <a href="https://swiftcertificate.com/" class="nav-logo-link" target="_blank">
            <el-button class="swiftcm-pro-btn">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.9166 15.8167H6.08325C5.73325 15.8167 5.34159 15.5417 5.22492 15.2083L1.77492 5.55834C1.28326 4.17501 1.85826 3.75001 3.04159 4.60001L6.29159 6.92501C6.83325 7.30001 7.44992 7.10834 7.68325 6.50001L9.14992 2.59167C9.61659 1.34167 10.3916 1.34167 10.8583 2.59167L12.3249 6.50001C12.5583 7.10834 13.1749 7.30001 13.7083 6.92501L16.7583 4.75001C18.0583 3.81667 18.6833 4.29168 18.1499 5.80001L14.7833 15.225C14.6583 15.5417 14.2666 15.8167 13.9166 15.8167Z" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.41675 18.3333H14.5834" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7.91675 11.6667H12.0834" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              {{ 'Upgrade to Pro' }}
            </el-button>
          </a>
        </div>
      </el-col>
    </el-row>
  </template>
  
  <script>
  export default {
    name: 'Navigation',
    data() {
      return {
        active: '/',
        items: [],
        imageURL: window.swiftcmAdminVars.images_url,
        hasPro: !!window.swiftcmAdminVars.has_pro
      };
    },
    methods: {
      defaultRoutes() {
        return [
          // {
          //   route: '/setup_template',
          //   title: 'Setup Template',
          //   icon: `<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>`
          // },
          {
            route: '/', //create_certificate
            title: 'Assign Manually',
            icon: `<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.5 4.66671V11.3334C14.5 13.3334 13.5 14.6667 11.1667 14.6667H5.83333C3.5 14.6667 2.5 13.3334 2.5 11.3334V4.66671C2.5 2.66671 3.5 1.33337 5.83333 1.33337H11.1667C13.5 1.33337 14.5 2.66671 14.5 4.66671Z" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.1667 3V4.33333C10.1667 5.06667 10.7667 5.66667 11.5 5.66667H12.8334" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.83331 8.66663H8.49998" stroke="#291465" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.83331 11.3334H11.1666" stroke="#424145" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>`
          },
          {
            route: '/manage_certificates',
            title: 'Management',
            icon: `<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.74664 5.92004H12.2466" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.75336 5.92004L5.25336 6.42004L6.75336 4.92004" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.74664 10.5867H12.2466" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.75336 10.5867L5.25336 11.0867L6.75336 9.58667" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.49998 14.6667H10.5C13.8333 14.6667 15.1666 13.3334 15.1666 10V6.00004C15.1666 2.66671 13.8333 1.33337 10.5 1.33337H6.49998C3.16665 1.33337 1.83331 2.66671 1.83331 6.00004V10C1.83331 13.3334 3.16665 14.6667 6.49998 14.6667Z" stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`
          },
          {
            route: '/templates',
            title: 'Templates',
            icon: `<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659" stroke="#424145" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>`
          },
          {
            route: '/settings',
            title: 'Settings',
            icon: `<svg width="17" height="16" viewBox="0 0 17 16" fill="none"  xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.5 10C9.60457 10 10.5 9.10457 10.5 8C10.5 6.89543 9.60457 6 8.5 6C7.39543 6 6.5 6.89543 6.5 8C6.5 9.10457 7.39543 10 8.5 10Z" stroke="#424145" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M1.83331 8.58666V7.41333C1.83331 6.72 2.39998 6.14666 3.09998 6.14666C4.30665 6.14666 4.79998 5.29333 4.19331 4.24666C3.84665 3.64666 4.05331 2.86666 4.65998 2.52L5.81331 1.86C6.33998 1.54667 7.01998 1.73333 7.33331 2.26L7.40665 2.38666C8.00665 3.43333 8.99331 3.43333 9.59998 2.38666L9.67331 2.26C9.98665 1.73333 10.6666 1.54667 11.1933 1.86L12.3466 2.52C12.9533 2.86666 13.16 3.64666 12.8133 4.24666C12.2066 5.29333 12.7 6.14666 13.9066 6.14666C14.6 6.14666 15.1733 6.71333 15.1733 7.41333V8.58666C15.1733 9.28 14.6066 9.85333 13.9066 9.85333C12.7 9.85333 12.2066 10.7067 12.8133 11.7533C13.16 12.36 12.9533 13.1333 12.3466 13.48L11.1933 14.14C10.6666 14.4533 9.98665 14.2667 9.67331 13.74L9.59998 13.6133C8.99998 12.5667 8.01331 12.5667 7.40665 13.6133L7.33331 13.74C7.01998 14.2667 6.33998 14.4533 5.81331 14.14L4.65998 13.48C4.05331 13.1333 3.84665 12.3533 4.19331 11.7533C4.79998 10.7067 4.30665 9.85333 3.09998 9.85333C2.39998 9.85333 1.83331 9.28 1.83331 8.58666Z" stroke="#424145" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>`
          }
        ];
      },
      setMenus() {
        this.items = this.applyFilters(
          'swiftcm_top_menus',
          this.defaultRoutes()
        );
      },
    },
    mounted() {
      this.setMenus();
    },
  };
  </script>
  