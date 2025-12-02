@extends('front::layouts.master')

@section('title', getContent('seo.contact.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.contact.title')" :description="getContent('seo.contact.description')" :keywords="getContent('seo.contact.keywords')" :image="getContent('seo.contact.image')" />
@endpush

@push('style')
    @vite('Modules/Front/Resources/assets/js/libphonenumber.js')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb title="{{ __('front::navbar.contact') }}" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.contact')],
    ]" />

    {{-- MAP at the top if available --}}
    @if (getSetting('contact_embed_maps'))
        <div class="w-full overflow-hidden">
            {!! getSetting('contact_embed_maps') !!}
        </div>
    @endif

    <div class="relative overflow-hidden bg-neutral-50 py-24 lg:py-32">
        <div class="absolute inset-0 z-0 opacity-[0.4]"
             style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 32px 32px;">
        </div>

        <div
             class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-sky-100 opacity-50 mix-blend-multiply blur-3xl filter">
        </div>
        <div
             class="absolute -right-20 bottom-0 h-[500px] w-[500px] rounded-full bg-indigo-100 opacity-50 mix-blend-multiply blur-3xl filter">
        </div>

        <div class="container relative z-10">

            <div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-12 lg:items-start lg:gap-8">

                <div class="pt-8 lg:col-span-5 lg:pr-8">
                    <div class="mb-8">
                        <span class="mb-3 block text-sm font-bold uppercase tracking-widest text-sky-600">
                            Hubungi Kami
                        </span>
                        <h2 class="text-4xl font-extrabold text-neutral-900 md:text-5xl">
                            Let's start a <br>
                            <span class="bg-gradient-to-r from-sky-600 to-emerald-600 bg-clip-text text-transparent">
                                conversation.
                            </span>
                        </h2>
                        <p class="mt-6 text-lg leading-relaxed text-neutral-600">
                            {{ getContent('contact.inquiry.description') }}
                        </p>
                    </div>

                    <div class="mt-12 space-y-8">

                        {{-- INFORMASI KANTOR --}}
                        <div class="space-y-4">
                            {{-- ADDRESS --}}
                            <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                <div
                                     class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-sky-600 shadow-sm ring-1 ring-neutral-900/5">
                                    <i class='bx bx-map text-2xl'></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-neutral-900">Kantor Kami</h4>
                                    <address class="mt-1 text-sm not-italic leading-relaxed text-neutral-500">
                                        {{ getSetting('contact_address') }}
                                    </address>
                                </div>
                            </div>
                            {{-- FAX --}}
                            @if (getSetting('contact_fax'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-indigo-500 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bx bx-printer text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">Fax</h4>
                                        <span class="mt-1 block text-sm text-neutral-500">
                                            {{ getSetting('contact_fax') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- KONTAK TELEPON --}}
                        <div class="space-y-4">
                            {{-- PHONE --}}
                            @if (getSetting('contact_phone'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-emerald-600 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bx bx-phone text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">Telepon</h4>
                                        <a class="mt-1 block text-sm text-neutral-500 transition hover:text-emerald-600"
                                           href="tel:{{ preg_replace('/\D/', '', getSetting('contact_phone')) }}">
                                            {{ getSetting('contact_phone') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            {{-- INFO PELAYANAN --}}
                            @if (getSetting('contact_service_info'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-cyan-600 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bx bx-headphone text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">Info Pelayanan</h4>
                                        <a class="mt-1 block text-sm text-neutral-500 transition hover:text-cyan-600"
                                           href="tel:{{ preg_replace('/\D/', '', getSetting('contact_service_info')) }}">
                                            {{ getSetting('contact_service_info') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- EMAIL --}}
                        <div class="space-y-4">
                            {{-- EMAIL UTAMA --}}
                            @if (getSetting('contact_email'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-sky-600 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bx bx-envelope text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">Email</h4>
                                        <a class="mt-1 block text-sm text-neutral-500 transition hover:text-sky-600"
                                           href="mailto:{{ getSetting('contact_email') }}">
                                            {{ getSetting('contact_email') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- SUPPORT EMAIL --}}
                            @if (getSetting('contact_support_email'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-violet-600 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bx bx-envelope text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">Support Email</h4>
                                        <a class="mt-1 block text-sm text-neutral-500 transition hover:text-violet-600"
                                           href="mailto:{{ getSetting('contact_support_email') }}">
                                            {{ getSetting('contact_support_email') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- WHATSAPP --}}
                        <div>
                            @if (getSetting('contact_whatsapp'))
                                <div class="hover:tranneutral-x-2 flex items-start gap-5 transition duration-300">
                                    <div
                                         class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-green-500 shadow-sm ring-1 ring-neutral-900/5">
                                        <i class='bxl bx-whatsapp text-2xl'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900">WhatsApp</h4>
                                        @php
                                            $waLink = getSetting('contact_whatsapp_link');
                                            $waNumber = getSetting('contact_whatsapp');
                                        @endphp
                                        <a class="mt-1 block text-sm text-neutral-500 transition hover:text-green-600"
                                           href="{{ $waLink ?: 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/\D/', '', $waNumber)) }}"
                                           target="_blank" rel="noopener">
                                            {{ $waNumber }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- MAP MOVED TO TOP, REMOVED FROM LIST --}}
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div
                         class="relative rounded-3xl bg-white p-8 shadow-[0_20px_50px_rgb(8_112_184_/_7%)] ring-1 ring-neutral-900/5 md:p-10 lg:p-12">

                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-neutral-900">Kirim Pesan</h3>
                            <p class="text-sm text-neutral-500">Kami akan membalas secepatnya.</p>
                        </div>

                        <div class="relative z-10">
                            <livewire:front::contact.form />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
