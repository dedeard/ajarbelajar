const mix = require('laravel-mix');
const alias = { 'vars': path.resolve('resources/sass/remark/scss/_vars.scss') }

mix
   .webpackConfig({ resolve: { alias } })
   .js('resources/js/editor.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/admin.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/editor.scss', 'public/css')
   .sass('resources/sass/theme.scss', 'public/css')
   .disableNotifications()
   .options({ processCssUrls: false });

if (!mix.inProduction()) {
   mix.browserSync({ proxy: 'http://127.0.0.1:8000' });
} else {
   mix.version()
}