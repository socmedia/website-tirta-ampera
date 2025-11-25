@extends('panel::layouts.master')

@section('title', 'Settings')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Settings', 'url' => route('panel.main.setting.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
    <livewire:panel::main.setting.create />
@endsection

@push('script')
    {{--  --}}
@endpush
