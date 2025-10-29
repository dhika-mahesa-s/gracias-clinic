// tailwind.config.cjs
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    "./resources/**/*.blade.php", // WAJIB ADA
    "./resources/**/*.js",
    "./resources/**/*.vue", // Jika menggunakan Vue
  ],
  theme: {
    extend: {
      // Font Anda (jika diperlukan)
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        heading: ['Playfair Display', ...defaultTheme.fontFamily.serif], 
      },
    },
  },
  plugins: [],
}