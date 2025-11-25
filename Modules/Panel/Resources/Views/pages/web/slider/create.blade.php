@extends('panel::layouts.master')

@section('title', 'Slider')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Slider" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Slider', 'url' => route('panel.web.slider.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.slider.create />
@endsection

@push('script')
    {{--  --}}
@endpush
