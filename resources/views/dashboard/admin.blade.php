@extends('layout')

@section('title','Admin Dashboard')

@section('main')

<div class="container">

    <h3 class="mb-4">🛠️ Admin Dashboard</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Teams</h6>
                <h3>{{ \App\Models\Team::count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Agents</h6>
                <h3>{{ \App\Models\User::role('support_agent')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Assigned Tickets</h6>
                <h3>{{ \App\Models\Ticket::whereNotNull('assigned_team_id')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Pending Tickets</h6>
                <h3>{{ \App\Models\Ticket::where('status','Pending')->count() }}</h3>
            </div>
        </div>

    </div>

    <div class="mt-5 card p-3 shadow-sm">
        <h5>Recent Activity</h5>

        <table class="table table-sm">
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Status</th>
            </tr>

            @foreach(\App\Models\Ticket::latest()->take(5)->get() as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->subject }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </table>

    </div>

</div>

@endsection