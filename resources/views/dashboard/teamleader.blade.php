@extends('layout')

@section('title','Team Leader Dashboard')

@section('main')

<div class="container">

    <h3 class="mb-4">👨‍💼 Team Leader Dashboard</h3>

    @php
        $teamId = DB::table('team_user')
            ->where('user_id', auth()->id())
            ->value('team_id');
    @endphp

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>My Team Tickets</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_team_id',$teamId)->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Open</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_team_id',$teamId)->where('status','Open')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>In Progress</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_team_id',$teamId)->where('status','In Progress')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Resolved</h6>
                <h3>{{ \App\Models\Ticket::where('assigned_team_id',$teamId)->where('status','Resolved')->count() }}</h3>
            </div>
        </div>

    </div>

</div>

@endsection