@extends('layout')
@section('title', 'Edit Ticket')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Ticket') }}
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

<div class="py-5 bg-light min-vh-100">

    <div class="container">

        @include('message')

        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 700px;">

            <div class="card-body p-4">

                <form action="{{ route('customer.update',$tickets->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
@method('PUT')

<label class="form-label"><h2>Edit Ticket</h2></label>
        
                    <div class="form-group">
                <label class="form-label">Subject</label>
                <input value="{{ old('subject', $tickets->subject) }}" name="subject" type="text">
                 @error('subject') <p class="error-text">{{ $message }}</p> @enderror
            </div>

         
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description">{{ old('description', $tickets->description) }}</textarea>
                @error('description') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            
    @if(auth()->user()->hasAnyRole(['support_agent','customer'])) 
            <div class="form-group">
                <label class="form-label">comment</label>
            
                <input value="{{ old('comment',optional($tickets->comments->first())->comment) }}" name="comment" type="text">

                 {{-- <input value="{{ old('comment',optional($tickets->comments->latest()->first())->comment) }}" name="comment" type="text"> --}}
            
                 @error('comment') <p class="error-text">{{ $message }}</p> @enderror
            </div>
@endif


           <div class="form-group">
    <label class="form-label">Priority</label>
    <select name="priority" class="form-control">
        <option value="">Select Priority</option>
        <option value="Default" {{ old('priority', $tickets->priority) == 'Default' ? 'selected' : '' }}>Default</option>
        <option value="Low" {{ old('priority', $tickets->priority) == 'Low' ? 'selected' : '' }}>Low</option>
        <option value="Medium" {{ old('priority', $tickets->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
        <option value="High" {{ old('priority', $tickets->priority) == 'High' ? 'selected' : '' }}>High</option>
        <option value="Critical" {{ old('priority', $tickets->priority) == 'Critical' ? 'selected' : '' }}>Critical</option>
    </select>
</div>
{{--          
            <div class="form-group">

                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                <option value="">Select Category</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
            </select>
            </div> --}}

          
           <div class="form-group">
    <label class="form-label">Attachment</label>
    <input type="file" name="attachment" class="form-control">
    
    @if($tickets->attachment)
        <div class="mt-2">
            <p class="small text-muted">Current Image:</p>
           <a href="{{ asset('storage/' . $tickets->attachment) }}" target="_blank">  {{--  open in new tab --}}
                <img src="{{ asset('storage/' . $tickets->attachment) }}" 
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

          
              <div class="form-group">
                <label class="form-label">Status</label>
                <input type="text" name="status" value="Open" readonly>
            </div>

            {{-- @if($ticket->team_id)
        <span class="badge bg-warning">Reassign</span>
    @else
        <span class="badge bg-success">Assign</span>
    @endif --}}
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Save Ticket
            </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection