@extends('layout')
@section('title', 'Add Permissions')



@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Permissions') }}
        </h2>
    </x-slot>

@endsection
@section('main')
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
   @include('message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <form  action='{{ route('permissions.permissionadd') }}' method="post">
@csrf
{{-- <div class="flex justify-content-end" style="width: 100%;">
    <a href="{{ url('permissions.permissioncreate') }}" type="submit" class="bg-indigo-600 hover:bg-indigo-400 text-white py-2 rounded-xl font-semibold" style="width: 100px;">Create</a>
</div> --}}

                        <div>
                            <label  class="text-gray-500 mt-1">Permission</label>
                            <div class="my-3">

                                <input value="{{ old('name') }}" name="name" type="text" class="w-full mt-2 px-2 py-2 border rounded-xl">

                                    @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                            </div>

                           
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
    Save
</button>

        Save
    </button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

@endsection