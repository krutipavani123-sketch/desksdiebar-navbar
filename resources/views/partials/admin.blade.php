@role('admin')
<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li><a href="{{ route('team.list') }}">Teams</a></li>
<li><a href="{{ route('customer.ticketlist') }}">Tickets</a></li>
@endrole