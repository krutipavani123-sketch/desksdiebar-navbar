<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>
 {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false, 
        }
    }

    
</script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
       body{
    background:#f4f6fb;
}

/* WHITE SIDEBAR */
.sidebar{
    width:250px;
    height:100vh;
    position:fixed;
    background:#ffffff;
    color:#111827;
    border-right:1px solid #e5e7eb;
    overflow-y:auto;
    box-shadow: 2px 0 10px rgba(0,0,0,0.03);
}

.sidebar a{
    display:block;
    padding:12px 15px;
    color:#374151;
    text-decoration:none;
    transition:0.2s;
    border-radius:6px;
    margin:2px 8px;
}

.sidebar a:hover{
    background:#f3f4f6;
    color:#111827;
}

.sidebar h5{
    color:#111827;
    font-weight:600;
}

.content{
    margin-left:250px;
    padding:20px;
}

.topbar{
    background:white;
    padding:10px 15px;
    border-radius:10px;
    margin-bottom:20px;
}
    </style>
</head>

<body>

@php
$user = auth()->user();
@endphp

<!-- SIDEBAR -->
<div class="sidebar">

    <h5 class="p-3 border-bottom">Desk System</h5>

    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

    @if($user->hasRole('superadmin'))
        {{-- <a href="#">🧠 Super Admin Panel</a> --}}
        <a href="{{ route('roles.list') }}">Roles</a>
        <a href="{{ route('permissions.permissionlist') }}">Permissions</a>
        <a href="{{ route('users.list') }}">Users</a>
        <a href="{{ route('customer.ticketlist') }}">Ticket</a>
        <a href="{{ route('team.list') }}">Team</a>
                <a href="{{ route('internalnote.notelist') }}">Internal Note</a>

    @endif

    @if($user->hasRole('admin'))
        <a href="{{ route('team.list') }}">Teams</a>
        <a href="{{ route('users.list') }}">Users</a>
        <a href="{{ route('customer.ticketlist') }}">Tickets</a>
                <a href="{{ route('internalnote.notelist') }}">Internal Note</a>

    @endif

    @if($user->hasRole('team_leader'))
        {{-- <a href="#">My Team</a> --}}
           {{-- <a href="#">Team Tickets</a> --}}
           <a href="{{ route('team.list') }}">Teams</a>
<a href="{{ route('customer.ticketlist') }}">Team Tickets</a>
        <a href="{{ route('internalnote.notelist') }}">Internal Note</a>
    @endif

    @if($user->hasRole('support_agent'))
        <a href="{{ route('customer.ticketlist') }}">My Tickets</a>
        <a href="{{ route('internalnote.notelist') }}">Internal Note</a>
    @endif

    @if($user->hasRole('customer'))
        <a href="{{ route('customer.createticket') }}">Create Ticket</a>
        <a href="{{ route('customer.ticketlist') }}">My Tickets</a>
    @endif

</div>

<!-- CONTENT -->
<div class="content">

    <div class="topbar d-flex justify-content-between">
        <h5>@yield('title')</h5>

        <div>
<a class="nav-link" href="" data-bs-toggle="dropdown">

     🔔

     @if($unreadnotification > 0)
     <span class="badge bg-danger">
        {{ $unreadnotification }}
     </span>
     @endif
</a>

<ul class="dropdown-menu dropdown-menu-end">
    @forelse ($notifications as $notification)
    <li>
        <a class="dropdown-item" href="{{ url('read',$notification->id) }}">
{{-- 
            {{ dd($notifications) }} --}}
            <strong>{{ $notification->title }}</strong>
            <small>{{ $notification->message }}</small>

        </a>
    </li>
        @empty 
        <li class="dropdown-item">No Notifications</li>
    @endforelse
</ul>



            {{-- <i class="bi bi-bell"></i> --}}
              <a href="{{ url('profile') }}"><i class="bi bi-person ms-3"></i></a>
               <a href="{{ url('logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
        </div>
        
    </div>

    @yield('main')

</div>

</body>
</html> 