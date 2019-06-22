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

mix.scripts([
    'resources/js/admin/jquery.min.js',
    'resources/js/admin/bootstrap.min.js',
    'resources/js/admin/jquery.dataTables.min.js',
    'resources/js/admin/dataTables.bootstrap4.min.js',
    'resources/js/admin/app.js',
], 'public/js/admin.js')
	.scripts([
		'resources/js/admin/jsrender.min.js'
], 'public/js/plugins.js')
	.sass('resources/sass/admin.scss', 'public/css')
