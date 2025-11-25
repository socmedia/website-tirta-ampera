@extends('panel::layouts.master')

@section('title', 'Static Pages')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Static Pages" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Page']]" />
@endsection

@section('content')
    <livewire:panel::web.page.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
