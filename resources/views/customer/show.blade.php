@extends('layout')

@section('title', 'Comment')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comment') }}
        </h2>
    </x-slot>
@endsection

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .ticket-wrapper {
        min-height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .ticket-card {
        width: 100%;
        max-width: 550px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 25px;
        transition: 0.3s;
    }

    .ticket-card:hover {
        transform: translateY(-3px);
    }

    .tikcket-title {
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
        margin-top: 10px;
        color: #444;
    }

    input[type="textarea"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
    }

    input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #0d6efd, #4a90e2);
        border: none;
        padding: 10px;
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

<div class="ticket-wrapper">

    <div class="ticket-card">

        <div class="ticket-title">
            Reply To Comment
        </div>

        @include('message')

        <h3>
            Replies
        </h3>
    @foreach($ticket->comments as $comment)
    <div style="border:1px solid #ddd; padding: 10px; margin: 10px;">
        <b>{{ $comment->user->name }}</b>
        <p>{{ $comment->comment }}</p>
    </div>
    @endforeach
        <form action="{{ route('addcomment') }}" method="post" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            <textarea name="comment"></textarea>

            <div class="form-group">
                <label class="form-label">is_internal</label>
                  <input type="hidden" name="is_internal" value="0">

<input type="checkbox" name="is_internal" value="1"
{{ old('is_internal') ? 'checked' : '' }}>
                @error('is_internal') <p class="error-text">{{ $message }}</p> @enderror
            </div>

      
                   <div class="form-group">
    <label class="form-label">Attachment</label>
    <input type="file" name="attachment" class="form-control">
    
    @if($comment->attachment)
        <div class="mt-2">
            <p class="small text-muted">Current Image:</p>
            <a href="{{ asset('storage/' . $comment->attachment) }}" target="_blank">
                <img src="{{ asset('storage/' . $comment->attachment) }}" 
                     alt="Attachment" 
                     style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;">
            </a>
             <div class="mt-2">
            <label>
                <input type="checkbox" name="remove_attachment" value="1">
                Remove Image
            </label>
        </div>
        </div>
    @endif
</div>
 <button class="btn-save" type="submit">Reply</button>
        </form>
            {{-- @foreach($ticket->comments as $comment)
    <div>
        <b>{{ $comment->user->name }}</b>
        <p>{{ $comment->comment }}</p>
    </div>
@endforeach 

  @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror --}}

    
    </div>

</div>

@endsection
