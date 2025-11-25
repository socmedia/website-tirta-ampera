@extends('panel::layouts.master')

@section('title', 'Dashboard')

@push('style')
    @vite(['Modules/Panel/Resources/assets/js/chart.js'])
@endpush

@section('content')
    <livewire:panel::dashboard />
@endsection

@push('script')
    {{-- --}}
@endpush
