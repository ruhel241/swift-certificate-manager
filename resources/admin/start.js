import routes from './Bits/routes';

const vueRouter = new window.SwiftCertificateManager.Router({
    routes: window.SwiftCertificateManager.applyFilters('swiftcm_global_routes', routes)
});

window.SwiftCertificateManager.Vue.prototype.$get = window.SwiftCertificateManager.$get;
window.SwiftCertificateManager.Vue.prototype.$post = window.SwiftCertificateManager.$post;
window.SwiftCertificateManager.Vue.prototype.$put = window.SwiftCertificateManager.$put;
window.SwiftCertificateManager.Vue.prototype.$del = window.SwiftCertificateManager.$del;

window.SwiftCertificateManager.Vue.prototype.$bus = new window.SwiftCertificateManager.Vue();

new window.SwiftCertificateManager.Vue({
    el: '#wp_swiftcm_app',
    render: h => h(require('./Application').default),
    router: vueRouter,
    mounted() {
        // this.$get('settings').then(r => {
        //     window.SwiftCertificateManager.settings = r.data;
        // });
    }
});

// import Vue from 'vue'
// import App from './Application.vue'

// // Vue.config.productionTip = false

// new Vue({
//   render: h => h(App),
// }).$mount('#wp_swiftcm_app')