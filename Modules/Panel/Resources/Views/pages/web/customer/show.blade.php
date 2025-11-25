@extends('panel::layouts.master')

@section('title', 'Dashboard ' . $customer->name)

@push('style')
@endpush

@section('content')
    <x-panel::utils.breadcrumb title="Pelanggan">
        <x-panel::utils.breadcrumb-item href="{{ route('panel.web.customer.index') }}" page="Pelanggan" />
        <x-panel::utils.breadcrumb-item href="{{ route('panel.web.customer.show', request('id')) }}" :page="$customer->name" />
        <x-panel::utils.breadcrumb-item page="Dashboard" />
    </x-panel::utils.breadcrumb>

    <livewire:panel::panel.customer.dashboard :customer="$customer" />
    <livewire:panel::panel.customer.course.table :customer="$customer" />
@endsection

@push('script')
@endpush
