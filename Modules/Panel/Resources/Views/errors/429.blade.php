@extends('panel::layouts.master')

@push('meta')
    <x-panel::utils.meta title="Too Many Requests" description="Too Many Requests" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Too Many Requests" code="429"
                              message="Your request could not be processed because too many requests have been made in a short period. Please try again later."
                              button="Go back" />
@endsection
