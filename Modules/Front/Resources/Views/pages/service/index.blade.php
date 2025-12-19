@extends('front::layouts.master')

@section('title', getContent('seo.service.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.service.title')" :description="getContent('seo.service.description')" :keywords="getContent('seo.service.keywords')" :image="getContent('seo.service.image')" />
@endpush

@push('style')
    @vite('Modules/Front/Resources/assets/js/swiper.js')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb title="{{ __('front::navbar.service') }}" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.service')],
    ]" />

    <div class="container">
        <!-- Section 1: Header Utama dan Pengantar (Modern, Responsive) -->
        <section class="relative py-10 sm:py-16 lg:py-32">
            <div class="absolute inset-x-0 top-0 z-[1] flex h-full w-full items-center justify-center opacity-100">
                <img class="opacity-90 [mask-image:radial-gradient(75%_75%_at_center,white,transparent)]"
                     src="/assets/images/bg-grid.svg" alt="Grid Background" />
            </div>
            <x-front::partials.section-title :subtitle="getContent('service.header.highlight')" :content="getContent('service.header.description')">
                <x-slot name="title">
                    {!! getContent('service.header.title.part1') !!}
                    <span class="text-sky-600">
                        {!! getContent('service.header.title.part2') !!}
                    </span>
                </x-slot>
            </x-front::partials.section-title>
        </section>

        <section class="py-32">
            <div class="grid gap-10 lg:grid-cols-2">
                {{-- Left: Sticky Heading --}}
                <div class="top-32 self-start lg:sticky">
                    <h2 class="text-3xl font-bold lg:text-4xl">
                        {!! getContent('service.pillar.title') !!}
                    </h2>
                    <p class="mt-4 text-base text-neutral-600">
                        {!! getContent('service.pillar.description') !!}
                    </p>
                </div>
                {{-- Right: Content --}}
                <div>
                    <div class="mt-10 grid gap-4 lg:mt-0">
                        @foreach (getContent('service.pillar.items') ?? [] as $pillar)
                            <div class="flex h-full flex-col rounded-lg border border-neutral-100 bg-neutral-50 p-5">
                                <span
                                      class="mb-8 flex size-12 size-14 items-center justify-center rounded-full bg-sky-600 text-2xl text-white">
                                    @if (!empty($pillar['svg']))
                                        {!! $pillar['svg'] !!}
                                    @elseif (!empty($pillar['icon']))
                                        <i class="{{ $pillar['icon'] ?? 'bx bx-question-mark' }}"></i>
                                    @else
                                    @endif
                                </span>
                                <small
                                       class="mb-2 text-sm font-semibold uppercase text-sky-700">{!! $pillar['subtitle'] ?? '' !!}</small>
                                <h3 class="mb-2 text-xl font-medium">{!! $pillar['title'] ?? '' !!}</h3>
                                <p class="mb-2 flex-1 leading-7 text-neutral-600">
                                    {!! $pillar['description'] ?? '' !!}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Section 3: Layanan Administrasi dan Teknis Tambahan -->
    <section class="bg-gradient-to-b from-neutral-100 to-neutral-50 py-32">
        <div class="container">
            <x-front::partials.section-title :title="getContent('service.extra.title')" :content="getContent('service.extra.description')" />
            <div class="mx-auto flex flex-wrap justify-center gap-6">
                @foreach (getContent('service.extra.items') as $service)
                    <div class="flex w-full flex-col gap-4 rounded-xl bg-white p-4 lg:w-3/12 lg:p-6">
                        @if (!empty($service['icon']))
                            <span
                                  class="mb-4 flex size-16 flex-shrink-0 items-center justify-center rounded-full bg-sky-50 text-2xl text-sky-600">
                                <i class="{{ $service['icon'] }}"></i>
                            </span>
                        @endif
                        <div>
                            <h3 class="mb-3 text-xl font-bold text-neutral-900">
                                {!! $service['title'] ?? '' !!}
                            </h3>
                            <p class="line-clamp-3 text-ellipsis text-base text-neutral-600 hover:line-clamp-none">
                                {!! $service['description'] ?? '' !!}
                            </p>
                            @if (!empty($service['link_label']) && !empty($service['link_route']))
                                <a class="btn soft-primary mt-3" href="{{ route($service['link_route']) }}" wire:navigate>
                                    {{ $service['link_label'] }}
                                    <i class="bx bx-arrow-right-stroke"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Apps -->
    <div class="container py-8">
        <x-front::partials.cta.apps />
    </div>
@endsection
