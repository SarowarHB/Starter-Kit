import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel([
            'resources/js/app.js',

            //Admin Main
            'resources/admin_assets/sass/app.scss',
            'resources/admin_assets/js/app.js',
            //Admin Chunks

            // Asset
            'resources/admin_assets/js/pages/asset/index.js',
            'resources/admin_assets/js/pages/asset/create.js',
            'resources/admin_assets/js/pages/asset/sale/index.js',

            // Blog
            'resources/admin_assets/js/pages/blog/index.js',
            'resources/admin_assets/js/pages/blog/create.js',

            // Config
            'resources/admin_assets/js/pages/config/dropdown/index.js',
            'resources/admin_assets/js/pages/config/email/index.js',
            'resources/admin_assets/js/pages/config/email_template/index.js',
            'resources/admin_assets/js/pages/config/email_template/update.js',
            'resources/admin_assets/js/pages/config/role/index.js',
            'resources/admin_assets/js/pages/config/dropdown/list.js',

            // Employee
            'resources/admin_assets/js/pages/employee/index.js',

            // Event
            'resources/admin_assets/js/pages/event/index.js',
            'resources/admin_assets/js/pages/event/create.js',

            // Expense
            'resources/admin_assets/js/pages/expense/index.js',
            'resources/admin_assets/js/pages/expense/create.js',
            'resources/admin_assets/js/pages/expense/salary/index.js',
            'resources/admin_assets/js/pages/expense/salary/create.js',

            // FAQ
            'resources/admin_assets/js/pages/faq/index.js',

            // Logs
            'resources/admin_assets/js/pages/logs/activity_log.js',
            'resources/admin_assets/js/pages/logs/login_history.js',
            'resources/admin_assets/js/pages/logs/email_history.js',

            // Member
            'resources/admin_assets/js/pages/member/index.js',

            // Notifications
            'resources/admin_assets/js/pages/notification/index.js',
            'resources/admin_assets/js/pages/notification/create.js',

            // Tickets
            'resources/admin_assets/js/pages/ticket/index.js',
            'resources/admin_assets/js/pages/ticket/create.js',
            'resources/admin_assets/js/pages/ticket/show.js',

            // AMS
            'resources/admin_assets/js/pages/ams/category_type/index.js',
            'resources/admin_assets/js/pages/ams/category/index.js',
            'resources/admin_assets/js/pages/ams/supplier/index.js',
            'resources/admin_assets/js/pages/ams/product/create.js',
            'resources/admin_assets/js/pages/ams/product/index.js',
            'resources/admin_assets/js/pages/ams/stock/index.js',
            'resources/admin_assets/js/pages/ams/stock/create.js',
            'resources/admin_assets/js/pages/ams/stock/edit.js',
        ]),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@': '/resources/js',
        }
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (asset) => {
                    let typePath = 'styles'
                    const type = asset.name.split('.').at(1)
                    if (/png|jpe?g|webp|svg|gif|tiff|bmp|ico/i.test(type)) {
                        typePath = 'images'
                    }
                    return `${typePath}/[name]-[hash][extname]`
                },
                chunkFileNames: 'scripts/chunks/[name]-[hash].js',
                entryFileNames: 'scripts/[name]-[hash].js',
            },
        },
    },
});
