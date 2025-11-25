@extends('panel::layouts.master')

@section('title', 'FAQ')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="FAQ" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'FAQ']]" />
@endsection

@section('content')
    <livewire:panel::web.faq.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
