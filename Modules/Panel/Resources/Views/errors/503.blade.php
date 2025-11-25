@extends('panel::layouts.master')

@section('title', 'Service Unavailable')

@push('meta')
    <x-panel::utils.meta title="Service Unavailable" description="Service Unavailable" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Service Unavailable" code="503"
                              message="Sorry, the service is currently unavailable. We are performing maintenance or upgrades. Please try again later."
                              button="Go back" />
@endsection
