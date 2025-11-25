<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') - {{ getsetting('site_name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ getSetting('favicon') }}" rel="shortcut icon">
        <link href="{{ asset('assets/vendor/boxicons/fonts/basic/boxicons.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendor/boxicons/fonts/brands/boxicons-brands.min.css') }}" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Montserrat:wght@400;500;700&display=swap"
              rel="stylesheet">

        @stack('meta')

        @vite(['Modules/Front/Resources/assets/css/app.css', 'Modules/Front/Resources/assets/js/app.js', 'Modules/Front/Resources/assets/js/theme.js'])

        @livewireStyles
        @stack('style')
    </head>

    <body class="relative bg-neutral-50 text-neutral-800">
        <main class="content relative flex flex-col items-center justify-center overflow-hidden" id="content">
            <div class="top-30 w-50 h-50 absolute right-80 z-0 rounded-full bg-[#E2D4B0] blur-3xl"></div>
            <div class="w-50 h-50 absolute bottom-20 left-10 z-0 rounded-full bg-[#E8DDC0] blur-3xl"></div>

            <section class="relative w-full overflow-hidden py-24">
                <div class="container">
                    <div class="mx-auto max-w-screen-xl">
                        <div class="mx-auto max-w-screen-sm text-center">
                            @yield('content')
                            <a class="btn soft-primary" href="{{ route('front.index') }}" wire:navigate>
                                <i class="bx bx-chevron-left"></i> {{ __('front::global.go_home') }}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <livewire:front::ui.partials.footer />
    </body>

</html>
