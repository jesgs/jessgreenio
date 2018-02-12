let mix = require('laravel-mix');
mix.webpackConfig({ devtool: "source-map" });
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/scripts/main.js', 'public/assets/scripts')
   .sass('resources/assets/styles/scss/screen.scss', 'public/assets/styles')
   .sass('resources/assets/styles/scss/print.scss', 'public/assets/styles').sourceMaps();

mix.copy('resources/assets/images/html/*', 'public/images');