@extends('panel::layouts.master')

@section('title', 'Not Found')

@push('meta')
    <x-panel::utils.meta title="Not Found" description="Not Found" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Not Found"
                              message="The page you are looking for could not be found. Please make sure the requested URL is correct."
                              icon="bx bx-search-alt" button="Go back" />
@endsection
