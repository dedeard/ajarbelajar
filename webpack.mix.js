const mix = require("laravel-mix")

/* Allow multiple Laravel Mix applications*/
require("laravel-mix-merge-manifest")
mix.mergeManifest()

const webpackConfig = {
    resolve: {
        alias: {
            vars: path.resolve("resources/sass/_vars.scss")
        }
    }
}

mix.webpackConfig(webpackConfig)
mix.js("resources/js/app.js", "public/js")
mix.js("resources/js/public.js", "public/js")
mix.js("resources/js/auth.js", "public/js")
mix.js("resources/js/admin.js", "public/js")
mix.js("resources/js/minitutor.js", "public/js")

mix.sass("resources/sass/app.scss", "public/css/app.css")
mix.sass("resources/sass/modules/public/public.scss", "public/css/public.css")
mix.sass("resources/sass/modules/auth/auth.scss", "public/css/auth.css")
mix.sass("resources/sass/modules/admin/admin.scss", "public/css/admin.css")
mix.sass("resources/sass/modules/minitutor/minitutor.scss", "public/css/minitutor.css")

mix.disableNotifications()
mix.options({
    processCssUrls: false
})

if (!mix.inProduction()) {
    mix.browserSync({
        proxy: "http://127.0.0.1:8000"
    })
} else {
    mix.version()
}
