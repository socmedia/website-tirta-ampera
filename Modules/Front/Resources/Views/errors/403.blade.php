@extends('front::layouts.errors')

@section('title', 'Forbidden')

@push('meta')
    <x-front::partials.meta title="Forbidden" description="Forbidden" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Forbidden') }}" code="403" message="{{ __('front::global.error_403') }}" />
@endsection
