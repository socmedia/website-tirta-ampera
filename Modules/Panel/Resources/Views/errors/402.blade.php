@extends('panel::layouts.master')

@push('meta')
    <x-panel::utils.meta title="Payment Required" description="Payment Required" :image="cache('seo_gambar_beranda')" />
@endpush

@section('content')
    <x-panel::partials.errors title="Payment Required" code="402"
                              message="To access this page, payment is required. Please make the necessary payment to continue."
                              button="Go back" />
@endsection
