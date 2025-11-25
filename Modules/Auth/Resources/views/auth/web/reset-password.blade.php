@extends('panel::layouts.auth')

@section('title', 'Update Password')

@push('style')
@endpush

@section('content')
    <livewire:auth::web.update-password :token="request('token')" />
@endsection

@push('script')
@endpush
