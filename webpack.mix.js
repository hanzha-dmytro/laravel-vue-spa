const mix = require('laravel-mix');
const webpackConfig = require('./webpack.config')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Configure webpack
mix.webpackConfig(webpackConfig)

mix.js('resources/js/app.js', 'public/js').vue()

// Use version
mix.version();
