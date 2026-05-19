@extends('layout')

@section('title','My Dashboard')

@section('main')

<div class="container">

    <h3 class="mb-4">🎫 My Tickets Dashboard</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Tickets</h6>
                <h3>{{ \App\Models\Ticket::where('customer_id',auth()->id())->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Open</h6>
                <h3>{{ \App\Models\Ticket::where('customer_id',auth()->id())->where('status','Open')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Resolved</h6>
                <h3>{{ \App\Models\Ticket::where('customer_id',auth()->id())->where('status','Resolved')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Closed</h6>
                <h3>{{ \App\Models\Ticket::where('customer_id',auth()->id())->where('status','Closed')->count() }}</h3>
            </div>
        </div>

    </div>

</div>

@endsection