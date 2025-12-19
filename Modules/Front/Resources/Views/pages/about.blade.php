@extends('front::layouts.master')

@section('title', getContent('seo.about.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.about.title')" :description="getContent('seo.about.description')" :keywords="getContent('seo.about.keywords')" :image="getContent('seo.about.image')" />
@endpush

@push('style')
    @vite('Modules/Front/Resources/assets/js/swiper.js')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb title="{{ __('front::navbar.about') }}" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.about')],
    ]" />

    <div class="container">

        <!-- Section 1: Header Utama dan Pengantar (Modern, Responsive) -->
        <section class="py-10 sm:py-16 lg:py-32">
            <x-front::partials.section-title :content="getContent('about.header.subtitle')" :title="getContent('about.header.title')" />
            <div class="mt-8 px-2 sm:mt-12 sm:px-4">
                <img class="shadow-xendit aspect-[3/2] w-full rounded-2xl object-cover"
                     src="{{ getContent('about.header.image') }}" alt="Ilustrasi Tim Tirta Ampera Melayani Masyarakat"
                     onerror="this.onerror=null;this.src='{{ getSetting('thumbnail_3_2') }}';">
            </div>
        </section>
    </div>

    <!-- Section 2: Visi, Misi, dan Tujuan (Clean Responsive Cards) -->
    <section class="bg-neutral-50 py-24 sm:py-32">
        <x-front::partials.section-title :title="getContent('about.vm.title')" :content="getContent('about.vm.description')" />
        <div class="mt-12">
            <div class="mx-auto flex w-fit flex-col items-center gap-6 md:gap-12" x-data="{ tab: 1 }">
                <!-- Tab Buttons (2 steps only)-->
                <div
                     class="mb-6 flex flex-wrap items-center justify-center gap-x-1 rounded-md bg-neutral-100 p-2 text-neutral-700 sm:gap-x-2">
                    <button class="rounded px-4 py-2 text-xs font-medium hover:bg-sky-700 hover:text-white focus:outline-none md:text-base"
                            type="button" :class="tab === 1 ? 'bg-sky-700 text-white font-semibold' : ''" @click="tab = 1">
                        {{ getContent('about.vm.visi.title') }} &amp; {{ getContent('about.vm.misi.title') }}
                    </button>
                    <button class="rounded px-4 py-2 text-xs font-medium hover:bg-sky-700 hover:text-white focus:outline-none md:text-base"
                            type="button" :class="tab === 2 ? 'bg-sky-700 text-white font-semibold' : ''" @click="tab = 2">
                        {{ getContent('about.vm.tujuan.title') }}
                    </button>
                </div>
                <div class="grid w-full max-w-5xl grid-cols-1 gap-8 md:grid-cols-2 md:gap-12">
                    <!-- Static Image (does not change), now with additional shadow -->
                    <img class="aspect-square order-first w-full rounded-lg object-cover shadow-xl md:order-last"
                         src="{{ getContent('about.vm.image') }}" alt="Tentang Kami" />
                    <!-- Changing Text Content -->
                    <div class="prose">
                        <template x-if="tab === 1">
                            <div>
                                <h2>
                                    {{ getContent('about.vm.visi.title') }}
                                </h2>
                                <p>
                                    {{ getContent('about.vm.visi.description') }}
                                </p>
                                <h2 class="mt-6">
                                    {{ getContent('about.vm.misi.title') }}
                                </h2>
                                <ul>
                                    @foreach (getContent('about.vm.misi') as $misi)
                                        <li>{{ $misi }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </template>
                        <template x-if="tab === 2">
                            <div>
                                <h2>
                                    {{ getContent('about.vm.tujuan.title') }}
                                </h2>
                                <div class="mt-2 space-y-3">
                                    @foreach (getContent('about.vm.tujuan') as $tujuan)
                                        <div>
                                            <p><b>{{ $tujuan['title'] }}:</b></p>
                                            <p>
                                                {{ $tujuan['description'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <livewire:front::slider.milestone />

        {{-- <!-- Section 4: Struktur Organisasi (Flat Card, Simple, Minimal, Less Ugly Colors) -->
        <section class="body-font text-gray-600">
            <div class="container mx-auto px-5 py-24" x-data="{ activeTab: 'direksi' }">
                <div class="mb-20 text-center">
                    <x-front::partials.section-title class="mb-20" :title="getContent('about.leadership.title')" :content="getContent('about.leadership.direksi.subtitle')" />

                    <!-- Tabs / Toggle Buttons -->
                    <div class="mt-10 flex flex-row justify-center gap-2 sm:gap-4">
                        <button class="rounded border px-4 py-2 text-sm font-medium transition focus:outline-none"
                                :class="activeTab === 'direksi' ? 'bg-sky-600 text-white border-sky-600' :
                                    'bg-gray-100 text-gray-800 border-gray-300 hover:bg-sky-50'"
                                @click="activeTab = 'direksi'">
                            Manajemen Direksi
                        </button>
                        <button class="rounded border px-4 py-2 text-sm font-medium transition focus:outline-none"
                                :class="activeTab === 'pengawas' ? 'bg-sky-600 text-white border-sky-600' :
                                    'bg-gray-100 text-gray-800 border-gray-300 hover:bg-sky-50'"
                                @click="activeTab = 'pengawas'">
                            Dewan Pengawas
                        </button>
                    </div>
                </div>

                <!-- Tab Content: Direksi -->
                <div x-show="activeTab === 'direksi'" x-transition:enter.duration.350ms>
                    <div class="-mx-4 -mb-10 -mt-4 flex flex-wrap justify-center space-y-6 sm:-m-4 md:space-y-0">
                        <!-- Direksi Card 1 -->
                        <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                            <div
                                 class="mb-5 inline-flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-500">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-linecap="round"
                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="mb-3 text-lg font-medium text-gray-900">Nama Direktur Utama</h2>
                                <p class="mb-2 text-xs font-semibold text-sky-600">Direktur Utama</p>
                                <p class="text-base leading-relaxed">Memimpin visi dan strategi perusahaan.</p>
                            </div>
                        </div>
                        <!-- Direksi Card 2 -->
                        <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                            <div
                                 class="mb-5 inline-flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-500">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-linecap="round"
                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="6" cy="6" r="3"></circle>
                                    <circle cx="6" cy="18" r="3"></circle>
                                    <path d="M20 4L8.12 15.88M14.47 14.48L20 20M8.12 8.12L12 12"></path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="mb-3 text-lg font-medium text-gray-900">Nama Direktur Teknik</h2>
                                <p class="mb-2 text-xs font-semibold text-sky-600">Direktur Teknik</p>
                                <p class="text-base leading-relaxed">Menjamin kualitas dan kontinuitas suplai air.</p>
                            </div>
                        </div>
                        <!-- Direksi Card 3 -->
                        <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                            <div
                                 class="mb-5 inline-flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-500">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-linecap="round"
                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="mb-3 text-lg font-medium text-gray-900">Nama Direktur Keuangan</h2>
                                <p class="mb-2 text-xs font-semibold text-sky-600">Direktur Keuangan</p>
                                <p class="text-base leading-relaxed">Mengelola keuangan untuk efisiensi dan transparansi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content: Dewan Pengawas -->
                <div x-show="activeTab === 'pengawas'" x-transition:enter.duration.350ms>
                    <div class="-mx-4 -mb-10 -mt-4 flex flex-wrap justify-center space-y-6 sm:-m-4 md:space-y-0">
                        <!-- Pengawas Card 1 -->
                        <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                            <div
                                 class="mb-5 inline-flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-500">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-linecap="round"
                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 01-8 0m8 0a4 4 0 10-8 0m8 0v4a4 4 0 01-8 0V7m8 0V6a4 4 0 00-8 0v1">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="mb-3 text-lg font-medium text-gray-900">Nama Ketua Pengawas</h2>
                                <p class="mb-2 text-xs font-semibold text-sky-600">Ketua Dewan Pengawas</p>
                                <p class="text-base leading-relaxed">Dewan Pengawas bertugas mengawal tata kelola agar
                                    perusahaan tetap akuntabel dan sesuai aturan.</p>
                            </div>
                        </div>
                        <!-- Pengawas Card 2 -->
                        <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                            <div
                                 class="mb-5 inline-flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-500">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-linecap="round"
                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="7" r="4"></circle>
                                    <path d="M5.5 20a1.5 1.5 0 013 0H17.5a1.5 1.5 0 013 0"></path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="mb-3 text-lg font-medium text-gray-900">Nama Anggota Pengawas</h2>
                                <p class="mb-2 text-xs font-semibold text-sky-600">Anggota Dewan Pengawas</p>
                                <p class="text-base leading-relaxed">Turut serta dalam menjaga pengawasan dan kinerja
                                    perusahaan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tab Content: Dewan Pengawas -->
        <div class="mt-5 sm:mt-8" style="display: none;" x-show="activeTab === 'pengawas'"
             x-transition:enter.duration.500ms>
            <div class="text-center">
                <p class="mb-5 text-xs text-neutral-500 sm:mb-8 sm:text-sm">
                    Dewan Pengawas bertugas mengawal tata kelola agar perusahaan tetap akuntabel dan sesuai aturan.
                </p>
                <div class="mx-auto mt-4 grid max-w-md grid-cols-1 gap-4 sm:max-w-2xl sm:gap-6 md:grid-cols-2">
                    <!-- Placeholder Card 1 -->
                    <div class="shadow-xendit rounded-xl bg-white p-4 sm:p-6">
                        <img class="mx-auto mb-2 h-20 w-20 rounded-full object-cover shadow-md sm:mb-3 sm:h-24 sm:w-24"
                             src="https://placehold.co/100x100/CCCCCC/666666?text=Foto" alt="Foto Ketua Pengawas">
                        <p class="text-base font-bold text-neutral-900 sm:text-lg">Nama Ketua Pengawas</p>
                        <p class="text-xs font-semibold text-sky-600 sm:text-sm">Ketua Dewan Pengawas</p>
                    </div>
                    <!-- Placeholder Card 2 -->
                    <div class="shadow-xendit rounded-xl bg-white p-4 sm:p-6">
                        <img class="mx-auto mb-2 h-20 w-20 rounded-full object-cover shadow-md sm:mb-3 sm:h-24 sm:w-24"
                             src="https://placehold.co/100x100/CCCCCC/666666?text=Foto" alt="Foto Anggota Pengawas">
                        <p class="text-base font-bold text-neutral-900 sm:text-lg">Nama Anggota Pengawas</p>
                        <p class="text-xs font-semibold text-sky-600 sm:text-sm">Anggota Dewan Pengawas</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <x-front::partials.cta.contact />
    </div>
@endsection
