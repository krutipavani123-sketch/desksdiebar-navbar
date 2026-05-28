@extends('layout')
@section('title', 'Create Category ')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>
@endsection

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .ticket-wrapper {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .ticket-card {
        width: 100%;
        max-width: 750px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 28px;
        transition: 0.3s;
    }

    .ticket-card:hover {
        transform: translateY(-3px);
    }

    .ticket-title {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-label {
        font-weight: 600;
        margin-top: 12px;
        display: block;
        color: #444;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
        width: 100%;
        margin-top: 6px;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
        font-size: 14px;
        background: #fff;
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px rgba(13,110,253,0.25);
    }

    .form-group {
        margin-bottom: 12px;
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #0d6efd, #4a90e2);
        border: none;
        padding: 12px;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        margin-top: 18px;
        transition: 0.3s;
    }

    .btn-save:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(13,110,253,0.25);
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
            Create Ticket
        </div>

        @include('message')

         <form method="POST" action="{{ route('categories.store') }}">
            @csrf


<div class="modal-content">
            <div class="modal-header">
                <h5>Add Category</h5>
            </div>

            <div class="modal-body">
                <input type="text" name="name" class="form-control" placeholder="Category Name" required>
            </div>

            
        </div>


            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Save Ticket
            </button>

        </form>

    </div>

</div>

@endsection