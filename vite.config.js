import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/scss/guest.scss', 'resources/js/guest.js','resources/js/globaldatatable.js', 'resources/js/users.js', 'resources/js/invoice.js'],
            refresh: true,
        }),
    ],
});
