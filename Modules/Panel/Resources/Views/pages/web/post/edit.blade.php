@extends('panel::layouts.master')

@section('title', 'Post')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Post" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'Post', 'url' => route('panel.web.post.main.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <livewire:panel::web.post.edit :post="$post" />
@endsection

@push('script')
    {{--  --}}
@endpush
