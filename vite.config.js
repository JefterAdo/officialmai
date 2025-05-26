import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: [
                'resources/views/**',
                'app/Http/Controllers/**',
                'routes/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '~': path.resolve('node_modules'),
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        include: ['alpinejs'],
    },
});
