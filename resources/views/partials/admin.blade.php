@role('admin')

<div class="sidebar-section">

    <div class="sidebar-title">
        <i class="bi bi-shield-check"></i>
        <span>Admin Panel</span>
    </div>

    <ul class="sidebar-menu-list">

        <li>
            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('team.list') }}" class="sidebar-link">
                <i class="bi bi-diagram-3-fill"></i>
                <span>Teams</span>
            </a>
        </li>

        <li>
            <a href="{{ route('customer.ticketlist') }}" class="sidebar-link">
                <i class="bi bi-ticket-detailed-fill"></i>
                <span>Tickets</span>
            </a>
        </li>

    </ul>

</div>

@endrole