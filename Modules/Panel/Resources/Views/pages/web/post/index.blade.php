@extends('panel::layouts.master')

@section('title', 'Post')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Post" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Post']]" />
@endsection

@section('content')
    <livewire:panel::web.post.listing />
@endsection

@push('script')
    {{-- --}}
@endpush
