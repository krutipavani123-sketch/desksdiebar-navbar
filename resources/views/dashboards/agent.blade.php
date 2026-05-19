@extends('layouts.agent')

@section('main')

<div class="container">

    <h3>🎧 Support Agent Workbench</h3>

    <div class="row g-3">

        <div class="col-md-6">
            <div class="card p-3 bg-primary text-white">
                <h6>Assigned Tickets</h6>
                <h2>{{ \App\Models\Ticket::where('agent_id', auth()->id())->count() }}</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 bg-success text-white">
                <h6>Resolved</h6>
                <h2>{{ \App\Models\Ticket::where('agent_id', auth()->id())->where('status','Resolved')->count() }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection