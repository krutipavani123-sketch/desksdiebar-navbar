@extends('layout')
@section('title', 'Add Permissions')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Permissions') }}
        </h2>
    </x-slot>
@endsection

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .permission-wrapper {
        min-height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .permission-card {
        width: 100%;
        max-width: 550px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 25px;
        transition: 0.3s;
    }

    .permission-card:hover {
        transform: translateY(-3px);
    }

    .permission-title {
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

    input[type="text"] {
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

<div class="permission-wrapper">

    <div class="permission-card">

        @include('message')

        <form action="{{ route('permissions.permissionadd') }}" method="post">
            @csrf

            <div class="permission-title">
                Add Permission
            </div>

            <div>
                <label class="form-label">Permission</label>

                <input value="{{ old('name') }}"
                       name="name"
                       type="text">

                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-save">
                Save
            </button>

        </form>

    </div>

</div>

@endsection