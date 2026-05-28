<div class="page-wrapper">

    <div class="card-box">

        <style>

            body{
                font-family: 'Segoe UI', Arial, sans-serif;
                background:#eef2f7;
                padding:20px;
                color:#2c3e50;
            }

            h1{
                text-align:center;
                margin-bottom:30px;
                font-size:28px;
                font-weight:700;
            }

            .card{
                background:#fff;
                padding:25px;
                margin-bottom:25px;
                border-radius:14px;
                box-shadow:0 4px 12px rgba(0,0,0,0.08);
            }

            .section-title{
                font-size:18px;
                font-weight:600;
                border-left:5px solid #3498db;
                padding-left:12px;
                margin-bottom:20px;
            }

            .summary-grid{
                display:grid;
                grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
                gap:18px;
            }

            .summary-box{
                padding:20px;
                border-radius:14px;
                color:#fff;
                text-align:center;
                transition:0.2s;
            }

            .summary-box:hover{
                transform:translateY(-3px);
            }

            .summary-box h3{
                font-size:14px;
                margin-bottom:8px;
                font-weight:500;
            }

            .summary-box p{
                font-size:24px;
                font-weight:700;
                margin:0;
            }

            .bg-total{ background:linear-gradient(135deg,#3498db,#2c80b4); }
            .bg-open{ background:linear-gradient(135deg,#f39c12,#d68910); }
            .bg-closed{ background:linear-gradient(135deg,#27ae60,#1e8449); }
            .bg-pending{ background:linear-gradient(135deg,#e74c3c,#c0392b); }
            .bg-inprogress{background: linear-gradient(135deg, #3498db, #2c80b4);}
            .bg-overdue{ background:linear-gradient(135deg,#8e44ad,#6c3483); }

            table{
                width:100%;
                border-collapse:collapse;
                margin-top:10px;
                overflow:hidden;
                border-radius:10px;
                background:#fff;
            }

            th{
                background:#2c3e50;
                color:#fff;
                padding:14px;
                text-align:left;
                font-size:14px;
            }

            td{
                padding:14px;
                border-bottom:1px solid #eee;
                font-size:14px;
            }

            tr:hover{
                background:#f3f6ff;
            }

        </style>

     <h1>📊 Team Performance Report</h1>

     <div class="card">
        <div class="section-title">
                🏢 Team Overview
        </div>

        <div class="summary-grid">

       
        <div class="summary-box bg-total">
            <h3>Team Name</h3>
            <p>{{ $teamoverview['team_name'] }}</p>
        </div>

        <div class="summary-box bg-open">
            <h3>Leader</h3>
            <p>{{ $teamoverview['leader_name'] }}</p>
        </div>
        
        <div class="summary-box bg-closed">
            <h3>Total Agents</h3>
            <p>{{ $teamoverview['totalagents'] }}</p>
        </div>

     </div>
      </div>

      <div class="card">

        <div class="section-title">🎫 Ticket Status</div>
        <div class="summary-grid">
        <div class="summary-box bg-total">
            <h3>Total</h3>
            <p>{{ $ticketstatus['total'] }}</p>
        </div>
        <div class="summary-box bg-open">
            <h3>Open</h3>
            <p>{{ $ticketstatus['open'] }}</p>
        </div>

        <div class="summary-box bg-closed">
            <h3>Close</h3>
            <p>{{ $ticketstatus['close'] }}</p>
        </div>

        <div class="summary-box bg-pending">
            <h3>Pending</h3>
            <p>{{ $ticketstatus['pending'] }}</p>
        </div>

         <div class="summary-box bg-inprogress">
            <h3>Progress</h3>
            <p>{{ $ticketstatus['inprogress'] }}</p>
        </div>


        <div class="summary-box bg-overdue">
            <h3>Overdue</h3>
            <p>{{ $ticketstatus['overdue'] }}</p>
        </div>
      </div>
      </div>

      <div class="card">
<div class="section-title">⏱ SLA / Delay Report</div>

            <div class="summary-grid">
                <div class="summary-box bg-pending">
                    <h3>SLA Breached</h3>
                    <p>{{ $sladata['slabreached'] }}</p>
                </div>

                <divc class="summary-box bg-overdue">
                    <h3>SLA Completed</h3>
                    <p>{{ $sladata['slacompleted'] }}</p>
                </div>
            </div>

      </div>

      <div class="card">

         <div class="section-title">👨‍💻 Agent Performance</div>

         <table>
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Total</th>
                    <th>Open</th>
                    <th>Close</th>
                    <th>Pending</th>
                    <th>In Progress</th>
                    <th>Overdue</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($agentdata as $agent)

                <tr>
                    <td><b>{{ $agent['name'] }}</b></td>
                    <td>{{ $agent['totalticket'] }}</td>
                    <td>{{ $agent['open'] }}</td>
                    <td>{{ $agent['close'] }}</td>
                    <td>{{ $agent['pending'] }}</td>
                    <td>{{ $agent['inprogress'] }}</td>
                    <td>{{$agent['overdue'] }}</td>
                </tr>
                    
                @endforeach
            </tbody>
         </table>
      </div>

</div>
</div>








      {{-- <div class="card">

            <h2>📈 Performance Summary</h2>

            <div class="summary-grid">

                <div class="summary-item">
                    <h3>Resolution Rate</h3>
                    <p>{{ $performanceSummary['resolution_rate'] }}%</p>
                </div>

                <div class="summary-item">
                    <h3>Pending Rate</h3>
                    <p>{{ $performanceSummary['pending_rate'] }}%</p>
                </div>

            </div>

        </div> --}}