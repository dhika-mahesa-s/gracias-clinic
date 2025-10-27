/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          background: "var(--background)",
          foreground: "var(--foreground)",
          primary: "var(--primary)",
          secondary: "var(--secondary)",
          accent: "var(--accent)",
          muted: "var(--muted)",
          border: "var(--border)",
        },
        borderRadius: {
          lg: "var(--radius-lg)",
          xl: "var(--radius-xl)",
        },
        boxShadow: {
          sm: "var(--shadow-sm)",
          md: "var(--shadow-md)",
          lg: "var(--shadow-lg)",
        },
        fontFamily: {
          sans: ["var(--font-sans)"],
          serif: ["var(--font-serif)"],
          mono: ["var(--font-mono)"],
        },
      },
    },
    darkMode: "class",
    plugins: [],
  }
  