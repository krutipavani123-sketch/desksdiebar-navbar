@extends('layout')

@section('main')
<div class="container">
@if(auth()->user()->hasRole('support_agent'))
    <h3>Update Status</h3>
@if($ticket->status != 'Closed')
    <form action="{{ route('customer.updatestatus', $ticket->id) }}" method="POST">
        @csrf

        <select name="status" class="form-control">
            <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
            <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Pending" {{ $ticket->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                 <option value="ReOpened" {{ $ticket->status == 'ReOpened' ? 'selected' : '' }}>ReOpened</option>
            {{-- <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option> --}}
        </select>

        <br>

        <button class="btn btn-success mt-2">Update</button>
    </form>
@endif
</div>
@endsection

@endif