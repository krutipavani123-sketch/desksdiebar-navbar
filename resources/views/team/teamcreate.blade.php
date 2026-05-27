@extends('layout')
@section('title', 'Team List')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team List') }}
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
            Create Team
        </div>

        @include('message')

        <form action="{{ route('team.addteam') }}" method="POST" enctype="multipart/form-data">
            @csrf

     
            <div class="form-group">
                <label class="form-label">TeamName</label>
                <input value="{{ old('teamName') }}" name="teamName" type="text">
                 @error('teamName') <p class="error-text">{{ $message }}</p> @enderror
            </div>

  <div class="form-group">
    <label class="form-label">Select Team Category</label>

    <details style="position: relative; width: 100%; margin-top: 6px;">

        <summary style="display:flex; justify-content:space-between; padding:10px; border:1px solid #ddd; border-radius:10px; background:#fff; cursor:pointer;">
            <span>Select Category</span>
            <span>⌄</span>
        </summary>

        <div style="position:absolute; top:100%; left:0; right:0; z-index:1000; max-height:200px; overflow-y:auto; border:1px solid #ddd; border-radius:10px; background:#fff; padding:10px;">

            <div style="margin-bottom:8px;">
                <input type="radio" name="category_id" value="" id="cat_none" checked>
                <label for="cat_none">No Category</label>
            </div>

            @foreach($categories as $category)
                <div style="margin-bottom:8px;">
                    <input type="radio" name="category_id" value="{{ $category->id }}" id="cat_{{ $category->id }}"  {{ old('category_id', $teams->category_id) == $category->id ? 'checked' : '' }}>  {{-- label click radio select --}}
                    <label for="cat_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach

        </div>
    </details>
</div>
            <div class="form-group">
    <label class="form-label">Select Team Leader</label>
    
    <details class="custom-dropdown" style="position: relative; width: 100%; margin-top: 6px;">
      
        <summary style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; background: #fff; font-size: 14px; color: #444; cursor: pointer; user-select: none; list-style: none;">
            <span>Select Leader</span>
            <span style="border: solid #666; border-width: 0 2px 2px 0; display: inline-block; padding: 3px; transform: rotate(45deg); margin-bottom: 4px;"></span>
        </summary>

       
     <div style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 10px; padding: 12px; background: #fff; margin-top: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">

           <input type="radio" name="leader_id" value="" id="leader_none" checked style="width: auto; margin-top: 0; cursor: pointer; margin-right: 8px;">
                            <label for="leader_none" style="font-size: 14px; color: #999; cursor: pointer; width: 100%;">No Team Leader</label>
                        </div>
                        @foreach($leaders as $leader)
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <input type="radio" name="leader_id" value="{{ $leader->id }}" id="leader_{{ $leader->id }}" {{ old('leader_id') == $leader->id ? 'checked' : '' }} style="width: auto; margin-top: 0; cursor: pointer; margin-right: 8px;">
                                <label for="leader_{{ $leader->id }}" style="font-size: 14px; color: #444; cursor: pointer; width: 100%;">
                                    {{ $leader->name }}   
                                </label>
                            </div>
                        @endforeach


                        
        </div>
        
    </details>
</div>
<div class="form-group">
    <label class="form-label">Select Team Members</label>
    
    <details class="custom-dropdown" style="position: relative; width: 100%; margin-top: 6px;">
      
        <summary style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; background: #fff; font-size: 14px; color: #444; cursor: pointer; user-select: none; list-style: none;">
            <span>Select Members</span>
            <span style="border: solid #666; border-width: 0 2px 2px 0; display: inline-block; padding: 3px; transform: rotate(45deg); margin-bottom: 4px;"></span>
        </summary>

       
        <div style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 10px; padding: 12px; background: #fff; margin-top: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

            @foreach($users as $user)
                <div style="display: flex; align-items: center; margin-bottom: 8px;">
                    <input type="checkbox" name="users[]" value="{{ $user->id }}" id="check_{{ $user->id }}" style="width: auto; margin-top: 0; cursor: pointer;">
                    <label for="check_{{ $user->id }}" style="margin-left: 8px; font-size: 14px; color: #444; cursor: pointer; user-select: none; width: 100%;">
                        {{ $user->name }}   
                    </label>
                </div>
            @endforeach
        </div>
    </details>
</div>



     <div class="form-group">
    <label class="form-label">Select Agent</label>
    
    <details class="custom-dropdown" style="position: relative; width: 100%; margin-top: 6px;">
      
        <summary style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; background: #fff; font-size: 14px; color: #444; cursor: pointer; user-select: none; list-style: none;">
            <span>Select Agent</span>
            <span style="border: solid #666; border-width: 0 2px 2px 0; display: inline-block; padding: 3px; transform: rotate(45deg); margin-bottom: 4px;"></span>
        </summary>

       
     <div style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 10px; padding: 12px; background: #fff; margin-top: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">

           {{-- <input type="radio" name="leader_id" value="" id="leader_none" checked style="width: auto; margin-top: 0; cursor: pointer; margin-right: 8px;">
                            <label for="leader_none" style="font-size: 14px; color: #999; cursor: pointer; width: 100%;">No Team Leader</label>
                        </div> --}}
                       {{-- <div class="form-group">
    <label>Select Agent</label> --}}

    {{-- <select name="assigned_agent_id" class="form-control"> --}}
<div class="form-group">
     <label>Select Agent</label>
        {{-- <input type="checkbox" name="agents[]" value="{{ $user->id }}"> --}}
        {{-- <option value="">Select Agent</option> --}}

        @foreach($teamagents as $user)
    <div style="display:flex; align-items:center; margin-botatom:8px;">
        <input type="checkbox" name="teamagents[]" value="{{ $user->id }}">
        <label style="margin-left:8px;">
            {{ $user->name }}
        </label>
    </div>
@endforeach
    {{-- </select> --}}
</div>

                        
        </div>
        
    </details>
</div>




        
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn-save">
                Save Team
            </button>

        </form>

    </div>

</div>

@endsection

