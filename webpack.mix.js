const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname + '/resources'
        }
    }
});


mix.js('resources/js/registration.js', 'public/js')
    //.js('resources/js/front.js', 'public/js')
   .sass('resources/sass/registration.scss', 'public/css')
    //.sass('resources/sass/front/works.scss', 'public/css')
   .browserSync('localhost:8000');

