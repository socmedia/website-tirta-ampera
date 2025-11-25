@extends('front::layouts.errors')

@section('title', 'Not Found')

@push('meta')
    <x-front::partials.meta title="Not Found" description="Not Found" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Not Found') }}" code="404" message="{{ __('front::global.error_404') }}" />
@endsection
