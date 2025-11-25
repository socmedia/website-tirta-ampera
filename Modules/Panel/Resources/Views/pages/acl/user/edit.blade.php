@extends('panel::layouts.master')

@section('title', 'User')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="User" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'User', 'url' => route('panel.acl.user.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.user.edit :user="$user" />
@endsection

@push('script')
    {{-- --}}
@endpush
