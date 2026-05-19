@extends('layout')

@section('title','Super Admin Dashboard')

@section('main')

<div class="container">

    <h3 class="mb-4">👑 Super Admin Dashboard</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Users</h5>
                <h3>{{ \App\Models\User::count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Tickets</h5>
                <h3>{{ \App\Models\Ticket::count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Open Tickets</h5>
                <h3>{{ \App\Models\Ticket::where('status','Open')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Closed Tickets</h5>
                <h3>{{ \App\Models\Ticket::where('status','Closed')->count() }}</h3>
            </div>
        </div>

    </div>

    <div class="mt-5">
        <div class="card p-3 shadow-sm">
            <h5>Recent Tickets</h5>

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

</div>

@endsection