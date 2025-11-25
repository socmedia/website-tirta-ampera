@extends('panel::layouts.master')

@section('title', 'Customer')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Customer" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Customer', 'url' => route('panel.web.customer.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.customer.edit :customer="$customer" />
@endsection

@push('script')
    {{-- --}}
@endpush
