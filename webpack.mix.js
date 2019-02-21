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
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/gijgo/js/gijgo.min.js'
    ], 'public/js/third.js')
    .styles([
        'node_modules/gijgo/css/gijgo.min.css'
    ], 'public/css/third.css')
    .minify(['public/css/third.css','public/js/third.js']);
