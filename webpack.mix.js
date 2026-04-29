let mix = require('./resources/admin/Bits/mix');

mix.js('resources/admin/boot.js', 'assets/admin/js/boot.js').vue({ version: 2 });
mix.js('resources/admin/start.js', 'assets/admin/js/start.js').vue({ version: 2 });
mix.js('resources/public/js/wscm_request_certificate.js', 'assets/public/js/wscm_request_certificate.js');
mix.js('resources/public/js/PaymentMethods/stripe-checkout.js', 'assets/public/js/PaymentMethods/stripe-checkout.js');
mix.js('resources/public/js/PaymentMethods/paypal-checkout.js', 'assets/public/js/PaymentMethods/paypal-checkout.js');
mix.sass('resources/scss/admin.scss', 'assets/admin/css/admin.css');
mix.sass('resources/scss/public.scss', 'assets/public/css/swift-certificate-manager-public.css');

mix.copy('resources/admin/images', 'assets/admin/images');
mix.copy('resources/public/images', 'assets/public/images');
mix.copy('resources/public/css/jquery-ui', 'assets/public/css/jquery-ui');
mix.copy('node_modules/element-ui/lib/theme-chalk/fonts', 'assets/admin/css/fonts');
mix.copy('node_modules/element-ui/lib/theme-chalk/fonts', 'assets/admin/fonts/vendor/element-ui/lib/theme-chalk');