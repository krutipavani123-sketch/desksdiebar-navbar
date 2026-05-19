@extends('layouts.superadmin')

@section('title','Super Admin Dashboard')

@section('main')

<div class="container-fluid">

    <h3 class="mb-4">🧠 Super Admin Control Panel</h3>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="card p-3 bg-dark text-white">
                <h6>Total Users</h6>
                <h2>{{ \App\Models\User::count() }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 bg-primary text-white">
                <h6>All Tickets</h6>
                <h2>{{ \App\Models\Ticket::count() }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 bg-success text-white">
                <h6>Teams</h6>
                <h2>{{ \App\Models\Team::count() }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 bg-warning text-dark">
                <h6>Permissions</h6>
                <h2>{{ \Spatie\Permission\Models\Permission::count() }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection