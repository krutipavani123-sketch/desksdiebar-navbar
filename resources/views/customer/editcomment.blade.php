@extends('layout')

@section('title', 'Edit Comment')

@section('header')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Comment') }}
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
        color: #444;
    }

    textarea {
        width: 100%;
        min-height: 120px;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        resize: vertical;
        transition: 0.2s;
    }

    textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }

    .checkbox-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
    }

    .file-box {
        margin-top: 15px;
        padding: 12px;
        border: 1px dashed #ddd;
        border-radius: 10px;
        background: #fafafa;
    }

    .file-preview img {
        max-width: 140px;
        border-radius: 8px;
        margin-top: 8px;
        border: 1px solid #ddd;
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
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<div class="wrapper">

    <div class="card-box">

        <div class="title">Edit Comment</div>

        @include('message')

        <form action="{{ url('update', $comment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            {{-- COMMENT --}}
            <label class="form-label">Comment</label>
            <textarea name="comment" placeholder="Update your comment...">{{ old('comment', $comment->comment) }}</textarea>
            @error('comment')
                <p class="error-text">{{ $message }}</p>
            @enderror

            {{-- INTERNAL --}}
            <div class="checkbox-wrap">
                <input type="hidden" name="is_internal" value="0">
                <input type="checkbox" name="is_internal" value="1"
                    {{ old('is_internal', $comment->is_internal) ? 'checked' : '' }}>
                <label>Internal Comment</label>
            </div>

            {{-- ATTACHMENT --}}
            <div class="file-box">
                <label class="form-label">Attachment</label>
                <input type="file" name="attachment" class="form-control">

                @if($comment->attachment)
                    <div class="file-preview">
                        <p class="text-muted mt-2">Current File:</p>

                        <a href="{{ asset('storage/' . $comment->attachment) }}" target="_blank">
                            <img src="{{ asset('storage/' . $comment->attachment) }}" alt="Attachment">
                        </a>

                        <div class="mt-2">
                            <label>
                                <input type="checkbox" name="remove_attachment" value="1">
                                Remove attachment
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn-save">
                Update Comment
            </button>

        </form>

    </div>

</div>

@endsection