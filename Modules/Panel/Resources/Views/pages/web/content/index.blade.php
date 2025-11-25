@extends('panel::layouts.master')

@section('title', 'Content')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Content" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Content']]" />
@endsection

@section('content')
    <livewire:panel::web.content.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
