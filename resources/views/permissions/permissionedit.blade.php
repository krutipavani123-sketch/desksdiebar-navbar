@extends('layout')               {{-- inherit layout --}}
@section('title', 'Edit Permissions')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Permissions') }}   {{-- use for multi language --}}
        </h2>
    </x-slot>
@endsection

@section('main')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions/Edit') }}
        </h2>
    </x-slot>

    <div class="py-5 bg-light min-vh-100">

        <div class="container">

            @include('message')

            <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 600px;">

                <div class="card-body p-4">

                    <form action="{{ route('permissions.update',$permission->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="" class="form-label fw-semibold text-dark">
                                Permission
                            </label>

                            <input value="{{ old('name',$permission->name) }}"
                                   name="name"
                                   type="text"
                                   class="form-control shadow-sm rounded-3 border-secondary-subtle">

                            @error('name')           {{-- validation error --}}
                                 <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100 fw-semibold shadow-sm rounded-3">
                            Update
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection