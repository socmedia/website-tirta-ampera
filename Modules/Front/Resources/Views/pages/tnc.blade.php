@extends('front::layouts.master')

@section('title', getContent('seo.terms-conditions.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.terms-conditions.title')" :description="getContent('seo.terms-conditions.description')" :keywords="getContent('seo.terms-conditions.keywords')" :image="getContent('seo.terms-conditions.image')" />
@endpush
@push('style')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb :title="__('front::footer.terms_conditions')" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::footer.terms_conditions')],
    ]" />

    <section class="overflow-hidden relative py-20 bg-white">
        <div class="container relative z-10">
            <!-- Content -->
            <div class="mx-auto prose text-neutral-700">
                <!-- Header -->
                <div class="mb-16">
                    <h2 class="mb-2 text-3xl font-bold text-neutral-800 md:text-5xl">
                        {{ getContent('terms_and_conditions.body', 'name') }}
                    </h2>
                    <p class="text-neutral-500">
                        Last update:
                        {{ getContent('terms_and_conditions.body', 'updated_at')->translatedFormat('d M Y H:i') }}
                    </p>
                </div>

                {!! getContent('terms_and_conditions.body') !!}
            </div>
        </div>
    </section>
@endsection
