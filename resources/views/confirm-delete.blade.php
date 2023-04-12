<!-- resources/views/confirm-delete.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('messages.confirm_delete_title') }}</h1>
        <p>{{ __('messages.confirm_delete_username', ['name' => $user->name]) }}</p>
        <p>{{ __('messages.confirm_delete_email', ['email' => $user->email]) }}</p>
        <form action="{{ route('manageUser.delete') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <button type="submit" class="btn btn-danger">{{ __('messages.confirm_delete_yes') }}</button>
            <a href="{{ url('/manageUser') }}" class="btn btn-primary">{{ __('messages.confirm_delete_no') }}</a>
        </form>
    </div>
@endsection

