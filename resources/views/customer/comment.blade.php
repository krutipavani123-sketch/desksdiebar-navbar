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


<div class="ticket-wrapper">

    <div class="ticket-card">

        <div class="ticket-title">
            Comment
        </div>

        @include('message')

        <form action="{{ route('customer.comment', $ticket->id) }}" method="post" enctype="multipart/form-data">
            @csrf

     
        

         
            <div class="form-group">
                <label class="form-label">Comment</label>
                <textarea name="comment">{{ old('comment') }}</textarea>
                @error('description') <p class="error-text">{{ $message }}</p> @enderror
            </div>

          
        
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Add Comment
            </button>

        </form>

    </div>

</div>

@endsection
