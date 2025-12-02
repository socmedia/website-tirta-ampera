@extends('front::layouts.master')

@section('title', getContent('seo.privacy-policy.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.privacy-policy.title')" :description="getContent('seo.privacy-policy.description')" :keywords="getContent('seo.privacy-policy.keywords')" :image="getContent('seo.privacy-policy.image')" />
@endpush

@push('style')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb :title="__('front::footer.privacy_policy')" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::footer.privacy_policy')],
    ]" />

    <section class="relative overflow-hidden bg-white py-20">
        <div class="container relative z-10">
            <!-- Content -->
            <div class="prose mx-auto text-neutral-700">
                <!-- Header -->
                <div class="mb-16">
                    <h2 class="mb-2 text-3xl font-bold text-neutral-800 md:text-5xl">
                        {{ getContent('privacy_policy.body', 'name') }}
                    </h2>
                    <p class="text-neutral-500">
                        Last update:
                        {{ getContent('privacy_policy.body', 'updated_at')->translatedFormat('d M Y H:i') }}
                    </p>
                </div>

                {!! getContent('privacy_policy.body') !!}
            </div>
        </div>
    </section>
@endsection
