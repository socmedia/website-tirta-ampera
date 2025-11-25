<!DOCTYPE html>
<html x-data x-init="$store.ui.init()" :class="{ 'dark': $store.ui.dark }"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') - {{ getsetting('site_name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ getsetting('favicon') }}" rel="shortcut icon">
        <link href="{{ asset('assets/vendor/boxicons/fonts/basic/boxicons.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendor/boxicons/fonts/brands/boxicons-brands.min.css') }}" rel="stylesheet" />

        @vite(['Modules/Panel/Resources/assets/css/app.css', 'Modules/Panel/Resources/assets/js/app.js', 'Modules/Panel/Resources/assets/js/theme.js', 'node_modules/toastify-js/src/toastify.css'])

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        <!--Start of Tawk.to Script-->
        {{-- <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/6841375cae7c77190c9a844b/1isve9k9j';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script> --}}
        <!--End of Tawk.to Script-->
        @livewireStyles
        @stack('style')
    </head>

    <body class="bg-zinc-50 text-black dark:bg-zinc-800 dark:text-white">
        <x-panel::partials.sidebar />

        <main class="content" id="content" :class="{ 'sidebar-open': $store.ui.sidebarOpen }">
            <x-panel::partials.header />

            <livewire:panel::ui.announcement.verify-email :user="auth('web')->user()" />

            @yield('breadcrumb')

            <div class="container p-4 lg:p-8">
                @yield('content')
            </div>

            <footer class="mt-auto py-3">
                <div class="container border-t border-zinc-100 px-4 pb-3 pt-6 dark:border-zinc-700 lg:px-8">
                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ getSetting('copyright') }}</p>
                </div>
            </footer>
        </main>

        @livewireScripts
        @stack('script')
    </body>

</html>
