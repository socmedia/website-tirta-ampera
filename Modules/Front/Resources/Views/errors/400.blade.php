@extends('front::layouts.errors')

@section('title', 'Bad Request')

@push('meta')
    <x-front::partials.meta title="Bad Request" description="Bad Request" :image="cache('logo_gray')" />
@endpush

@section('content')
    <x-front::partials.errors title="{{ __('Bad Request') }}" code="400" message="{{ __('front::global.error_400') }}" />
@endsection
