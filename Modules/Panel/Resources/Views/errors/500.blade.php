@extends('panel::layouts.master')

@section('title', 'Server Error')

@push('meta')
    <x-panel::utils.meta title="Server Error" description="Server Error" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Server Error" code="500"
                              message="A server error occurred while processing your request. Please try again later."
                              button="Go back" />
@endsection
