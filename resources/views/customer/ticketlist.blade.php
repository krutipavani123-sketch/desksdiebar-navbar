 {{-- @can('view tickets') --}}
 
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

{{-- @can('add ticket') --}}
   <div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('customer.createticket') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm me-2">
         CreateTicket
    </button>

      {{-- <button type="button" 
            onclick="window.location.href='{{ route('customer.assignticket') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Assign Ticket
    </button> --}}
@if(!auth()->user()->hasAnyRole(['support_agent', 'customer']))
     <button type="button"
                        class="btn btn-success btn-sm px-4 py-2 fw-semibold shadow-sm"
                        data-bs-toggle="modal"          {{-- model open --}}
                        data-bs-target="#assignModal">
                        Assign Ticket
                    </button> 
@endif
                    
</div>
   {{-- @endcan       --}}
   

{{-- <button type="button"
        class="btn btn-primary btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#assignModal">
    Assign Ticket
</button>
   --}}

 <form action="{{ route('customer.assignticket') }}" method="POST" enctype="multipart/form-data">

                    @csrf

<table id="table"
    class="table table-bordered table-sm"   
    data-toggle="table"
    data-pagination="true"
    data-page-size="3"
    data-side-pagination="client"
    data-height="auto"
     data-search="true"
    data-page-list="[3,5,10,25,50,100,200,All]">
<h2>Ticket List</h2>




    <thead class="bg-gray-50">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60">Select</th>
            <th class="px-6 py-3 text-left" width="60">No</th>
            <th class="px-6 py-3 text-left">Subject</th>
             @if(auth()->user()->hasAnyRole(['support_agent','customer']))    
<th class="px-6 py-3 text-left">Comment</th> 
@endif
            <th class="px-6 py-3 text-left">Description</th>

            <th class="px-6 py-3 text-left">Priority</th>
            <th class="px-6 py-3 text-left">Category</th>
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
<td>

    <a href="{{ route('customer.comment', $ticket->id) }}"
      <i class="bi bi-file-earmark-plus text-primary" style="font-size: 1rem;"></i>
    </a>

    <a href="{{ route('customer.commentlist', $ticket->id) }}"
      <i class="bi bi-eye-fill text-success" style="font-size: 1rem;"></i>
  
    </a>

    <a href="{{ route('customer.show', $ticket->id) }}">
   <i class="bi bi-reply-fill"></i>
</a>

</td>
@endif
            <td class="px-6 py-3 text-left">{{  $ticket->description }}</td>
            <td class="px-6 py-3 text-left">{{  $ticket->priority}}</td>
          <td class="px-6 py-3 text-left">{{  $ticket->category }}</td>
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
            <td class="px-6 py-3 text-left">

                <a href="{{ route('customer.edit', $ticket->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>
{{-- @endcan
@can('delete ticket') --}}
                <a href="{{ route('customer.delete',$ticket->id) }}" ><i class="bi bi-trash2-fill text-danger"></i></a>
                {{-- @endcan --}}
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