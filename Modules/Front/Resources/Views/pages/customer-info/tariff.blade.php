@extends('front::layouts.master')

@section('title', getContent('seo.info_tariff.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.info_tariff.title')" :description="getContent('seo.info_tariff.description')" :keywords="getContent('seo.info_tariff.keywords')" :image="getContent('seo.info_tariff.image')" />
@endpush

@section('content')
    <x-front::ui.breadcrumb title="Daftar Tarif" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.customer_info'), 'url' => route('front.customer-info.rights-obligations')],
        ['label' => 'Daftar Tarif'],
    ]" />

    <section class="relative overflow-hidden bg-white py-20">
        <div class="container relative z-10">
            <!-- Content -->
            <div class="prose mx-auto text-neutral-700">
                <!-- Header -->
                <div class="mb-16">
                    <h2 class="mb-2 text-3xl font-bold text-neutral-800 md:text-5xl">
                        {{ getContent('tariff.body', 'name') }}
                    </h2>
                    <p class="text-neutral-500">
                        Last update:
                        {{ getContent('tariff.body', 'updated_at')->translatedFormat('d M Y H:i') }}
                    </p>
                </div>

                {!! getContent('tariff.body') !!}
            </div>
        </div>
    </section>

    <x-front::partials.cta.apps-secondary />
@endsection
