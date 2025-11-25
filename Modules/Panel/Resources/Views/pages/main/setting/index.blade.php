@extends('panel::layouts.master')

@section('title', 'My Account')

@push('style')
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Settings']]" />
@endsection

@section('content')
    <livewire:panel::main.setting.listing />
@endsection

@push('script')
    @vite(['Modules/Panel/Resources/assets/js/cropper.js'])
@endpush
