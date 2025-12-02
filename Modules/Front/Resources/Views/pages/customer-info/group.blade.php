@extends('front::layouts.master')

@section('title', getContent('seo.info_group.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.info_group.title')" :description="getContent('seo.info_group.description')" :keywords="getContent('seo.info_group.keywords')" :image="getContent('seo.info_group.image')" />
@endpush

@section('content')
    <x-front::ui.breadcrumb title="Larangan Pelanggan" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.customer_info'), 'url' => route('front.customer-info.rights-obligations')],
        ['label' => 'Larangan Pelanggan'],
    ]" />

    <section class="relative overflow-hidden bg-white py-20">
        <div class="container relative z-10">
            <!-- Content -->
            <div class="prose mx-auto text-neutral-700">
                <!-- Header -->
                <div class="mb-16">
                    <h2 class="mb-2 text-3xl font-bold text-neutral-800 md:text-5xl">
                        {{ getContent('group.body', 'name') }}
                    </h2>
                    <p class="text-neutral-500">
                        Last update:
                        {{ getContent('group.body', 'updated_at')->translatedFormat('d M Y H:i') }}
                    </p>
                </div>

                {!! getContent('group.body') !!}
            </div>
        </div>
    </section>

    <x-front::partials.cta.apps-secondary />
@endsection
