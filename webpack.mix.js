const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

//mix.minify(['resources/js/drawerJs.standalone.js',]);
mix.scripts(['resources/js/drawerJs.standalone.min.js',],'public/js/drawerJs.js');
mix.styles(['resources/css/drawerJs.min.css',],'public/css/drawerJs.css');
