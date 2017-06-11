const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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
    mix.sass('app.scss','public/assets/css')
    .webpack('app.js','public/assets/js')
    .browserSync({
        proxy: 'regym.com'
    }).scripts([
        'components/modernizr.min.js',
        'components/jquery.min.js',
        'components/bootstrap.min.js',
        'components/detect.js',
        'components/fastclick.js',
        'components/jquery.slimscroll.js',
        'components/jquery.blockUI.js',
        'components/waves.js',
        'components/wow.min.js',
        'components/jquery.nicescroll.js',
        'components/jquery.scrollTo.min.js',

        'components/plugins/peity/jquery.peity.min.js',
        'components/plugins/waypoints/lib/jquery.waypoints.js',
        'components/plugins/counterup/jquery.counterup.min.js',
        'components/plugins/morris/morris.min.js',
        'components/plugins/raphael/raphael-min.js',
        'components/plugins/jquery-knob/jquery.knob.js',
        'components/plugins/notifyjs/dist/notify.min.js',
        'components/plugins/notifications/notify-metro.js',
        
        'components/plugins/moment/moment.js',

        'components/plugins/sweetalert/dist/sweetalert.min.js',

        'components/plugins/flot-chart/jquery.flot.js',
        'components/plugins/flot-chart/jquery.flot.time.js',
        'components/plugins/flot-chart/jquery.flot.tooltip.min.js',
        'components/plugins/flot-chart/jquery.flot.resize.js',
        'components/plugins/flot-chart/jquery.flot.pie.js',
        'components/plugins/flot-chart/jquery.flot.selection.js',
        'components/plugins/flot-chart/jquery.flot.stack.js',
        'components/plugins/flot-chart/jquery.flot.orderBars.min.js',
        'components/plugins/flot-chart/jquery.flot.crosshair.js',

        'components/plugins/select2/select2.min.js',
        'components/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'components/plugins/summernote/dist/summernote.min.js',
        'components/plugins/bootstrap-daterangepicker/daterangepicker.js',
        
        'components/jquery.core.js',
        'components/jquery.app.js',
    ],'public/assets/js/component.js');
});