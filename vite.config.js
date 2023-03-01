import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Forms/Components/**',
            ],
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "vendor/filament/filament/dist/app.css",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/app.css.map",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/app.js",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/app.js.map",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/echo.js",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/echo.js.map",
                    dest: "../assets",
                },
                {
                    src: "vendor/filament/filament/dist/mix-manifest.json",
                    dest: "../assets",
                },
            ],
        }),        
    ],
})
