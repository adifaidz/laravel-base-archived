const elixir = require('laravel-elixir');

require('laravel-elixir-replace');
require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
var replacements = [
   ['url(blue.png)', 'url(/iCheck/blue.png)'],
];

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');

    mix.copy('./node_modules/font-awesome/fonts/', 'public/fonts/');
    mix.copy('./node_modules/admin-lte/bootstrap/fonts', 'public/fonts/bootstrap');
    mix.copy('./node_modules/admin-lte/plugins/iCheck/square/blue.png', 'public/css/iCheck/blue.png');
    mix.replace('public/css/app.js', replacements);

});
