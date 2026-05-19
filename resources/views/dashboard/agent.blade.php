@extends('layout')

@section('title','Agent Dashboard')

@section('main')

<div class="container">

    <h3 class="mb-4">🧑‍💻 Agent Dashboard</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>My Tickets</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_agent_id',auth()->id())->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Open</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_agent_id',auth()->id())->where('status','Open')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Pending</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_agent_id',auth()->id())->where('status','Pending')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Resolved</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_agent_id',auth()->id())->where('status','Resolved')->count() }}</h3>
            </div>
        </div>

    </div>

</div>

@endsection