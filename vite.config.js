import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/header.css',
                'resources/css/slider.css',
                'resources/css/portfolio-main.css',
                'resources/css/constructor-main.css',
                'resources/css/review-main.css',
                'resources/js/app.js',
                'resources/css/contacts-main.css',
                'resources/css/footer.css',
                'resources/css/constructor-page.css',
                'resources/css/about-us.css',
                'resources/css/profile.css',
            ],
            refresh: true,
        }),
    ],
});
