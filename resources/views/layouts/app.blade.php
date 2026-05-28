<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f1f5f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x:hidden;
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:linear-gradient(180deg,#111827,#1f2937);
            color:white;
            overflow-y:auto;
            z-index:999;
            transition:0.3s;
            box-shadow:4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header{
            padding:24px 20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .brand{
            font-size:22px;
            font-weight:700;
            color:#fff;
        }

        .brand span{
            color:#60a5fa;
        }

        .sidebar-menu{
            padding:15px 10px;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px 15px;
            color:#d1d5db;
            text-decoration:none;
            border-radius:12px;
            margin-bottom:8px;
            transition:0.25s;
            font-size:15px;
            font-weight:500;
        }

        .sidebar-menu a:hover{
            background:rgba(255,255,255,0.08);
            color:white;
            transform:translateX(4px);
        }

        .sidebar-menu a.active{
            background:linear-gradient(135deg,#2563eb,#3b82f6);
            color:white;
            box-shadow:0 8px 20px rgba(37,99,235,0.3);
        }

        .sidebar-menu i{
            font-size:18px;
        }

        /* CONTENT */

        .main-content{
            margin-left:260px;
            min-height:100vh;
            padding:25px;
        }

        /* TOPBAR */

        .topbar{
            background:white;
            border-radius:18px;
            padding:18px 24px;
            margin-bottom:25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 5px 18px rgba(0,0,0,0.05);
        }

        .page-title{
            font-size:24px;
            font-weight:700;
            color:#111827;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:18px;
        }

        .icon-btn{
            position:relative;
            color:#374151;
            font-size:22px;
            text-decoration:none;
            transition:0.2s;
        }

        .icon-btn:hover{
            color:#2563eb;
            transform:translateY(-2px);
        }

        .notification-badge{
            position:absolute;
            top:-5px;
            right:-8px;
            background:#ef4444;
            color:white;
            font-size:11px;
            border-radius:50%;
            width:18px;
            height:18px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        /* DROPDOWN */

        .dropdown-menu{
            border:none;
            border-radius:14px;
            box-shadow:0 10px 25px rgba(0,0,0,0.1);
            overflow:hidden;
            padding:8px;
        }

        .dropdown-item{
            border-radius:10px;
            padding:10px 12px;
            transition:0.2s;
        }

        .dropdown-item:hover{
            background:#eff6ff;
        }

        /* RESPONSIVE */

        @media(max-width:991px){

            .sidebar{
                width:80px;
            }

            .sidebar .brand,
            .sidebar-menu span{
                display:none;
            }

            .main-content{
                margin-left:80px;
            }

            .sidebar-menu a{
                justify-content:center;
            }
        }

        @media(max-width:768px){

            .sidebar{
                position:relative;
                width:100%;
                height:auto;
            }

            .main-content{
                margin-left:0;
            }

            .topbar{
                flex-direction:column;
                gap:15px;
                align-items:flex-start;
            }
        }
    </style>
</head>

<body>

@php
    $user = auth()->user();
@endphp

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">
        <div class="brand">
            Help<span>Desk</span>
        </div>
    </div>

    <div class="sidebar-menu">

        <a href="{{ route('dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>

        {{-- @if($user->hasRole('superadmin')) --}}
@if(auth()->check() && auth()->user()->hasRole('superadmin'))
            <a href="{{ route('roles.list') }}">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Roles</span>
            </a>

            <a href="{{ route('permissions.permissionlist') }}">
                <i class="bi bi-key-fill"></i>
                <span>Permissions</span>
            </a>

            <a href="{{ route('users.list') }}">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-ticket-detailed-fill"></i>
                <span>Tickets</span>
            </a>

            <a href="{{ route('team.list') }}">
                <i class="bi bi-diagram-3-fill"></i>
                <span>Teams</span>
            </a>

            <a href="{{ route('internalnote.notelist') }}">
                <i class="bi bi-journal-text"></i>
                <span>Internal Notes</span>
            </a>

             <a href="{{ route('categories.list') }}">
                <i class="bi bi-list-ul"></i>
                <span>Category</span>
            </a>

             <a href="{{ route('reports') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Reports</span>
            </a>
        @endif

        {{-- @if($user->hasRole('admin')) --}}

@if(auth()->check() && auth()->user()->hasRole('admin'))
            <a href="{{ route('team.list') }}">
                <i class="bi bi-diagram-3-fill"></i>
                <span>Teams</span>
            </a>

            <a href="{{ route('users.list') }}">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-ticket-detailed-fill"></i>
                <span>Tickets</span>
            </a>

            <a href="{{ route('internalnote.notelist') }}">
                <i class="bi bi-journal-text"></i>
                <span>Internal Notes</span>
            </a>
 <a href="{{ route('categories.list') }}">
                  <i class="bi bi-list-ul"></i>
                <span>Category</span>
            </a>

             <a href="{{ route('reports') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Reports</span>
            </a>
        @endif

     @if(auth()->check() && auth()->user()->hasRole('team_leader'))

            <a href="{{ route('team.list') }}">
                <i class="bi bi-diagram-3-fill"></i>
                <span>Teams</span>
            </a>

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-ticket-perforated-fill"></i>
                <span>Team Tickets</span>
            </a>

            <a href="{{ route('internalnote.notelist') }}">
                <i class="bi bi-journal-text"></i>
                <span>Internal Notes</span>
            </a>
 <a href="{{ route('categories.list') }}">
                  <i class="bi bi-list-ul"></i>
                <span>Category</span>
            </a>
            <a href="{{ route('monitor') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Team Reports</span>
            </a>
        @endif

        @if(auth()->check() && auth()->user()->hasRole('support_agent'))

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-headset"></i>
                <span>My Tickets</span>
            </a>

            <a href="{{ route('internalnote.notelist') }}">
                <i class="bi bi-journal-text"></i>
                <span>Internal Notes</span>
            </a>
 <a href="{{ route('categories.list') }}">
                  <i class="bi bi-list-ul"></i>
                <span>Category</span>
            </a>
        @endif

        @if(auth()->check() && auth()->user()->hasRole('customer'))

            <a href="{{ route('customer.createticket') }}">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Create Ticket</span>
            </a>

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-ticket-fill"></i>
                <span>My Tickets</span>
            </a>
 <a href="{{ route('categories.list') }}">
                  <i class="bi bi-list-ul"></i>
                <span>Category</span>
            </a>
        @endif

    </div>

</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="page-title">
            @yield('title')
        </div>

        <div class="topbar-right">

            <!-- Notifications -->
            <div class="dropdown">

                <a href="#" class="icon-btn" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>

                    @if($unreadnotification > 0)
                        <span class="notification-badge">
                            {{ $unreadnotification }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    @forelse ($notifications as $notification)

                        <li>
                            <a class="dropdown-item" href="{{ url('read',$notification->id) }}">
                                <strong>{{ $notification->title }}</strong><br>

                                <small class="text-muted">
                                    {{ $notification->message }}
                                </small>
                            </a>
                        </li>

                    @empty

                        <li class="dropdown-item text-muted">
                            No Notifications
                        </li>

                    @endforelse

                </ul>

            </div>

            <!-- Profile -->
            <a href="{{ url('profile') }}" class="icon-btn">
                <i class="bi bi-person-circle"></i>
            </a>

            <!-- Logout -->
            <a href="{{ url('logout') }}" class="icon-btn">
                <i class="bi bi-box-arrow-right"></i>
            </a>

        </div>

    </div>

    <!-- PAGE CONTENT -->
    @yield('main')

</div>

</body>
</html>