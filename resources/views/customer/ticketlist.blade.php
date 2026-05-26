 {{-- @can('view tickets') --}}
 
 @extends('layout')
@section('title', ' Ticekt List')




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

{{-- @if(auth()->user()->hasRole('customer'))
   <div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('customer.createticket') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm me-2">
         CreateTicket
    </button>
@endif
      {{-- <button type="button" 
            onclick="window.location.href='{{ route('customer.assignticket') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Assign Ticket
    </button> --}}
{{-- @if(!auth()->user()->hasAnyRole(['support_agent', 'customer']))
     <button type="button"
                        class="btn btn-success btn-sm px-4 py-2 fw-semibold shadow-sm"
                        data-bs-toggle="modal"          {{-- model open 
                        data-bs-target="#assignModal">
                        Assign Ticket
                    </button> 
@endif
                    
</div> --}} 
   {{-- @endcan       --}}
   

{{-- <button type="button"
        class="btn btn-primary btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#assignModal">
    Assign Ticket
</button>
   --}}
<div class="card-box">
 <form action="{{ route('customer.assignticket') }}" method="POST" enctype="multipart/form-data">

                    @csrf

<table id="table"
    class="table table-bordered table-sm"   
    data-toggle="table"
    data-pagination="true"
    data-page-size="5"
    data-side-pagination="client"
    data-height="auto"
     data-search="true"
      data-sortable="true"
    data-page-list="[5,10,25,50,100,200,All]">
<div class="card-box mb-3">
    <div class="header-bar">
        <h2> <i class="bi bi-ticket-detailed-fill"> Ticket List</i></h2>

        <div class="d-flex gap-2">

            @if(auth()->user()->hasRole('customer'))
            <a href="{{ route('customer.createticket') }}"
               class="btn btn-primary btn-modern">
                + Create Ticket
            </a>
            @endif

            @if(!auth()->user()->hasAnyRole(['support_agent', 'customer']))
            <button class="btn btn-success btn-modern"
                    data-bs-toggle="modal"
                    data-bs-target="#assignModal">
                Assign Ticket
            </button>
            @endif

        </div>
    </div>
</div>




  <thead class="table-dark">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60">Select</th>
            <th class="px-6 py-3 text-left" width="60"  data-sortable="true">No</th>
            <th class="px-6 py-3 text-left">Subject</th>
             @if(auth()->user()->hasAnyRole(['support_agent','customer']))    
<th class="px-6 py-3 text-left">Comment</th> 
@endif
            <th class="px-6 py-3 text-left">Description</th>

            <th class="px-6 py-3 text-left">Priority</th>
            <th class="px-6 py-3 text-left" >Category</th>
            <th class="px-6 py-3 text-left">Attachment</th>
            <th class="px-6 py-3 text-left">Status</th>
            @if(auth()->user()->hasRole('support_agent'))
             <th class="px-6 py-3 text-left">Resolve</th>
             @endif
            <th class="px-6 py-3 text-left">Assigned Team</th>
            <th class="px-6 py-3 text-left">Assigned Agent</th>
                        {{-- <th class="px-6 py-3 text-left">Comment</th> --}}
@if(auth()->user()->hasAnyRole(
    'superadmin',
    'admin',
    'team_leader',
    'support_agent'))
             <th class="px-6 py-3 text-left">Internal Note</th>
             @endif
           <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

   <tbody class="bg-white">
        @foreach($tickets as $ticket)

        
        <tr>
            <td class="px-6 py-3 text-left">
     <input type="checkbox" name="ticket_ids[]" value="{{ $ticket->id }}">
</td>
            <td class="px-6 py-3 text-left">{{  $ticket->id }}</td>
            <td class="px-6 py-3 text-left">{{ $ticket->subject }}</td>

    @if(auth()->user()->hasAnyRole(['support_agent','customer']))       
<td class="d-flex gap-2 align-items-center">

    <!-- Add Comment -->
    <a href="{{ route('customer.comment', $ticket->id) }}"
       class="action-btn text-primary"
       title="Add Comment">
        <i class="bi bi-plus-circle-fill"></i>
    </a>

    <!-- View Comments -->
    <a href="{{ route('customer.commentlist', $ticket->id) }}"
       class="action-btn text-success"
       title="View Comments">
        <i class="bi bi-eye-fill"></i>
    </a>

    <!-- Reply -->
    <a href="{{ route('customer.show', $ticket->id) }}"
       class="action-btn text-warning"
       title="Reply">
        <i class="bi bi-reply-fill"></i>
    </a>

</td>
@endif
            <td class="px-6 py-3 text-left">{{  $ticket->description }}</td>
            <td class="px-6 py-3 text-left">{{  $ticket->priority}}</td>
          <td class="px-6 py-3 text-left">{{ $ticket->category->name ?? 'No Category' }}</td>
<td>
     @if(!empty($ticket->attachment))
    <img src="{{ $ticket->attachment ? asset('storage/' . $ticket->attachment) : 'https://via.placeholder.com/80' }}" width="70" height="50">
      @else

        <span class="text-danger">
            No Attachment
        </span>

        @endif
</td>

<td>
  
    <span>
        {{ $ticket->status }}
    </span>
    @if(auth()->user()->hasRole('customer'))
      @if($ticket->status =='Closed')
      <a href="{{route('customer.reopen',$ticket->id)}}"
        class="btn btn-sm btn-primary mt-1">
                  Reopen Ticket
        </a></a>
@endif
@endif
    @if(auth()->user()->hasRole('support_agent') && $ticket->status != 'Closed')
        <br>
        <a href="{{ route('customer.statuspage', $ticket->id) }}" class="btn btn-sm btn-primary mt-1">
            Update Status
        </a>
    @endif
</td>   
  

 @if(auth()->user()->hasRole('support_agent'))
<td>
   
    @if($ticket->status !='Closed') 
    <a href="{{ route('customer.resolve', $ticket->id) }}"
   class="btn btn-sm btn-warning">
   Resolve
</a>
@else
<span>{{ $ticket->status }}</span>
@endif
</td>
@endif


<td> {{ $ticket->team->teamName ?? 'Not Assigned' }} </td>
<td>
    
       {{ $ticket->agent->name ?? 'No Agent' }}
</td>   
@if(auth()->user()->hasAnyRole(
    'superadmin',
    'admin',
    'team_leader',
    'support_agent'))
<td>
     @if(optional($ticket->Note)->note)
        {{ $ticket->Note->note }}
   @else
    <a href="{{ route('shownote', $ticket->id) }}"
   class="btn btn-sm">
   Add Internal Note
</a>
@endif
</td>

@endif

        {{-- <td colspan="10">

            <h5>Comments</h5>

            @foreach($ticket->comments as $comment)
                <div class="border p-2 mb-2">
                    <b>{{ $comment->user->name }}</b>
                    <p>{{ $comment->comment }}</p>
                    <small>{{ $comment->created_at }}</small>
                </div>
            @endforeach

        </td> --}}
{{-- @can('edit ticket') --}}
       <td class="d-flex gap-2 align-items-center">

    <!-- Edit -->
    <a href="{{ route('customer.edit', $ticket->id) }}"
       class="action-btn text-primary"
       title="Edit Ticket">

        <i class="bi bi-pencil-square"></i>
    </a>

    <!-- Delete -->
    <a href="{{ route('customer.delete', $ticket->id) }}"
       class="action-btn text-danger"
       title="Delete Ticket"
       onclick="return confirm('Are you sure you want to delete this ticket?')">

        <i class="bi bi-trash-fill"></i>    
    </a>

</td>
        </tr>
        @endforeach
    </tbody>    
</table>
<div class="modal fade"
                        id="assignModal"
                        tabindex="-1"
                        aria-hidden="true">  
                        {{-- popup --}}

                        <div class="modal-dialog">
                             {{-- center popup --}}

                            <div class="modal-content">
                                 {{-- main box   --}}

                              
                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Assign Team
                                    </h5>

                                    <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>

                                </div>

                         
                                <div class="modal-body">

                                  <select name="team_id" class="form-control" required>
                                    <option value="">Select Team</option>

                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">
                                            {{ $team->teamName }}
                                        </option>
                                    @endforeach
                                </select>
 {{-- <select name="agent_id" class="form-control">
        <option value="">Select Agent</option>

        @foreach($agents as $agent)
            <option value="{{ $agent->id }}">
                {{ $agent->name }}
            </option>
        @endforeach
    </select> --}}
                                </div>

                                <div class="modal-footer">

                                    <button type="submit"
                                        class="btn btn-success">
                                        Assign
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>
             

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


{{-- @endcan --}}