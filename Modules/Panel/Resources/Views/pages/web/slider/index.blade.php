@extends('panel::layouts.master')

@section('title', 'Slider')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Slider" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Slider']]" />
@endsection

@section('content')
    <livewire:panel::web.slider.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
