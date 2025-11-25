@extends('front::layouts.auth')

@section('title', 'Forgot Password')

@push('style')
@endpush

@section('content')
    <livewire:auth::customer.forgot-password />
@endsection

@push('script')
@endpush
