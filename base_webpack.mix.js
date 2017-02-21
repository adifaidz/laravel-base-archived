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
var replacements = [
  ['url(blue.png)', 'url(/iCheck/blue.png)'],
];
mix.options({ processCssUrls: false });

mix.webpackConfig({
    resolve: {
      alias: {
        jquery: path.join(__dirname, 'node_modules/jquery/src/jquery')
      },
    },
    module: {
      rules: [],
      loaders: [
        {
          test: /\.css$/,
          loaders: ['string-replace'],
          query: {
            multiple: [
               { search: 'url(blue.png)', replace: 'url(/iCheck/blue.png)' }
            ]
          }
        }
      ]
    }
});

mix.copy('node_modules/font-awesome/fonts/', 'public/fonts/');
mix.copy('node_modules/admin-lte/bootstrap/fonts', 'public/fonts/bootstrap');
mix.copy('node_modules/admin-lte/plugins/iCheck/square/blue.png', 'public/css/iCheck/blue.png');
