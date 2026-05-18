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

    
            @foreach($ticket->comments as $comment)
    <div>
        <b>{{ $comment->user->name }}</b>
        <p>{{ $comment->comment }}</p>
    </div>
@endforeach 

  @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror

    
    </div>

</div>

@endsection
