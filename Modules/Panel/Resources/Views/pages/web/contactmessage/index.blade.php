@extends('panel::layouts.master')

@section('title', 'Contact Message')

@push('style')
    {{--  --}}
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb title="Contact Message" :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Contact Message']]" />
@endsection

@section('content')
    <livewire:panel::web.contact-message.listing />
@endsection
