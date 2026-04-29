const webpack = require('webpack');
const path = require('path');
// const { VueLoaderPlugin } = require('vue-loader'); // Import VueLoaderPlugin
let mix = require('laravel-mix');

mix.options({
    progressBar: false
});

mix.override((webpackConfig) => {
    webpackConfig.plugins = (webpackConfig.plugins || []).filter((plugin) => {
        return plugin?.constructor?.name !== 'WebpackBarPlugin';
    });
});

if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
     });
}

mix.setPublicPath('assets');
mix.setResourceRoot('../');
mix.webpackConfig({
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.mjs$/,
                loader: 'eslint-loader',
                exclude: /node_modules/
            }
        ]
    },
    output: {
        publicPath: Mix.isUsing('hmr') ? '/' : path.resolve(__dirname + '/../assets'),
        chunkFilename: 'admin/js/[name].js'
    },
    plugins: [
        // new VueLoaderPlugin(), // Add VueLoaderPlugin here
        new webpack.IgnorePlugin({
            resourceRegExp: /^\.\/locale$/,
            contextRegExp: /moment$/
        })
    ],
    resolve: {
        extensions: ['.*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'],
        alias: {
            '@Pieces': path.resolve(__dirname, 'resources/admin/Pieces'),
            '@': path.resolve(__dirname, 'resources/admin')
        }
    }

});

module.exports = mix;