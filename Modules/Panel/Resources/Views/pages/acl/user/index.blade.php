@extends('panel::layouts.master')

@section('title', 'User')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'User'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.user.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
