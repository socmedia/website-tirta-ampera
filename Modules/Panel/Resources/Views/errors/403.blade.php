@extends('panel::layouts.master')

@section('title', 'Forbidden')

@push('meta')
    <x-panel::utils.meta title="Forbidden" description="Forbidden" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Forbidden" code="403"
                              message="Access Denied. Sorry, you do not have permission to access this page."
                              button="Go back" />
@endsection
