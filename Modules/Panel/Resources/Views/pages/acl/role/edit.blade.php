@extends('panel::layouts.master')

@section('title', 'Role')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'Role', 'url' => route('panel.acl.role.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.role.edit :role="$role" />
@endsection

@push('script')
    {{-- --}}
@endpush
