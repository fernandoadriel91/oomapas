const mix = require('laravel-mix');
require(`${__dirname}/config.mix.js`);

mix
    .sass('resources/sass/app.scss', 'public/css')
    .scripts('resources/js/app.js', 'public/js/app.js')
    .scripts('resources/js/login.js', 'public/js/login.js')
    .scripts('resources/js/password.js', 'public/js/password.js');


//mix.browserSync('template.test');
if (mix.inProduction()) {
    mix.version();
}