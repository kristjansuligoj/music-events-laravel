const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js') // JavaScript compilation
    .sass('resources/sass/app.scss', 'public/css') // Your custom Sass styles
    .options({
        processCssUrls: false,
        postCss: [require('tailwindcss')],
    })
    .styles([
        'node_modules/bootstrap/dist/css/bootstrap.min.css', // Bootstrap CSS
    ], 'public/css/vendor.css'); // Combined vendor CSS file
