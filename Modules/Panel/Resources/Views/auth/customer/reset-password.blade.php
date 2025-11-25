@extends('front::layouts.auth')

@section('title', 'Update Password')

@push('style')
@endpush

@section('content')
    <livewire:panel::auth.customer.update-password :token="request('token')" />
@endsection

@push('script')
@endpush
