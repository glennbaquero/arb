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

/* Directory shortcuts */
mix.webpackConfig({
	resolve: {
		alias: {
			assets: path.resolve(__dirname, 'public/'),
			Mixins: path.resolve(__dirname, 'resources/js/mixins'),
			Components: path.resolve(__dirname, 'resources/js/components'),
			Views: path.resolve(__dirname, 'resources/js/views'),
			Root: path.resolve(__dirname, 'resources/js'),
		}
	}
});

if (!mix.inProduction()) {
    mix.sourceMaps();
}

mix.sass('resources/sass/app.scss', 'public/assets/admin/app.css');
mix.sass('resources/sass/vendor.scss', 'public/assets/admin/vendor.css');

mix.sass('resources/sass/guest/app.scss', 'public/assets/guest/app.css');
mix.sass('resources/sass/guest/vendor.scss', 'public/assets/guest/vendor.css');

// Keep at the bottom
mix.js('resources/js/app.js', 'public/assets/app.js')
.extract([
	'vue', 'vuejs-dialog', 'axios', 'jquery',
	'@fortawesome/fontawesome-free', 
	'toastr', 
	'bootstrap', 'bootstrap-daterangepicker', 'admin-lte', 
	'flatpickr', 'selectize', 'vue-template-compiler', 'vue2-selectize',
	'chart.js', 'swiper',
	'moment',
]);

mix.version();
mix.disableNotifications();