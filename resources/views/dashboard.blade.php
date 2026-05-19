@extends('layout')

@section('title','Dashboard')

@section('main')

<div class="row g-3">

    @if(auth()->user()->hasRole('super_admin'))
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3">
            <h5>Total Users</h5>
            <h3>{{ $totalUsers }}</h3>
        </div>
    </div>
    @endif

    <div class="col-md-3">
        <div class="card bg-success text-white p-3">
            <h5>Total Tickets</h5>
            <h3>{{ $totalTickets }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white p-3">
            <h5>Open Tickets</h5>
            <h3>{{ $openTickets }}</h3>
        </div>
    </div>

    @if(auth()->user()->hasRole('support_agent'))
    <div class="col-md-3">
        <div class="card bg-info text-white p-3">
            <h5>Assigned Tickets</h5>
            <h3>{{ $assignedTickets }}</h3>
        </div>
    </div>
    @endif

</div>

@endsection