<!DOCTYPE html>
<html x-data x-init="$store.ui.init()" :class="{ 'dark': $store.ui.dark }"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') - {{ getsetting('site_name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link href="{{ getsetting('favicon') }}" rel="shortcut icon">

        <link href="{{ asset('assets/vendor/boxicons/fonts/basic/boxicons.min.css') }}" rel="stylesheet" />

        @vite(['Modules/Panel/Resources/assets/css/app.css', 'Modules/Panel/Resources/assets/js/app.js', 'Modules/Panel/Resources/assets/js/theme.js', 'node_modules/toastify-js/src/toastify.css'])

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        @livewireStyles
        @stack('style')
    </head>

    <body class="bg-gradient-to-b from-white to-zinc-100 antialiased dark:from-zinc-900 dark:to-zinc-800">
        <div class="relative flex h-screen items-center justify-center">
            <button class="absolute right-4 top-4 flex items-center justify-center rounded-full p-1.5 text-gray-500 hover:text-gray-900 focus:ring-4 focus:ring-zinc-300 dark:text-gray-400 dark:hover:text-white dark:focus:ring-zinc-600"
                    type="button" x-on:click="$store.ui.toggleTheme()">
                <i class="text-xl" :class="$store.ui.dark ? 'bx bx-moon' : 'bx bx-sun'"></i>
            </button>
            <div class="flex flex-col">
                <div>
                    <img class="mx-auto mb-8 h-28 dark:hidden" src="{{ getSetting('logo_gray') }}" alt="Logo">
                    <img class="mx-auto mb-8 hidden h-28 dark:block" src="{{ getSetting('logo_silver') }}"
                         alt="Logo">
                </div>
                <div
                     class="w-sm rounded-xl border border-gray-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900 sm:p-8">
                    @yield('content')
                </div>

                <footer class="mt-auto py-3 text-center">
                    <div class="mx-auto max-w-[85rem] pb-3 pt-6">
                        <p class="text-xs text-zinc-600 dark:text-zinc-300">{{ getSetting('copyright') }}</p>
                    </div>
                </footer>
            </div>
        </div>

        @livewireScripts
        @stack('script')
    </body>

</html>
