@extends('panel::layouts.master')

@section('title', 'Unauthorized')

@push('meta')
    <x-panel::utils.meta title="Unauthorized" description="Unauthorized" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Unauthorized" code="401"
                              message="You are not authorized to access this resource. Please make sure you are authenticated and have the necessary permissions."
                              button="Go back" />
@endsection
