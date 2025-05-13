import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',       // يفتح الاتصال من أي IP
        port: 5173,            // أو أي بورت متاح
        hmr: {
            host: '10.0.0.2',  // ← هنا تكتب IP الجهاز اللي عليه Laravel
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
