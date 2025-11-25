@extends('panel::layouts.master')

@section('title', 'SEO')

@push('style')
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="SEO" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'SEO']]" />
@endsection

@section('content')
    <livewire:panel::web.seo.listing />
@endsection

@push('script')
@endpush
