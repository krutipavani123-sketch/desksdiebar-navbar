<div class="page-wrapper">
    <div class="card-box">

        <style>
            body { font-family: Arial; background:#f4f6fb; padding:20px; }
            h1 { color:#2c3e50; }
            h2 { color:#34495e; margin-top:20px; }
            table { width:100%; border-collapse: collapse; margin-top:10px; background:#fff; }
            th { background:#2c3e50; color:#fff; padding:10px; }
            td { padding:10px; border:1px solid #ddd; }
            .card { background:#fff; padding:15px; margin-bottom:20px; border-radius:10px; }
        </style>

        <h1>📊 Daily Report Dashboard</h1>

       
        <div class="card">
            <h2>🎫 Ticket Summary</h2>
            <p>Total: {{ $ticketsummary['total'] }}</p>
            <p>Open: {{ $ticketsummary['open'] }}</p>
            <p>Closed: {{ $ticketsummary['close'] }}</p>
            <p>Pending: {{ $ticketsummary['pending'] }}</p>
        </div>

      
        <div class="card">
            <h2>👨‍💻 Agent Performance</h2>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Tickets</th>
                        <th>Closed Tickets</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($agents as $agent)
                        <tr>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->totaltickets }}</td>
                            <td>{{ $agent->closetickets }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    
        <div class="card">
            <h2>⏱ SLA Report</h2>
            <p>❌ Breached: {{ $slabreached }}</p>
            <p>✅ OK: {{ $slaOk }}</p>
        </div>

  
        <div class="card">
            <h2>👤 Customer Report</h2>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Tickets</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->customertickets_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
