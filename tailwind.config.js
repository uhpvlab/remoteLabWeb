/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require("tailwindcss/plugin");
const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    './assets/**/*.html',
    './assets/**/*.vue',
    './assets/**/*.jsx',
    './templates/**/*.html',
    './templates/**/*.twig',
    'node_modules/vue-tailwind/dist/*.js',
    './node_modules/tw-elements/dist/js/**/*.js'
  ],

  darkMode: 'media', // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
      },
      spacing: {
        '7': '1.75rem',
        '9': '2.25rem',
        '28': '7rem',
        '80': '20rem',
        '96': '24rem',
      },
      height: {
        '1/2': '50%',
      },
      scale: {
        '30': '.3',
        '105': '1.05',
      },
      boxShadow: {
        outline: '0 0 0 3px rgba(101, 31, 255, 0.4)',
      },
      keyframes: {

        heartbeat: {

          '0%, 100%': {
            transform: 'scale(1)',
            'transform-origin': 'center center',
            'animation-timing-function': 'ease-out'
          },
          '10%': {
            transform: 'scale(0.91)',
            'animation-timing-function': 'ease-in'
          },
          '17%': {
            transform: 'scale(0.98)',
            'animation-timing-function': 'ease-out'
          },
          '33%': {
            transform: 'scale(0.87)',
            'animation-timing-function': 'ease-in'
          },
          '45%': {
            transform: 'scale(1)',
            'animation-timing-function': 'ease-out'
          }
        }
      },
      animation: {
        heartbeat: 'heartbeat 2.5s ease-in-out infinite both',
      },
      blur: {
        xs: '2px',
      },
      backgroundSize: {
        full: "100%",
      },
      fontSize: {
        '6xl': '4rem',
        '7xl': '5rem',
        55: "55rem",
      },
    },
    colors: {
      extend: {},
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.stone,
      blue: colors.sky,
      red: colors.red,
      yellow: colors.amber,
      pink: colors.pink,
      green: colors.lime,
      orange: colors.orange,
      primary: colors.sky["700"],
      teal: colors.teal,
      indigo: colors.indigo,
      accent: colors.indigo["700"],
      slate: colors.slate,
      emerald: colors.emerald,
      violet: colors.violet,
      purple: colors.purple
    },
  },
  variants: {
    scale: ['responsive', 'hover', 'focus', 'group-hover'],
    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    opacity: ['responsive', 'hover', 'focus', 'group-hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('tw-elements/dist/plugin')
  ],
}
