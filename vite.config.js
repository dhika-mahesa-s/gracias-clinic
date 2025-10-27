// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Pastikan ini .css
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // PASTIKAN BLOK 'css: { postcss: {...} }' DIHAPUS JIKA ADA
});