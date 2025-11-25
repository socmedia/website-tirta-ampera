@extends('panel::layouts.master')

@section('title', 'Settings')

@push('style')
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Settings', 'url' => route('panel.main.setting.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::main.setting.edit :setting="$setting" />
@endsection

@push('script')
    @vite(['Modules/Panel/Resources/assets/js/cropper.js'])
@endpush
