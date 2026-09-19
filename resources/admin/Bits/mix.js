const webpack = require('webpack');
const path = require('path');
let mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');

module.exports = mix;