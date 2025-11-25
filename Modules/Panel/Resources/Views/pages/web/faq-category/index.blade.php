@extends('panel::layouts.master')

@section('title', 'FAQ Categories')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="FAQ Categories" :items="[
        ['label' => 'Home', 'url' => route('panel.web.index')],
        ['label' => 'FAQ', 'url' => route('panel.web.faq.main.index')],
        ['label' => 'FAQ Categories'],
    ]" />
@endsection

@section('content')
    <livewire:panel::main.category.listing group="faqs" create-permission="create-faq-category"
                                           update-permission="update-faq-category" delete-permission="delete-faq-category" />
@endsection

@push('script')
    {{-- --}}
@endpush
