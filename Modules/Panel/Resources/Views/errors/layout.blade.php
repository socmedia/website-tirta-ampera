<!DOCTYPE html>
<html data-sidenav-view="default" lang="en">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link href="{{ getsetting('favicon') }}" rel="shortcut icon">

        <link href="{{ asset('assets/panel/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/panel/css/icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/panel/css/plugins.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/panel/vendor/animate.compat.css') }}" rel="stylesheet">
        <link type="text/css" href="https://cdn.jsdelivr.net/npm/node-snackbar@latest/dist/snackbar.min.css"
              rel="stylesheet" />


        <script src="{{ asset('assets/panel/js/config.js') }}"></script>
        <script src="{{ asset('assets/panel/js/head.js') }}"></script>

        @livewireStyles
        @stack('style')

    </head>

    <body>
        <div class="wrapper flex">
            <div class="page-content">
                <main class="flex-grow p-6">
                    <section class="relative bg-gradient-to-t from-slate-50 to-white pb-24">
                        <div class="container">
                            <div class="mx-auto max-w-screen-xl">
                                <div class="mx-auto max-w-screen-sm pb-16 text-center">
                                    @yield('image')

                                    <h1 class="mb-4 text-3xl font-extrabold tracking-tight text-primary lg:text-5xl">
                                        @yield('error_code')
                                    </h1>
                                    <p class="mb-4 text-lg font-light text-slate-500">
                                        @yield('error_message')
                                    </p>
                                    <a class="btn primary inline-flex items-center gap-1" href="{{ url('/') }}">
                                        <i class="bx bx-left-arrow-alt"></i> Kembali ke halaman utama
                                    </a>
                                </div>
                            </div>

                        </div>
                    </section>
                </main>

                <x-panel::utils.footer />
            </div>
        </div>

        <x-panel::utils.customizer />

        @livewireScripts
        <script defer src="{{ asset('assets/panel/js/app.js') }}"></script>
        <script defer src="{{ asset('assets/panel/js/main.js') }}"></script>

        @stack('script')
    </body>


</html>
