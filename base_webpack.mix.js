const { mix } = require('laravel-mix');
const path = require('path');
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

mix.webpackConfig({
    resolve: {
      alias: {
        jquery: path.join(__dirname, 'node_modules/jquery/src/jquery')
      },
    },
});

mix.copy('resources/assets/images/','public/images');
mix.copy('node_modules/font-awesome/fonts/', 'public/fonts/font-awesome');
mix.copy('node_modules/admin-lte/bootstrap/fonts', 'public/fonts/bootstrap');
