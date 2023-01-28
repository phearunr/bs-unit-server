let mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/assets/js/'),
            snapsvg: 'snapsvg/dist/snap.svg.js'
        }
    },
    module: {
    	rules: [
	    	{
	    		test: require.resolve('snapsvg/dist/snap.svg.js'),
	    		use: 'imports-loader?this=>window,fix=>module.exports=0',
	    	},
    	],
    },
});

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([	
	'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
	'node_modules/flag-icon-css/css/flag-icon.css',
	'node_modules/select2/dist/css/select2.css',	
	'node_modules/select2-bootstrap4-theme/dist/select2-bootstrap4.css',
	'node_modules/summernote/dist/summernote.css',
	'node_modules/summernote/dist/summernote-bs4.css',
	'node_modules/sweetalert2/dist/sweetalert2.min.css',
	'resources/assets/css/loader.css',
	'resources/assets/css/custom.css'
],'public/css/custom.css');

mix.copy('node_modules/flickity/dist/flickity.min.css', 'public/css/flickity.min.css');
mix.copy('node_modules/flickity/dist/flickity.pkgd.min.js', 'public/js/flickity.pkgd.min.js');

mix.copy('resources/assets/css/contract_print.css','public/css/contract_print.css');
mix.copy('resources/assets/css/contract_print_v2.css','public/css/contract_print_v2.css');
// mix.styles([	
// 	'node_modules/bootstap/dist/css/bootstrap-reboot.css',
// 	'resources/assets/css/post.css'
// ], 'public/css/post.css');

mix.copy('node_modules/summernote/dist/font/summernote.eot','public/css/font/summernote.eot');
mix.copy('node_modules/summernote/dist/font/summernote.ttf','public/css/font/summernote.ttf');
mix.copy('node_modules/summernote/dist/font/summernote.woff','public/css/font/summernote.woff');
mix.copy('node_modules/flag-icon-css/flags','public/flags');

mix.babel([
'resources/assets/js/jquery.number.min.js',
	'node_modules/inputmask/dist/jquery.inputmask.bundle.js',
	'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',	
	'node_modules/select2/dist/js/select2.js',	
	'node_modules/summernote/dist/summernote-bs4.js',
	'node_modules/sweetalert2/dist/sweetalert2.min.js',
	'resources/assets/js/custom.js',	
	'resources/assets/js/contract-schedule.js'
],'public/js/util.js');

if (mix.inProduction()) {
    mix.version();
}