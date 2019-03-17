var elixir = require('laravel-elixir');

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

elixir(function(mix) {
    mix.styles([
    	'bootstrap.min.css',
    	'font-awesome.min.css',
    	'ionicons.min.css',
    	'dataTables.bootstrap.css',
    	'AdminLTE.min.css',
    	'_all-skins.min.css',
        'all.css',
        '_all.css',
        'datepicker3.css',
        'select2.min.css'

    	],'public/css/admin.css');

    mix.scripts([
    		'jquery-2.2.3.min.js',
    		'bootstrap.min.js',
    		'jquery.dataTables.min.js',
    		'dataTables.bootstrap.min.js',
    		'jquery.slimscroll.min.js',
    		'fastclick.min.js',
    		'app.min.js',
    		'demo.js',
            'select2.full.min.js',
            'bootstrap-datepicker.js',
            'icheck.min.js',
            'scripts.js'

    	],'public/js/admin.js');

    mix.styles([
        '/front/animate.min.css',
        '/front/bootstrap.min.css',
        '/front/font-awesome.min.css',
        '/front/owl.carousel.css',
        '/front/owl.theme.css',
        '/front/owl.transitions.css',
        '/front/responsive.css',
        '/front/style.css'

        ],'public/css/front.css');

    mix.scripts([
            'jquery-2.2.3.min.js',
            '/front/bootstrap.min.js',
            '/front/jquery.stickit.min.js',
            '/front/map.js',
            '/front/menu.js',
            '/front/owl.carousel.min.js',
            '/front/scripts.js'

        ],'public/js/front.js');
    mix.copy('resources/assets/admin/dist/img', 'public/img');
    mix.copy('resources/assets/front/fonts', 'public/fonts');
    mix.copy('resources/assets/front/images', 'public/images');
});
