@extends('layout')               {{-- inherit layout --}}
@section('title', 'Edit Note')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Note') }}   {{-- use for multi language --}}
        </h2>
    </x-slot>
@endsection

@section('main')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Note/Edit') }}
        </h2>
    </x-slot>

    <div class="py-5 bg-light min-vh-100">

        <div class="container">

            @include('message')

            <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 600px;">

                <div class="card-body p-4">

                    <form action="{{ route('note.update',$note->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="" class="form-label fw-semibold text-dark">
                              Note
                            </label>

                            <input value="{{ old('note',$note->note) }}"
                                   name="note"
                                   type="text"
                                   class="form-control shadow-sm rounded-3 border-secondary-subtle">

                            @error('note')           {{-- validation error --}}
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