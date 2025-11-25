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
        <!-- Blue Accent Blurs -->
        <div class="absolute right-[-40px] top-1/3 z-0 h-[220px] w-[220px] rounded-full bg-blue-100 blur-3xl"></div>
        <div class="absolute left-[-60px] top-[180px] z-0 h-[200px] w-[200px] rounded-full bg-blue-200 blur-3xl"></div>
        <div class="absolute bottom-[-100px] left-[40px] z-0 h-[300px] w-[300px] rounded-full bg-blue-50 blur-3xl"></div>
        <div class="container relative z-10">
            <!-- Content -->
            <div class="prose mx-auto text-neutral-700">
                <!-- Header -->
                <div class="mb-16">
                    <h2 class="mb-2 text-3xl font-bold text-neutral-800 md:text-5xl">
                        {{ __('front::footer.privacy_policy') }}
                    </h2>
                    <p class="text-neutral-500">{{ __('front::footer.privacy_policy') }} ARAH Coffee.</p>
                </div>

                {!! getContent('privacy_policy.body') !!}
            </div>
        </div>
    </section>
@endsection
