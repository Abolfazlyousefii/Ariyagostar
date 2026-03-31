const mix = require('laravel-mix');

mix.setPublicPath('src/resources/assets/');
const path = __dirname + '/src/resources';

mix.styles(
    [
        path + '/assets/css/vendor/bootstrap.min.css',
        path + '/assets/css/vendor/bootstrap-rtl.min.css',
        path + '/assets/css/vendor/owl.carousel.min.css',
        path + '/assets/css/vendor/jquery.horizontalmenu.css',
        path + '/assets/js/plugins/toastr/toastr.css',
        path + '/assets/css/main.css',
        path + '/assets/css/styles.css',
        path + '/assets/css/custom.css'
    ],
    path + '/assets/css/all.css'
).version();

mix.babel(
    [
        path + '/assets/js/vendor/jquery-3.4.1.min.js',
        path + '/assets/js/vendor/popper.min.js',
        path + '/assets/js/vendor/bootstrap.min.js',
        path + '/assets/js/vendor/owl.carousel.min.js',
        path + '/assets/js/vendor/jquery.horizontalmenu.js',
        path + '/assets/js/vendor/theia-sticky-sidebar.min.js',
        path + '/assets/js/vendor/jquery.lazyloadxt.min.js',
        path + '/assets/js/plugins/jquery.blockUI.js',
        path + '/assets/js/plugins/sweetalert2.all.min.js',
        path + '/assets/js/plugins/toastr/toastr.min.js',
        path + '/assets/js/main.js',
        path + '/assets/js/custom.js',
        path + '/assets/js/scripts.js'
    ],
    path + '/assets/js/all.js'
).version();
