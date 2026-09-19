import routes from './Bits/routes';

const vueRouter = new window.SwiftCertificateManager.Router({
    routes: window.SwiftCertificateManager.applyFilters('swifcema_global_routes', routes)
});

// window.SwiftCertificateManager.Vue.prototype.$get = window.SwiftCertificateManager.$get;
// window.SwiftCertificateManager.Vue.prototype.$post = window.SwiftCertificateManager.$post;
// window.SwiftCertificateManager.Vue.prototype.$put = window.SwiftCertificateManager.$put;
// window.SwiftCertificateManager.Vue.prototype.$del = window.SwiftCertificateManager.$del;

// window.SwiftCertificateManager.Vue.prototype.$bus = new window.SwiftCertificateManager.Vue();

new window.SwiftCertificateManager.Vue({
    el: '#wp_swifcema_app',
    render: h => h(require('./Application').default),
    router: vueRouter,
    mounted() {
    }
});
