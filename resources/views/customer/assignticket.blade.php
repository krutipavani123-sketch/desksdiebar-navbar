{{-- <h2>Assign Ticket</h2>

<p>Ticket: {{ $ticket->subject }}</p>

<form method="POST" action="/tickets/assign">
@csrf

<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

<select name="team_id">
    @foreach($teams as $team)
        <option value="{{ $team->id }}">{{ $team->teamName }}</option>
    @endforeach
</select>

<select name="agent_id"></select>

<button type="submit">Assign</button>

</form> --}}

<div class="modal fade" id="assignModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('customer.assign.ticket') }}" method="POST">
        @csrf

        <div class="modal-content">

            <div class="modal-header">
                <h5>Assign Ticket</h5>
            </div>

            <div class="modal-body">

                <!-- Support Agents Dropdown -->
                <label>Select Support Agent</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Select Agent --</option>

                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Hidden tickets -->
                <div id="selectedTickets"></div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    Assign
                </button>
            </div>

        </div>
    </form>
  </div>
</div>