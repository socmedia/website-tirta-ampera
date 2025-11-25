@extends('panel::layouts.master')

@section('title', 'Session')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Session" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Access Control', 'url' => route('panel.acl.index')],
        ['label' => 'Session'],
    ]" />
@endsection

@section('content')
    <livewire:panel::acl.session.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
