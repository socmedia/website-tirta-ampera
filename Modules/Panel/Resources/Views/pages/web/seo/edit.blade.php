@extends('panel::layouts.master')

@section('title', 'SEO')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="SEO" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'SEO', 'url' => route('panel.web.seo.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.seo.edit :content="$seo" />
@endsection

@push('script')
    {{--  --}}
@endpush
