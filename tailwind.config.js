const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    container: {
      center: true,
    },
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.gray,
      red: colors.red,
      yellow: colors.yellow,
      primary: colors.blue,
    },
    fill: (theme) => ({
      current: 'currentColor',
      black: theme('colors.black'),
      white: theme('colors.white'),
      primary: theme('colors.primary'),
      red: theme('colors.red'),
      gray: theme('colors.gray'),
    }),
    stroke: (theme) => ({
      current: 'currentColor',
      black: theme('colors.black'),
      white: theme('colors.white'),
      primary: theme('colors.primary'),
      red: theme('colors.red'),
      gray: theme('colors.gray'),
    }),
    extend: {
      transitionProperty: {
        spacing: 'margin, padding',
      },
      fontSize: {
        '2xs': '0.625rem',
      },
      fontFamily: {
        sans: ['Roboto', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {
    extend: {
      opacity: ['disabled'],
      cursor: ['disabled'],
      borderWidth: ['first'],
    },
  },

  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
