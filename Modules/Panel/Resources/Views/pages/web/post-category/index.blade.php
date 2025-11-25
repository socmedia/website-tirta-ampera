@extends('panel::layouts.master')

@section('title', 'Post Categories')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Post Categories" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Post', 'url' => null],
        ['label' => 'Post Categories'],
    ]" />
@endsection

@section('content')
    <livewire:panel::main.category.listing group="posts" create-permission="create-post-category"
                                           update-permission="update-post-category"
                                           delete-permission="delete-post-category" />
@endsection

@push('script')
    {{-- --}}
@endpush
