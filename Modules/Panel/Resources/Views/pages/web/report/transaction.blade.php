@extends('panel::layouts.master')

@section('title', 'Transaksi')

@push('style')
@endpush

@section('content')
    <x-panel::utils.breadcrumb title="Transaksi">
        <x-panel::utils.breadcrumb-item href="javascript:void(0)" page="Laporan" />
        <x-panel::utils.breadcrumb-item page="Transaksi" />
    </x-panel::utils.breadcrumb>

    <livewire:panel::panel.report.transaction />
@endsection

@push('script')
    {{-- --}}
@endpush
