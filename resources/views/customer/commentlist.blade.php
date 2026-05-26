@extends('layout')
@section('title', ' Comment List')




@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket') }}
        </h2>
    </x-slot>

@endsection
@section('main')
      
<style>
body {
    background: #f4f6fb;
}

.page-wrapper {
    padding: 25px;
}

/* CARD */
.card-box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    padding: 20px;
}

/* HEADER */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.header-bar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

/* BUTTONS */
.btn-modern {
    border-radius: 10px;
    font-weight: 600;
    padding: 8px 14px;
    transition: 0.2s;
}

.btn-modern:hover {
    transform: translateY(-2px);
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
}

.table thead {
    background: #111827;
    color: #fff;
}

.table th {
    font-size: 13px;
    font-weight: 600;
    padding: 12px;
    white-space: nowrap;
}

.table td {
    font-size: 13px;
    padding: 12px;
    vertical-align: middle;
}

/* STATUS BADGES */
.badge {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge.open { background:#fff3cd; color:#856404; }
.badge.closed { background:#d1e7dd; color:#0f5132; }
.badge.reopen { background:#cfe2ff; color:#084298; }

/* ACTION ICONS */
.action-icons a {
    margin-right: 10px;
    font-size: 16px;
    transition: 0.2s;
}

.action-icons a:hover {
    transform: scale(1.2);
}
.action-btn{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:#f8f9fa;
    transition:0.2s;
    font-size:16px;
    text-decoration:none;
}

.action-btn:hover{
    transform: translateY(-2px);
    background:#e9ecef;
}
/* CHECKBOX */
input[type="checkbox"] {
    transform: scale(1.2);
}
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

   @include('message')


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

{{-- @can('add ticket') --}}
   {{-- <div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('customer.ticketlist') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm me-2">
         Create Comment
    </button>


 
</div> --}}
<div class="card-box">
 <form action="{{ route('addcomment') }}" method="POST">

                    @csrf

<table id="table"
    class="table table-bordered table-sm"   
    data-toggle="table"
    data-pagination="true"
    data-page-size="5"
    data-side-pagination="client"
    data-height="auto"
     data-search="true"
    data-page-list="[5,10,25,50,100,200,All]">
<div class="card-box mb-3">
    <div class="header-bar">
        <h2>🎫 Comment List</h2>

        <div class="d-flex gap-2">

         
            <a href="{{ route('customer.ticketlist') }}"
               class="btn btn-primary btn-modern">
                +  Create Comment
            </a>
         

           
        </div>
    </div>
</div>




 <thead class="table-dark">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60"  data-sortable="true">No</th>
            <th class="px-6 py-3 text-left">Comment</th> 
            <th class="px-6 py-3 text-left">User Name</th>
            <th class="px-6 py-3 text-left">is_internal</th>  
            <th class="px-6 py-3 text-left">Attachment</th>  
            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

    <tbody class="bg-white">
        @foreach($comments as $comment)

        
        <tr>
    
            <td class="px-6 py-3 text-left" >{{ $comment->id }}</td>
            <td class="px-6 py-3 text-left">{{ $comment->comment }}</td>
   <td class="px-6 py-3 text-left">{{ $comment->user->name }}</td>

   <td class="px-6 py-3 text-left">

 @if($comment->is_internal) 
            <span >
                Internal Note
            </span>
              @else
            Public  
        @endif

   </td>
 <td>
     @if(!empty($comment->attachment))
    <img src="{{ $ticket->attachment ? asset('storage/' . $ticket->attachment) : 'https://via.placeholder.com/80' }}" width="70" height="50">
      @else

        <span class="text-danger">
            No Attachment
        </span>

        @endif
</td>


  <td class="d-flex gap-2 align-items-center">

    <!-- Edit -->
    <a href="{{  route('editcomment', $comment->id) }}"
       class="action-btn text-primary"
       title="Edit Ticket">

        <i class="bi bi-pencil-square"></i>
    </a>

    <!-- Delete -->
    <a href="{{route('delete',$comment->id) }}"
       class="action-btn text-danger"
       title="Delete Ticket"
       onclick="return confirm('Are you sure you want to delete this comment?')">

        <i class="bi bi-trash-fill"></i>
    </a>
        {{-- <td class="px-6 py-3 text-left">

                <a href="{{ route('editcomment', $comment->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>

                <a href="{{ route('delete',$comment->id) }}" ><i class="bi bi-trash2-fill  text-danger"></i></a>
               --}}
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

