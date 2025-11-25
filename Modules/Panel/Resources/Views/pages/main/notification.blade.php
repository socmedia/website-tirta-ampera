@extends('panel::layouts.master')

@section('title', 'Notifikasi')

@push('style')
@endpush

@section('content')
    <x-panel::utils.breadcrumb title="Notifikasi">
        <x-panel::utils.breadcrumb-item page="Notifikasi" />
    </x-panel::utils.breadcrumb>

    <livewire:panel::panel.notification.table />
@endsection

@push('script')
@endpush
