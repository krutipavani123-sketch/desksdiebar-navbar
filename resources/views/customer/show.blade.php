@extends('layout')

@section('title', 'Comment')

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        padding: 30px;
    }

    .card-box {
        width: 100%;
        max-width: 750px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        padding: 25px;
    }

    .title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .comment-box {
        border: 1px solid #eee;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 10px;
        background: #fafafa;
    }

    .comment-user {
        font-weight: 600;
        font-size: 14px;
        color: #111;
    }

    .comment-text {
        margin-top: 5px;
        font-size: 14px;
        color: #444;
    }

    textarea {
        width: 100%;
        min-height: 90px;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ddd;
        outline: none;
        margin-top: 10px;
    }

    textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }

    .form-row {
        margin-top: 12px;
    }

    .btn-save {
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg,#0d6efd,#4a90e2);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save:hover {
        transform: scale(1.02);
    }

    .checkbox-label {
        font-size: 14px;
        color: #444;
        margin-left: 5px;
    }

    .section-title {
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 16px;
    }
</style>

<div class="page-wrapper">

    <div class="card-box">

        <div class="title">
            Reply To Ticket
        </div>

        @include('message')

        {{-- COMMENTS LIST --}}
        <div class="section-title">Replies</div>

        @forelse($ticket->comments as $comment)
            <div class="comment-box">
                <div class="comment-user">
                    {{ $comment->user->name ?? 'Unknown User' }}
                </div>
                <div class="comment-text">
                    {{ $comment->comment }}
                </div>
            </div>
        @empty
            <p>No comments yet.</p>
        @endforelse


        {{-- REPLY FORM --}}
        <form action="{{ route('addcomment') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            <textarea name="comment" placeholder="Write your reply...">{{ old('comment') }}</textarea>

            <div class="form-row">
                <input type="hidden" name="is_internal" value="0">

                <label>
                    <input type="checkbox" name="is_internal" value="1" {{ old('is_internal') ? 'checked' : '' }}>
                    <span class="checkbox-label">Internal Comment</span>
                </label>
            </div>

            <div class="form-row">
                <input type="file" name="attachment" class="form-control">
            </div>

            <button type="submit" class="btn-save">
                Reply
            </button>
        </form>

    </div>
</div>

@endsection