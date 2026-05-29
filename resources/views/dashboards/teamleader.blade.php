@extends('layout')

@section('main')

<style>
    body {
        background: #f4f7fc;
    }

    .leader-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: white;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .leader-header h3 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .leader-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.14);
    }

    .dashboard-card .icon {
        position: absolute;
        top: 18px;
        right: 20px;
        font-size: 42px;
        opacity: 0.22;
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
        opacity: 0.92;
    }

    .dashboard-card h2 {
        font-size: 38px;
        font-weight: 700;
        margin: 0;
    }

    /* Gradient Colors */
    .bg-ticket {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    .bg-open {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .bg-agent {
        background: linear-gradient(135deg, #10b981, #059669);
    }
</style>

<div class="container py-4">

    <div class="leader-header">
        <h3>👨‍💼 Team Leader Panel</h3>
        <p>
            Track team performance, monitor open tickets, and manage support agents efficiently.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="dashboard-card bg-ticket">
                <div class="icon">🎫</div>
                <h6>My Team Tickets</h6>
                <h2>{{ $myticket }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card bg-open">
                <div class="icon">📂</div>
                <h6>Open Tickets</h6>
                <h2>{{ $openticket }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card bg-agent">
                <div class="icon">🧑‍💻</div>
                <h6>Support Agents</h6>
                <h2>{{ $agents }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection