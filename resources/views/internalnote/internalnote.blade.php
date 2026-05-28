@extends('layout')

@section('title', 'internalnote')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('internalnote') }}
        </h2>
    </x-slot>
@endsection

@section('main')
<style>
    body {
        background: #f4f6fb;
    }

    .note-wrapper {
        min-height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .note-card {
        width: 100%;
        max-width: 550px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 25px;
        transition: 0.3s;
    }

    .note-card:hover {
        transform: translateY(-3px);
    }

    .note-title {
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


<div class="note-wrapper">

    <div class="note-card">

        <div class="note-title">
            InternalNote
        </div>

        @include('message')

        <form action="{{ route('notes', $ticket->id) }}" method="post" enctype="multipart/form-data">
            @csrf


    <div class="form-group">

        <label class="form-label">
            Note
        </label>

        <textarea
            name="note"
            class="form-control"></textarea>

    </div>

    @error('note')

        <p class="error-text">
            {{ $message }}
        </p>

    @enderror

    <button type="submit"
            class="btn-save">

        Add Note

    </button>

</form>
     {{-- @if(!auth()->user()->hasRole('customer'))
<h2>Internal Note</h2>   

@foreach($ticket->internalnote as $note)

<div class="card p-2 mb-2">
            <strong>{{ $note->user->name }}</strong>
            <p>{{ $note->note }}</p>
        </div>

    @endforeach

@endif --}}
{{-- <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
         
            <div class="form-group">
                <label class="form-label">Comment</label>
                <textarea name="comment">{{ old('comment') }}</textarea>
                @error('comment') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">is_internal</label>
                <input type="checkbox" name="is_internal">{{ old('is_internal') }} is_internal</input>
                @error('is_internal') <p class="error-text">{{ $message }}</p> @enderror
            </div> --}}
          
        
            {{-- @error('note')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Add Note
            </button>

        </form>

    </div>

</div> --}}

@endsection
