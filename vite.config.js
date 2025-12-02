import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "node_modules/boxicons/css/boxicons.min.css",
                "node_modules/toastify-js/src/toastify.css",
                "node_modules/@yaireo/tagify/dist/tagify.css",
                "node_modules/@dasundev/livewire-dropzone-styles/dist/styles.css",

                // Front
                "Modules/Front/Resources/assets/css/app.css",
                "Modules/Front/Resources/assets/js/app.js",
                "Modules/Front/Resources/assets/js/theme.js",
                "Modules/Front/Resources/assets/js/cropper.js",
                "Modules/Front/Resources/assets/js/swiper.js",
                "Modules/Front/Resources/assets/js/libphonenumber.js",
                "Modules/Front/Resources/assets/js/form.js",

                // Panel
                "Modules/Panel/Resources/assets/css/app.css",
                "Modules/Panel/Resources/assets/js/app.js",
                "Modules/Panel/Resources/assets/js/theme.js",
                "Modules/Panel/Resources/assets/js/cropper.js",
                "Modules/Panel/Resources/assets/js/tagify.js",
                "Modules/Panel/Resources/assets/js/editor.js",
                "Modules/Panel/Resources/assets/js/markdown.js",
                "Modules/Panel/Resources/assets/js/daterangepicker.js",
                "Modules/Panel/Resources/assets/js/chart.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
    resolve: {
        alias: {
            "@vendor": path.resolve(__dirname, "vendor"),
            "@front": path.resolve(__dirname, "Modules/Front/Resources/assets"),
            "@panel": path.resolve(__dirname, "Modules/Panel/Resources/assets"),
        },
    },
});
