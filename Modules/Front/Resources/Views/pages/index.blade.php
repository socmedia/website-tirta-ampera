@extends('front::layouts.master')

@section('title', getContent('seo.homepage.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.homepage.title')" :description="getContent('seo.homepage.description')" :keywords="getContent('seo.homepage.keywords')" :image="getContent('seo.homepage.image')" />
@endpush

@push('style')
    @vite('Modules/Front/Resources/assets/js/swiper.js')
@endpush

@section('content')
    {{-- HERO SECTION --}}
    <div class="container">
        <div class="grid gap-4 md:grid-cols-2 md:items-center md:gap-8 xl:gap-20">
            <div class="pt-24">
                <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-6xl">
                    {{ getContent('homepage.hero.title') }}
                    <span class="text-sky-600">
                        {{ getContent('homepage.hero.title_highlight') }}
                    </span>
                </h1>
                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ getSetting('site_tagline') }}
                </p>
                <p class="mt-2 text-lg text-gray-800">
                    {{ getContent('homepage.hero.subtitle') }}
                </p>
                <div class="mt-7 grid w-full gap-3 sm:inline-flex">
                    <a class="btn solid-primary" href="/tentang-kami">
                        Jelajahi Profil Kami
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a class="btn soft-secondary" href="/layanan">
                        Layanan Pelanggan
                    </a>
                </div>
                @php
                    $stats = getContent('homepage.hero.stats') ?? [];
                @endphp
                @if (is_array($stats) && count($stats))
                    <div class="mt-6 lg:mt-10">
                        <h4 class="mb-3 text-sm font-medium text-gray-700">Capaian Kami Dalam Angka:</h4>
                        <div class="grid grid-cols-3 gap-x-4">
                            @foreach ($stats as $stat)
                                <div class="py-3">
                                    <h3 class="text-2xl font-bold text-sky-600 lg:text-3xl">{{ $stat['number'] ?? '' }}</h3>
                                    <p class="text-sm text-gray-600">{{ $stat['label'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="relative ms-4">
                <img class="w-full rounded-b-2xl"
                     src="{{ getContent('homepage.hero.image') ?? 'https://placehold.co/700x800/0067A3/FFFFFF?text=Foto+Instalasi+Pengolahan+Air' }}"
                     alt="Foto Instalasi Pengolahan Air PERUMDA Tirta Ampera Boyolali">
                <div
                     class="-z-1 bg-linear-to-tr absolute inset-0 -mb-4 -ms-4 me-4 mt-4 size-full rounded-b-2xl from-sky-200 via-white/0 to-white/0 lg:-mb-6 lg:-ms-6 lg:me-6 lg:mt-6">
                </div>
                <div class="absolute bottom-0 start-0">
                    <svg class="ms-auto h-auto w-2/3 text-white" width="630" height="451" viewBox="0 0 630 451"
                         fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="531" y="352" width="99" height="99" fill="currentColor" />
                        <rect x="140" y="352" width="106" height="99" fill="currentColor" />
                        <rect x="482" y="402" width="64" height="49" fill="currentColor" />
                        <rect x="433" y="402" width="63" height="49" fill="NAn" />
                        <rect x="384" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="531" y="328" width="50" height="50" fill="currentColor" />
                        <rect x="99" y="303" width="49" height="58" fill="currentColor" />
                        <rect x="99" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="99" y="392" width="49" height="59" fill="currentColor" />
                        <rect x="44" y="402" width="66" height="49" fill="currentColor" />
                        <rect x="234" y="402" width="62" height="49" fill="currentColor" />
                        <rect x="334" y="303" width="50" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="64" fill="currentColor" />
                        <rect x="482" y="123" width="49" height="49" fill="currentColor" />
                        <rect x="507" y="124" width="49" height="24" fill="currentColor" />
                        <rect x="531" y="49" width="99" height="99" fill="currentColor" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ABOUT US SECTION --}}
    <div class="container py-16 lg:py-36">
        <div class="grid items-center gap-12 md:grid-cols-2">
            <div class="relative">
                <img class="rounded-xl"
                     src="{{ getContent('homepage.about.image') ?? 'https://placehold.co/600x400/E0F2FE/0C4A6E?text=Gedung+Kantor+Pusat' }}"
                     alt="{{ getContent('homepage.about.title', 'Gedung Kantor PERUMDA Tirta Ampera Boyolali') }}">
                <div class="absolute bottom-0 end-0 -z-10 -mb-4 -me-4 size-56 rounded-md bg-slate-100"></div>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase text-sky-600">
                    {{ getContent('homepage.about.subtitle', 'Tentang Kami') }}
                </h3>
                <h2 class="mt-3 text-3xl font-bold text-gray-800 lg:text-4xl">
                    {{ getContent('homepage.about.title', 'BUMD Profesional Kebanggaan Boyolali') }}
                </h2>
                <p class="mt-4 text-gray-600">
                    {{ getContent('homepage.about.content') }}
                </p>
                @php
                    $aboutFeatures = getContent('homepage.about.features') ?? [];
                @endphp
                @if (is_array($aboutFeatures) && count($aboutFeatures))
                    <ul class="mt-6 space-y-4" role="list">
                        @foreach ($aboutFeatures as $feature)
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-shrink-0 text-sky-600" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.06 0l4.001-5.5a.75.75 0 00-.106-.92z"
                                          clip-rule="evenodd" />
                                </svg>
                                <span>
                                    <strong class="font-semibold text-gray-800">{{ $feature['title'] ?? '' }}</strong>
                                    @if (!empty($feature['desc']))
                                        - {{ $feature['desc'] }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <a class="mt-8 inline-flex items-center justify-center gap-x-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:bg-gray-50"
                   href="/tentang-kami">
                    Lihat Sejarah & Struktur Kami
                </a>
            </div>
        </div>
    </div>
    {{-- FEATURES SECTION --}}
    <div class="bg-slate-50 py-16 sm:py-24">
        <div class="container">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-gray-800 lg:text-4xl">
                    {{ getContent('homepage.services.heading', 'Layanan Digital Profesional') }}
                </h2>
                <p class="mt-3 text-lg text-gray-600">
                    {{ getContent('homepage.services.description', 'Akses mudah untuk semua kebutuhan administratif Anda, langsung dari genggaman.') }}
                </p>
            </div>
            @php
                $services = getContent('homepage.services.list') ?? [];
            @endphp
            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($services as $service)
                    <div
                         class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                        <div class="flex-shrink-0">
                            {{-- Optionally: add an icon (or future icon field)  --}}
                        </div>
                        <div class="mt-4 h-full flex-1">
                            <h3 class="text-xl font-semibold text-gray-800">
                                {{ $service['title'] ?? '' }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ $service['desc'] ?? '' }}
                            </p>
                        </div>
                        @if (!empty($service['cta']) && !empty($service['url']))
                            <a class="mt-4 inline-flex items-center gap-x-2 font-medium text-sky-600 hover:text-sky-500"
                               href="{{ $service['url'] }}">
                                {{ $service['cta'] ?? '' }}
                                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                          clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- END FEATURES SECTION --}}

    <livewire:front::news.latest />

    {{-- LOGO CLOUD / MITRA KAMI SECTION --}}
    <div class="bg-slate-50 py-16 sm:py-24">
        <div class="container">
            <h2 class="text-center text-3xl font-bold text-gray-800 lg:text-4xl">
                {{ getContent('homepage.partners.heading', 'Dipercaya oleh Mitra Profesional') }}
            </h2>
            <p class="mt-3 text-center text-lg text-gray-600">
                {{ getContent('homepage.partners.description', 'Kami bekerja sama dengan berbagai pemangku kepentingan untuk menjamin pelayanan terbaik.') }}
            </p>
            @php
                $partnerLogos = getContent('homepage.partners.logos') ?? [];
            @endphp
            <div
                 class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                @foreach ($partnerLogos as $logo)
                    <img class="col-span-2 max-h-12 w-full object-contain opacity-60 grayscale transition hover:opacity-100 lg:col-span-1"
                         src="{{ $logo['image'] ?? '' }}" alt="{{ $logo['name'] ?? '' }}" width="158"
                         height="48">
                @endforeach
            </div>
        </div>
    </div>
    {{-- END LOGO CLOUD --}}

    {{-- CTA APPS SECTION --}}
    <x-front::partials.cta.apps />
@endsection
