@extends('panel::layouts.master')

@section('title', 'Role')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'Role'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.role.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
