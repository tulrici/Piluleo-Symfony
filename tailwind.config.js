/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./public/scripts/**/*.js",
  ],
  theme: {
    extend: {
      backgroundColor: {
        dark: "#000", // Adjust colors as needed
      },
    },
  },
  darkMode: "class", // Enabling class-based dark mode
  plugins: [require("daisyui")],
  daisyui: {
    themes: ["light", "dark"], // Predefined DaisyUI themes
  },
};