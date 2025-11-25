@extends('front::layouts.auth')

@section('title', 'Login')

@push('style')
@endpush

@section('content')
    <livewire:auth::customer.login />
@endsection

@push('script')
@endpush
