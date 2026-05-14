 
 
 @extends('layout')
@section('title', 'Add Permissions')




@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

@endsection
@section('main')
   


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



   @include('message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

       
             <div class="p-2 text-gray-900 dark:text-gray-100">

<div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('permissions.permissioncreate') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Create Permission
    </button>
</div>



<table id="table"
    class="table table-bordered table-sm"
    data-toggle="table"
    data-pagination="true"
    data-page-size="3"
    data-side-pagination="client"
    data-height="auto"
    data-page-list="[3,5,10,25,50,100,200,All]">



    <thead class="bg-gray-50">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60">No</th>
            <th class="px-6 py-3 text-left">Name</th>
            <th class="px-6 py-3 text-left">Created</th>
            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

    <tbody class="bg-white">
        @foreach($permissions as $permission)
        <tr>
            <td class="px-6 py-3 text-left">{{ $permission->id }}</td>
            <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
            <td class="px-6 py-3 text-left">{{ $permission->created_at->format('d M, Y') }}</td>

            <td class="px-6 py-3 text-left">

                <a href="{{ route('permissions.edit', $permission->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>

                <a href="{{ route('permissions.delete',$permission->id) }}" ><i class="bi bi-trash2-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


            </div>
        </div>
    </div>
    </div>


@endsection




    <style>
.bootstrap-table .fixed-table-container {
    border-bottom: 0 !important;
    height: auto !important;
}

.bootstrap-table .fixed-table-body {
    height: auto !important;
}

.bootstrap-table .fixed-table-pagination {
    margin-top: 5px !important;
}

.bootstrap-table {
    margin-bottom: 0 !important;
}
</style>