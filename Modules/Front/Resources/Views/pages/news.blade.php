@extends('front::layouts.master')

@section('title', getContent('seo.news.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.news.title')" :description="getContent('seo.news.description')" :keywords="getContent('seo.news.keywords')" :image="getContent('seo.news.image')" />
@endpush

@push('style')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb title="{{ __('front::navbar.news') }}" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.news')],
    ]" />

    <div class="relative overflow-hidden bg-white py-20">
        <div class="container relative z-10">
            <!-- Header -->
            <x-front::partials.section-title :title="getContent('news.heading')" :content="getContent('news.description')" />

            <livewire:front::news.listing />
        </div>
    </div>
@endsection
