const mix = require('laravel-mix')

mix.js('resources/js/app.js', 'public/js')
mix.sass('resources/sass/app.scss', 'public/css')

mix.disableNotifications()

if (!mix.inProduction()) {
  mix.browserSync({
    proxy: 'http://admin.ab.com',
  })
} else {
  mix.version()
}
