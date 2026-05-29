@extends('layout')

@section('main')

<style>
    body {
        background: #f4f7fc;
    }

    .dashboard-title {
        font-size: 30px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 30px;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        padding: 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.12);
    }

    .dashboard-card .icon {
        position: absolute;
        top: 18px;
        right: 20px;
        font-size: 42px;
        opacity: 0.25;
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .dashboard-card h2 {
        font-size: 38px;
        font-weight: 700;
        margin: 0;
    }

    /* Card Colors */
    .bg-assigned {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    .bg-resolved {
        background: linear-gradient(135deg, #16a34a, #15803d);
    }

    .bg-pending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .welcome-box {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        border-radius: 18px;
        padding: 25px;
        color: #fff;
        margin-bottom: 30px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.12);
    }

    .welcome-box h4 {
        margin: 0;
        font-weight: 700;
    }

    .welcome-box p {
        margin-top: 8px;
        opacity: 0.8;
    }
</style>

<div class="container py-4">

    <div class="welcome-box">
        <h4>🎧 Support Agent Workbench</h4>
        <p>
            Manage assigned tickets, resolve issues quickly, and track pending requests efficiently.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="dashboard-card bg-assigned">
                <div class="icon">🎫</div>
                <h6>Assigned Tickets</h6>
                <h2>{{ $assignticket }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card bg-resolved">
                <div class="icon">✅</div>
                <h6>Resolved Tickets</h6>
                <h2>{{ $resolved }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card bg-pending">
                <div class="icon">⏳</div>
                <h6>Pending Tickets</h6>
                <h2>{{ $totalpendingticket }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection