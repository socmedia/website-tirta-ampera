@extends('front::layouts.auth')

@section('title', 'Register')

@push('style')
@endpush

@section('content')
    <livewire:auth::customer.register />
@endsection

@push('script')
@endpush
