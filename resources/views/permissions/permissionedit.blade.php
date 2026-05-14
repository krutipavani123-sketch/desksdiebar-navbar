@extends('layout')
@section('title', 'Edit Permissions')



@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Permissions') }}
        </h2>
    </x-slot>

@endsection
@section('main')
   
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions/Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  @include('message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
<form action="{{ route('permissions.update',$permission->id) }}" method="post">
@csrf
@method('PUT')
                        <div>
                            <label for="" class="text-lg font-medium">Permission</label>
                            <div class="my-3">

                                <input value="{{ old('name',$permission->name) }}" name="name" type="text" class="border border-gray-300 shadow-sm w-1/2 rounded-lg">

                                    @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                            </div>
    <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
   Update
</button>      
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

@endsection