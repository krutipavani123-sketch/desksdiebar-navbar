@role('super_admin')
<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li><a href="{{ route('users.list') }}">Users</a></li>
<li><a href="{{ route('roles.list') }}">Roles</a></li>
<li><a href="{{ route('permissions.permissionlist') }}">Permissions</a></li>
<li><a href="{{ route('team.list') }}">Teams</a></li>
<li><a href="{{ route('customer.ticketlist') }}">Tickets</a></li>
@endrole