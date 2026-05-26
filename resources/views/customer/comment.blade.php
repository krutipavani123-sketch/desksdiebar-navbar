@extends('layout')

@section('title', 'Comment')

@section('header')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Comment') }}
    </h2>
</x-slot>
@endsection

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .wrapper {
        min-height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .card-box {
        width: 100%;
        max-width: 600px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 25px;
    }

    .title {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        margin-top: 12px;
    }

    textarea {
        width: 100%;
        min-height: 120px;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
        resize: vertical;
    }

    textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }

    .checkbox-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #0d6efd, #4a90e2);
        border: none;
        padding: 12px;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn-save:hover {
        transform: scale(1.02);
    }

    .error-text {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="wrapper">

    <div class="card-box">

        <div class="title">Add Comment</div>

        @include('message')

        <form action="{{ url('addcomment') }}" method="POST">
            @csrf

            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            <label class="form-label">Comment</label>
            <textarea name="comment" placeholder="Write your comment...">{{ old('comment') }}</textarea>
            @error('comment') 
                <p class="error-text">{{ $message }}</p> 
            @enderror

            <div class="checkbox-wrap">
                <input type="checkbox" name="is_internal" value="1" {{ old('is_internal') ? 'checked' : '' }}>
                <label>Internal Comment</label>
            </div>

            @error('is_internal')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Add Comment
            </button>

        </form>

    </div>

</div>

@endsection