@extends('front::layouts.errors')

@section('title', 'Too Many Requests')

@push('meta')
    <x-front::partials.meta title="Too Many Requests" description="Too Many Requests" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Too Many Requests') }}" code="429"
                              message="{{ __('front::global.error_429') }}" />
@endsection
