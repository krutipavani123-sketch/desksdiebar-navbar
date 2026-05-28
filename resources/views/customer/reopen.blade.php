@extends('layout')

@section('title','ReOpen Ticket')

@section('main')

<h3>{{ $ticket->subject }}</h3>

<p>{{ $ticket->description }}</p>

<hr>

<h5>Comments</h5>
@foreach($ticket->comments as $c)
    <p>{{ $c->comment }}</p>
@endforeach

<hr>

<form method="POST" action="{{ route('customer.reopen', $ticket->id) }}">
@csrf
{{-- 
<textarea name="resolution" class="form-control" placeholder="Resolution note"></textarea> --}}

{{-- <select name="status" class="form-control mt-2">
    <option value="Resolved">Resolved</option>
</select> --}}

<button class="btn btn-success mt-2">
          Reopen Ticket  
</button>

</form>

@endsection