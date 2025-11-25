@extends('panel::layouts.master')

@section('title', 'Access Control')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Access Control" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Access Control']]" />
@endsection

@section('content')
    <livewire:panel::acl.dashboard />
@endsection

@push('script')
    {{-- --}}
@endpush
