@extends('layout')

@section('main')

<style>
    body {
        background: #f4f7fc;
    }

    .dashboard-wrapper {
        padding: 30px 10px;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 25px;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        padding: 25px 20px;
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .dashboard-card h2 {
        font-size: 38px;
        font-weight: bold;
        margin: 0;
    }

    .dashboard-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 45px;
        opacity: 0.2;
    }

    .bg-total {
        background: linear-gradient(135deg, #4e73df, #224abe);
    }

    .bg-open {
        background: linear-gradient(135deg, #1cc88a, #13855c);
    }

    .bg-resolved {
        background: linear-gradient(135deg, #36b9cc, #258391);
    }

    .bg-overdue {
        background: linear-gradient(135deg, #e74a3b, #be2617);
    }

    @media(max-width:768px) {
        .dashboard-card {
            margin-bottom: 15px;
        }
    }
</style>

<div class="container dashboard-wrapper">

    <div class="dashboard-title">
        👋 Welcome, {{ auth()->user()->name }}
    </div>

    <div class="row g-4">

        {{-- Total Tickets --}}
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card bg-total">
                <div class="dashboard-icon">
                    🎫
                </div>

                <h6>Total Tickets</h6>
                <h2>{{ $ticket }}</h2>
            </div>
        </div>

        {{-- Open Tickets --}}
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card bg-open">
                <div class="dashboard-icon">
                    📂
                </div>

                <h6>Open Tickets</h6>
                <h2>{{ $openticket }}</h2>
            </div>
        </div>

        {{-- Resolved --}}
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card bg-resolved">
                <div class="dashboard-icon">
                    ✅
                </div>

                <h6>Resolved</h6>
                <h2>{{ $resolved }}</h2>
            </div>
        </div>

        {{-- Overdue --}}
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card bg-overdue">
                <div class="dashboard-icon">
                    ⏰
                </div>

                <h6>Overdue</h6>
                <h2>{{ $overdue ?? 0 }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection