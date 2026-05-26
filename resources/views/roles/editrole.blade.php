@extends('layout')
@section('title', 'Edit Roles')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Roles') }}
        </h2>
    </x-slot>
@endsection

@section('main')

<div class="py-5 bg-light min-vh-100">

    <div class="container">

        @include('message')

        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 700px;">

            <div class="card-body p-4">

                <form action="{{ route('roles.update',$roles->id) }}" method="post">
                    @csrf

               
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            Edit Permission
                        </label>

                        <input value="{{ old('name',$roles->name) }}"
                               name="name"
                               type="text"
                               class="form-control shadow-sm rounded-3 border-secondary-subtle">

                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

            
                    <div class="mt-4">
                        <label class="form-label fw-semibold text-dark mb-2">
                            Permissions
                        </label>

                        <div class="row g-3">

                            @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                    <div class="col-6 col-md-3">

                                        <div class="form-check">
                                            <input
                                                {{ $hasPermissions->contains($permission->name)? 'checked':'' }}
                                                type="checkbox"
                                                id="permission-{{ $permission->id }}"
                                                class="form-check-input shadow-sm"
                                                name="permission[]"
                                                value="{{ $permission->name }}">

                                            <label class="form-check-label small"
                                                   for="permission-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>

                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                            class="btn btn-primary w-100 fw-semibold shadow-sm rounded-3 mt-4">
                        Update
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection