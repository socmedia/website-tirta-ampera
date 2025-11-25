@extends('panel::layouts.master')

@section('title', 'Customer')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Customer" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Customer']]" />
@endsection

@section('content')
    <livewire:panel::web.customer.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
