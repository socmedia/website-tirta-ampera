@extends('panel::layouts.auth')

@section('title', 'Login')

@push('style')
@endpush

@section('content')
    <livewire:auth::web.login />
@endsection

@push('script')
@endpush
