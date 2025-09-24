import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '26.64.107.18',
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
