/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // Ini memberitahu Tailwind untuk memindai semua file Blade (.blade.php) 
    // di dalam folder 'resources/views' dan juga file JS/Vue.
    "./resources//*.blade.php", 
    "./resources//*.js",
    "./resources//*.vue", 
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}