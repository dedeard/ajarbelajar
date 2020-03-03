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
const config = {
   resolve: {
      alias: {
         'vars': path.resolve('resources/sass/remark/scss/_vars.scss'),
      }
   }
}

mix
   .webpackConfig(config)
   .js('resources/js/editor.js', 'public/js')
   .js('resources/js/video.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/admin.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

if (!mix.inProduction()) {
   mix.browserSync({ proxy: 'http://127.0.0.1:8000' });
} else {
   mix.version()
}