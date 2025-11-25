<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') - {{ getsetting('site_name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link href="{{ getsetting('favicon') }}" rel="shortcut icon">

        <link href="{{ asset('assets/vendor/boxicons/fonts/basic/boxicons.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendor/boxicons/fonts/brands/boxicons-brands.min.css') }}" rel="stylesheet" />

        @vite(['Modules/Front/Resources/assets/css/app.css', 'Modules/Front/Resources/assets/js/app.js', 'Modules/Front/Resources/assets/js/theme.js', 'node_modules/toastify-js/src/toastify.css'])

        @livewireStyles
        @stack('style')
    </head>

    <body class="bg-white text-gray-800 antialiased">

        <div class="grid min-h-screen grid-cols-1 lg:grid-cols-3">
            {{-- Left: Login Form --}}
            <div class="col-span-1 flex items-center justify-center px-4 py-8 sm:px-6 lg:px-16">
                <div class="w-full max-w-md space-y-6">

                    {{-- Logo --}}
                    <div>
                        <a href="{{ route('front.index') }}">
                            <img class="mb-8 h-20" src="{{ getSetting('logo_gray') }}" alt="Logo">
                        </a>
                    </div>

                    {{-- Login Form --}}
                    @yield('content')
                </div>
            </div>

            {{-- Right: Image with Overlay and Centered Content --}}
            <div class="relative col-span-2 hidden h-full items-center justify-center lg:flex">
                <img class="absolute inset-0 h-full w-full object-cover"
                     src="{{ asset('assets/images/auth/auth_image.png') }}" alt="Login Visual" />
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="relative z-10 flex h-full w-full flex-col items-center justify-center">
                    {{-- You can add centered content here if needed --}}
                </div>
            </div>
        </div>

        @livewireScripts
        @stack('script')
    </body>

</html>
