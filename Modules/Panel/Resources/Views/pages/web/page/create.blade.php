@extends('panel::layouts.master')

@section('title', 'Static Pages')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Static Pages" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Page', 'url' => route('panel.web.page.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.page.create />
@endsection

@push('script')
    {{--  --}}
@endpush
