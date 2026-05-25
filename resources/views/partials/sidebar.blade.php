<div class="sidebar">

    <div class="sidebar-header">
        <div class="brand">Help<span>Desk</span></div>
    </div>

    <div class="sidebar-menu">

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>

   @if($user->hasRole('superadmin'))

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

        @endif

        @if($user->hasRole('admin'))

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

        @endif

        @if($user->hasRole('team_leader'))

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

        @endif

        @if($user->hasRole('support_agent'))

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-headset"></i>
                <span>My Tickets</span>
            </a>

            <a href="{{ route('internalnote.notelist') }}">
                <i class="bi bi-journal-text"></i>
                <span>Internal Notes</span>
            </a>

        @endif

        @if($user->hasRole('customer'))

            <a href="{{ route('customer.createticket') }}">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Create Ticket</span>
            </a>

            <a href="{{ route('customer.ticketlist') }}">
                <i class="bi bi-ticket-fill"></i>
                <span>My Tickets</span>
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