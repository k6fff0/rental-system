import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true, // 🟢 مهم جدًا لعلاج مشكلة CORS
        hmr: {
            host: '10.0.0.2', // 🟢 لازم يكون مطابق لـ APP_URL بدون بورت
            protocol: 'ws',   // 🟢 بروتوكول WebSocket
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
