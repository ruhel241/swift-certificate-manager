const mix = require('laravel-mix');

mix.js('resources/admin/boot.js', 'assets/admin/js').vue({ version: 2 });
mix.js('resources/admin/start.js', 'assets/admin/js/start.js').vue({ version: 2 });

// SCSS
mix.sass('resources/scss/admin.scss', 'assets/admin/css/swifcema-admin.css');
mix.sass('resources/scss/public.scss', 'assets/public/css/swifcema-public.css');

// Assets copy
mix.copy('resources/admin/images', 'assets/admin/images');

mix.copy(
    'node_modules/element-ui/lib/theme-chalk/fonts',
    'assets/admin/css/fonts'
);