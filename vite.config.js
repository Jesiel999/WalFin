import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '192.168.1.77',
        port: 5173,
        cors: true       
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/acesso.js',
            ],
            refresh: true,
        }),
    ],
});
