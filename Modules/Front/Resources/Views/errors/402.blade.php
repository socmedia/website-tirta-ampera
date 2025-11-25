@extends('front::layouts.errors')

@section('title', 'Payment Required')

@push('meta')
    <x-front::partials.meta title="Payment Required" description="Payment Required" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Payment Required') }}" code="402"
                              message="{{ __('front::global.error_402') }}" />
@endsection
