@extends('front::layouts.errors')

@section('title', 'Service Unavailable')

@push('meta')
    <x-front::partials.meta title="Service Unavailable" description="Service Unavailable" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Service Unavailable') }}" code="503"
                              message="{{ __('front::global.error_503') }}" />
@endsection
