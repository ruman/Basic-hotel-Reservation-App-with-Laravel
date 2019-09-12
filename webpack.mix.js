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

mix.react('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.react('resources/js/admin/app.js', 'public/js/admin.js')
mix.react('resources/js/admin/calendar.js', 'public/js/admin/calendar.js')
	.scripts([
    'resources/js/admin/jquery.dataTables.min.js',
    'resources/js/admin/dataTables.bootstrap4.min.js',
    'resources/js/admin/jsrender.min.js',
    'resources/js/admin/popper.min.js'
], 'public/js/plugins.js')
	.sass('resources/sass/calendar.scss', 'public/css')
	.sass('resources/sass/admin.scss', 'public/css')
