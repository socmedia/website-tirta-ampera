@extends('panel::layouts.master')

@section('title', 'Page Expired')

@push('meta')
    <x-panel::utils.meta title="Page Expired" description="Page Expired" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Page Expired" code="419"
                              message="Your session has expired. Please log in again to continue accessing this page."
                              button="Go back" />
@endsection
