let mix = require('laravel-mix');

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

mix
	.js('resources/assets/js/app.js', 'public/js')
	// .js('resources/assets/js/ucwords/ucwords.js', 'public/js/ucwords.js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.combine([
		'public/css/app.css',
		'resources/assets/js/bootstrapValidator4/css/bootstrapValidator.css',
		'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
		'node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
		'node_modules/datatables.net-colreorder-bs4/css/colReorder.bootstrap4.css',
		'node_modules/@claviska/jquery-minicolors/jquery.minicolors.css',
		'node_modules/fullcalendar/dist/fullcalendar.css',
		// 'node_modules/select2-bootstrap4-theme/dist/select2-bootstrap4.css',
		'node_modules/animate.css/animate.css',
		'node_modules/jarallax/dist/jarallax.css',
		'resources/assets/js/jquery-ui/css/jquery-ui.css',
		'resources/assets/js/jquery-ui/css/jquery-ui.structure.css',
		'resources/assets/js/jquery-ui/css/jquery-ui.themes.css',
		'resources/assets/sass/animate/animate.css',
		], 'public/css/app.css')
	// .setPublicPath('public/assets')
	.sourceMaps()
	// .autoload({
	// 	jquery: ['$', 'window.jQuery', 'jQuery'],
	// })
	// .webpackConfig({
	// 	resolve: {
	// 		alias: {
	// 			jquery: "jquery/dist/jquery"
	// 		}
	// 	}
	// })
    ;