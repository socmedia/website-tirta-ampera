@extends('panel::layouts.master')

@section('title', 'Permission')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'Permission'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.permission.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
