@extends('layouts.admin')

@section('main')

<div class="container">

    <h3>🛠️ Admin Dashboard</h3>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h6>Teams</h6>
                <h2>{{ \App\Models\Team::count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h6>Agents</h6>
                <h2>{{ \App\Models\User::role('support_agent')->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h6>Tickets</h6>
                <h2>{{ \App\Models\Ticket::count() }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection