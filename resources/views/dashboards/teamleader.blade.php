@extends('layouts.teamleader')

@section('main')

<div class="container">

    <h3>👨‍💼 Team Leader Panel</h3>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-3 bg-light">
                <h6>My Team Tickets</h6>
                <h2>{{ $myticket }}</h2>
                {{-- <h2>{{ \App\Models\Ticket::where('assigned_team_id', auth()->user()->team_id)->count() }}</h2> --}}
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 bg-light">
                <h6>Open Tickets</h6>
                <h2>{{ $openticket }}</h2>
                {{-- <h2>{{ \App\Models\Ticket::where('status','Open')->count() }}</h2> --}}
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 bg-light">
                <h6>Agents</h6>
                <h2>{{ $agents }}</h2>
                {{-- <h2>{{ \App\Models\User::role('support_agent')->count() }}</h2> --}}
            </div>
        </div>

    </div>

</div>

@endsection