@extends('front::layouts.errors')

@section('title', 'Page Expired')

@push('meta')
    <x-front::partials.meta title="Page Expired" description="Page Expired" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Page Expired') }}" code="419" message="{{ __('front::global.error_419') }}" />
@endsection
