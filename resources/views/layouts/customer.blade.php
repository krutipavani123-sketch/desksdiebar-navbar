@role('customer')
<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li><a href="{{ route('customer.createticket') }}">Create Ticket</a></li>
<li><a href="{{ route('customer.ticketlist') }}">My Tickets</a></li>
@endrole