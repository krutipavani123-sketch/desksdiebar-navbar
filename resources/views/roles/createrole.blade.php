@extends('layout')
@section('title', 'Add Permissions')



@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Roles') }}
        </h2>
    </x-slot>

@endsection
@section('main')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
   @include('message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <form action="{{ route('roles.addrole') }}" method="post">
@csrf
                        <div>
                            <label for="" class="text-lg font-medium">Role</label>
                            <div class="my-3">

                                <input value="{{ old('name') }}" name="name" type="text" class="border border-gray-300 shadow-sm w-1/2 rounded-lg">

                                    @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                            </div>

                            <div class="grid grid-cols-4 mt-3">
                                @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                <div class="mt-3">
                                    <input type="checkbox" id="permission-{{ $permission->id }}" class="rounded" name="permission[]" value="{{ $permission->name }}">
                                    <label for="" >{{ $permission->name }}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                             <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
    Save
</button>  
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

@endsection