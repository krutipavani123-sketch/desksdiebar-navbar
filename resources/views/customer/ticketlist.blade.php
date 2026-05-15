 @extends('layout')
@section('title', ' Ticekt List')




@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket') }}
        </h2>
    </x-slot>

@endsection
@section('main')
      

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

   @include('message')


            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
   <div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('customer.createticket') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         CreateTicket
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
            <th class="px-6 py-3 text-left">Subject</th>
            <th class="px-6 py-3 text-left">Description</th>

            <th class="px-6 py-3 text-left">Priority</th>
            <th class="px-6 py-3 text-left">Category</th>
            <th class="px-6 py-3 text-left">Attachment</th>
            <th class="px-6 py-3 text-left">Status</th>
           <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

   <tbody class="bg-white">
        @foreach($tickets as $ticket)
        <tr>
            <td class="px-6 py-3 text-left">{{  $ticket->id }}</td>
            <td class="px-6 py-3 text-left">{{ $ticket->subject }}</td>
            <td class="px-6 py-3 text-left">{{  $ticket->description }}</td>
            <td class="px-6 py-3 text-left">{{  $ticket->priority}}</td>
          <td class="px-6 py-3 text-left">{{  $ticket->category }}</td>
    


<td>
    <img src="{{ $ticket->attachment ? asset('storage/' . $ticket->attachment) : 'https://via.placeholder.com/80' }}" width="70" height="50">
</td>


<td class="px-6 py-3 text-left">{{ $ticket->status }}</td>


            <td class="px-6 py-3 text-left">

                <a href="{{ route('customer.edit', $ticket->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>

                <a href="{{ route('customer.delete',$ticket->id) }}" ><i class="bi bi-trash2-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>    
</table>
{{-- <div class="my-3">
{{ $roles->links() }}
</div> --}}

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