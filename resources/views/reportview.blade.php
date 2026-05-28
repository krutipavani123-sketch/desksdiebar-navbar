
<div class="page-wrapper">

    <div class="card-box">

        <style>

            body{
                font-family: Arial, sans-serif;
                background:#f4f6fb;
                padding:20px;
                color:#333;
            }

            h1{
                color:#2c3e50;
                margin-bottom:25px;
                text-align:center;
            }

            h2{
                color:#34495e;
                margin-bottom:15px;
            }

            .card{
                background:#fff;
                padding:20px;
                margin-bottom:25px;
                border-radius:12px;
                box-shadow:0 2px 10px rgba(0,0,0,0.08);
            }

            .summary-grid{
                display:grid;
                grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
                gap:20px;
            }

            .summary-box{
                padding:20px;
                border-radius:12px;
                color:#fff;
                text-align:center;
            }

            .summary-box h3{
                margin-bottom:10px;
                font-size:18px;
            }

            .summary-box p{
                font-size:28px;
                font-weight:bold;
                margin:0;
            }

            .bg-total{
                background:linear-gradient(135deg,#3498db,#2980b9);
            }

            .bg-open{
                background:linear-gradient(135deg,#f39c12,#d68910);
            }

            .bg-closed{
                background:linear-gradient(135deg,#27ae60,#1e8449);
            }

            .bg-pending{
                background:linear-gradient(135deg,#e74c3c,#c0392b);
            }
            .bg-inprogress{
  background: linear-gradient(135deg, #3498db, #2c80b4);
}

            .bg-sla{
                background:linear-gradient(135deg,#8e44ad,#6c3483);
            }

            table{
                width:100%;
                border-collapse: collapse;
                margin-top:15px;
                overflow:hidden;
                border-radius:10px;
            }

            th{
                background:#2c3e50;
                color:#fff;
                padding:14px;
                text-align:left;
            }

            td{
                padding:14px;
                border-bottom:1px solid #eee;
            }

            tr:nth-child(even){
                background:#f9f9f9;
            }

            tr:hover{
                background:#eef3ff;
            }

            .section-title{
                margin-bottom:20px;
                border-left:5px solid #3498db;
                padding-left:10px;
            }

        </style>

        <h1>📊 Daily Report Dashboard</h1>

  

        <div class="card">

            <h2 class="section-title">🎫 Ticket Summary</h2>

            <div class="summary-grid">

                <div class="summary-box bg-total">
                    <h3>Total Tickets</h3>
                    <p>{{ $ticketsummary['total'] }}</p>
                </div>

                <div class="summary-box bg-open">
                    <h3>Open Tickets</h3>
                    <p>{{ $ticketsummary['open'] }}</p>
                </div>

                <div class="summary-box bg-closed">
                    <h3>Closed Tickets</h3>
                    <p>{{ $ticketsummary['close'] }}</p>
                </div>

                <div class="summary-box bg-pending">
                    <h3>Pending Tickets</h3>
                    <p>{{ $ticketsummary['pending'] }}</p>
                </div>

                <div class="summary-box bg-inprogress">
                    <h3>Progress Tickets</h3>
                    <p>{{ $ticketsummary['inprogress'] }}</p>
                </div>
            </div>

        </div>

    

        <div class="card">

            <h2 class="section-title">👨‍💻 Agent Performance</h2>

            <table>

                <thead>
                    <tr>
                        <th>Agent Name</th>
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

            <h2 class="section-title">⏱ SLA Report</h2>

            <div class="summary-grid">

                <div class="summary-box bg-pending">
                    <h3>SLA Breached</h3>
                    <p>{{ $slabreached }}</p>
                </div>

                <div class="summary-box bg-sla">
                    <h3>SLA OK</h3>
                    <p>{{ $slaOk }}</p>
                </div>

            </div>

        </div>



        <div class="card">

            <h2 class="section-title">👤 Customer Report</h2>

            <table>

                <thead>
                    <tr>
                        <th>Customer Name</th>
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

