<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ getSetting('favicon') }}" rel="shortcut icon">
        <link href="{{ asset('assets/vendor/boxicons/fonts/basic/boxicons.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendor/boxicons/fonts/brands/boxicons-brands.min.css') }}" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Montserrat:wght@400;500;700&display=swap"
              rel="stylesheet">

        @stack('meta')

        @vite(['Modules/Front/Resources/assets/css/app.css', 'Modules/Front/Resources/assets/js/app.js', 'Modules/Front/Resources/assets/js/theme.js', 'node_modules/toastify-js/src/toastify.css'])

        @livewireStyles
        @stack('style')

        @php
            $facebookPixelId = getSetting('integration_facebook_pixel');
            $googleTagManagerId = getSetting('integration_google_tag_manager');
            $googleAnalyticsId = getSetting('integration_google_analytics');
        @endphp

        <script type="text/javascript">
            (function() {
                window.trackingIds = {
                    facebookPixelId: @json($facebookPixelId),
                    googleAnalyticsId: @json($googleAnalyticsId),
                    googleTagManagerId: @json($googleTagManagerId),
                };
            })()
        </script>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>

    <body class="relative text-neutral-800" x-data x-init="$store.ui.init();
    $store.cookieConsent.init()">

        <div id="gtm-noscript-placeholder"></div>

        {{-- Sticky Navbar --}}
        @if (request()->routeIs('front.index'))
            <livewire:front::ui.partials.navbar />
        @else
            <livewire:front::ui.partials.navbar :always-fixed="true" />
        @endif

        <main class="content" id="content">
            @yield('content')
        </main>

        <livewire:front::ui.partials.footer />

        <!-- Cookie Consent Banner -->
        <div style="display:none;" x-cloak x-data x-show="$store.cookieConsent.showBanner"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95">

            <div class="fixed bottom-0 left-0 right-0 z-50 w-full" role="dialog" aria-modal="true"
                 aria-label="Persetujuan Cookie">
                <!-- Container -->
                <div
                     class="flex w-full flex-col gap-4 rounded-md border-t border-gray-200 bg-white p-4 shadow-xl sm:mx-auto sm:my-4 sm:max-w-6xl sm:flex-row sm:items-center sm:gap-6 sm:rounded-lg sm:border sm:border-gray-200">
                    <!-- Ikon Cookie -->
                    <div class="hidden flex-shrink-0 sm:block">
                        <i class="bx bx-cookie text-6xl text-sky-600"></i>
                    </div>
                    <!-- Konten Teks -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">Situs ini menggunakan cookie</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Dengan mengklik "Terima Semua", Anda setuju kami menyimpan cookie di perangkat Anda untuk
                            meningkatkan navigasi situs, menganalisis penggunaan (termasuk Google Analytics & FB Pixel),
                            dan membantu upaya pemasaran kami.
                            <a class="text-sky-600 underline hover:text-sky-700"
                               href="{{ route('front.privacy-policy') }}" target="_blank" rel="noopener">Pelajari
                                lebih
                                lanjut</a>
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-shrink-0 flex-col gap-2 sm:flex-row sm:items-center">
                        <button class="btn soft-secondary" type="button"
                                x-on:click="$store.cookieConsent.showSettings = true">
                            Pengaturan
                        </button>
                        <button class="btn solid-primary" type="button" x-on:click="$store.cookieConsent.accept()">
                            Terima Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="z-100 fixed inset-0 m-0 bg-black/20 backdrop-blur-[1px] transition-opacity" x-cloak
                 x-show="$store.cookieConsent.showSettings" x-on:click="$store.cookieConsent.showSettings = false;"
                 x-on:keydown.escape.window="$store.cookieConsent.showSettings = false;" wire:key="{{ randAlpha() }}">
            </div>
            <div class="modal modal-md" role="dialog" tabindex="-1" x-show="$store.cookieConsent.showSettings"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 x-trap="$store.cookieConsent.showSettings" x-cloak>
                <div class="modal-wrapper w-full">
                    <div class="p-4">
                        <h3 class="mb-4 font-bold text-gray-800" id="hs-bg-gray-on-hover-cards-label">
                            Pengaturan Cookie
                        </h3>
                        <form x-data="{ analytics: $store.cookieConsent.analytics, marketing: $store.cookieConsent.marketing }"
                              x-on:submit.prevent="
                            $store.cookieConsent.saveSettings(analytics, marketing);
                            $store.cookieConsent.showSettings = false;
                        ">
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <input class="form-checkbox" id="analytics" type="checkbox" x-model="analytics">
                                    <label class="flex-1 text-sm text-gray-800" for="analytics">
                                        <span class="font-medium">Cookie Analytics</span> <br>
                                        Mengizinkan penggunaan Google Analytics untuk menganalisa penggunaan situs.
                                    </label>
                                </div>
                                <div class="flex items-start gap-3">
                                    <input class="form-checkbox" id="marketing" type="checkbox" x-model="marketing">
                                    <label class="flex-1 text-sm text-gray-800" for="marketing">
                                        <span class="font-medium">Cookie Marketing</span> <br>
                                        Mengizinkan penggunaan pixel Facebook dan Google Tag Manager untuk pemasaran.
                                    </label>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-3">
                                <button class="btn soft-secondary" type="button"
                                        x-on:click="$store.cookieConsent.showSettings = false">
                                    Batal
                                </button>
                                <button class="btn solid-primary" type="submit">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @stack('script')
        @livewireScripts
    </body>

</html>
