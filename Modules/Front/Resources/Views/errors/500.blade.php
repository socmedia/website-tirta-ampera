@extends('front::layouts.errors')

@section('title', 'Server Error')

@push('meta')
    <x-front::partials.meta title="Server Error" description="Server Error" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Server Error') }}" code="500" message="{{ __('front::global.error_500') }}" />
@endsection
