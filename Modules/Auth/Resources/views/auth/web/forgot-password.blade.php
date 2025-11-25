@extends('panel::layouts.auth')

@section('title', 'Forgot Password')

@push('style')
@endpush

@section('content')
    <livewire:auth::web.forgot-password />
@endsection

@push('script')
@endpush
