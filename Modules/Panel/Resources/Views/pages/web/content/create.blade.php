@extends('panel::layouts.master')

@section('title', 'Content')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Content" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Content', 'url' => route('panel.web.content.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.content.create />
@endsection

@push('script')
    {{--  --}}
@endpush
