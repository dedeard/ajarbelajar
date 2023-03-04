import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/fonts/feather/feather.css',
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/main.js',
      ],
      refresh: true,
    }),
  ],
})
