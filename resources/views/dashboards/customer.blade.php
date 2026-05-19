@extends('layouts.customer')

@section('main')

<div class="container">

    <h3>👤 My Dashboard</h3>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-3">
                <h6>My Tickets</h6>
                <h2>{{ \App\Models\Ticket::where('user_id', auth()->id())->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Open</h6>
                <h2>{{ \App\Models\Ticket::where('user_id', auth()->id())->where('status','Open')->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Resolved</h6>
                <h2>{{ \App\Models\Ticket::where('user_id', auth()->id())->where('status','Resolved')->count() }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection