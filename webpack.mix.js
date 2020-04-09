const mix = require('laravel-mix');

mix.webpackConfig({ resolve: { alias: { 'vars': path.resolve('resources/sass/theme/_vars.scss') } } })
   .js('resources/js/editor.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/admin.js', 'public/js')

if (!mix.inProduction()) {
   mix
      .sass('resources/sass/dev.scss', 'public/css/app.css')
      .sass('resources/sass/theme.scss', 'public/css')
      .disableNotifications()
      .options({ processCssUrls: false })
      .browserSync({ proxy: 'http://127.0.0.1:8000' });
} else {
   mix
      .sass('resources/sass/app.scss', 'public/css')
      .disableNotifications()
      .version()
}