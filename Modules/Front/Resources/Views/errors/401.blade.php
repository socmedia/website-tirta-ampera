@extends('front::layouts.errors')

@section('title', 'Unauthorized')

@push('meta')
    <x-front::partials.meta title="Unauthorized" description="Unauthorized" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Unauthorized') }}" code="401" message="{{ __('front::global.error_401') }}" />
@endsection
