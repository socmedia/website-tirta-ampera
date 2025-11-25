@extends('front::layouts.auth')

@section('title', 'Verify Email')

@push('style')
@endpush

@section('content')
    <livewire:panel::auth.customer.verify-email />
@endsection

@push('script')
@endpush
