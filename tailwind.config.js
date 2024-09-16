/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./public/scripts/**/*.js",
 
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
   
  ],
  daisyui: {
    themes: [ "dark","light",]
  },
 darkMode: 'class',
}

