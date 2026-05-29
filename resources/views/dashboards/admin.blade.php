@extends('layout')

@section('main')

<style>
    body {
        background: #f4f7fc;
    }

    .dashboard-title {
        font-size: 30px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 30px;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        padding: 22px;
        color: #fff;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    }

    .dashboard-card .icon {
        position: absolute;
        right: 20px;
        top: 18px;
        font-size: 40px;
        opacity: 0.25;
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .dashboard-card h2 {
        font-size: 34px;
        font-weight: 700;
        margin: 0;
    }

    /* Gradient Colors */
    .bg-teams {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
    }

    .bg-agents {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }

    .bg-tickets {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .bg-open {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }

    .bg-close {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .bg-pending {
        background: linear-gradient(135deg, #f97316, #ea580c);
    }

    .bg-progress {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .bg-reopen {
        background: linear-gradient(135deg, #a855f7, #9333ea);
    }
     .bg-overdue {
        background: linear-gradient(135deg, #e74a3b, #be2617);
    }
</style>

<div class="container py-4">

    <div class="dashboard-title">
        🛠️ Admin Dashboard
    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-card bg-teams">
                <div class="icon">👥</div>
                <h6>Total Teams</h6>
                <h2>{{ $totalteam }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-agents">
                <div class="icon">🧑‍💻</div>
                <h6>Support Agents</h6>
                <h2>{{ $agents }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-tickets">
                <div class="icon">🎫</div>
                <h6>Total Tickets</h6>
                <h2>{{ $totalticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-open">
                <div class="icon">📂</div>
                <h6>Open Tickets</h6>
                <h2>{{ $totalopenticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-close">
                <div class="icon">✅</div>
                <h6>Closed Tickets</h6>
                <h2>{{ $totalcloseticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-pending">
                <div class="icon">⏳</div>
                <h6>Pending Tickets</h6>
                <h2>{{ $totalpendingticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-progress">
                <div class="icon">🚀</div>
                <h6>In Progress</h6>
                <h2>{{ $totalprogressticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-reopen">
                <div class="icon">🔄</div>
                <h6>ReOpened Tickets</h6>
                <h2>{{ $totalreopenticket }}</h2>
            </div>
        </div>

          <div class="col-md-6 col-lg-3">
            <div class="dashboard-card bg-overdue">
                <div class="dashboard-icon">
                    ⏰
                </div>

                <h6>Overdue</h6>
                <h2>{{ $overdue ?? 0 }}</h2>
            </div>
        </div>

        
    </div>

</div>
<div class="row mt-4">
    <div class="col-md-6">
        <div id="ticketchart" style="height:400px;">
            </div>
         </div>

        <div class="col-md-6">
            <div id="agentchart" style="height: 400px;">

            </div>

        </div>
</div>



<script src="https://code.highcharts.com/highcharts.js"></script>


<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
Highcharts.chart('ticketchart', {
        chart: {
            type: 'column'  // vertical bar chart 
        },
        title: {
            text: 'Ticket Status Overview'   // main heading
        },
        subtitle: {
            text:
                "Ticket Charts"
              
        },
        xAxis: {
            categories: {!! json_encode($categories) !!},  //bottom label   data fetch from controller    
            crosshair: true,      // hight where to hover on chart
            accessibility: {
                description: 'Tickets'
            }
        },
        yAxis: {
            min: 0,     // start from 0 
            title: {    
                text: 'Number Of Tickets'    //left side label
            } 
        },
        tooltip: {
            valueSuffix: ' tickets'      //hover chart show that 
        },
        plotOptions: {
            column: {
                // pointPadding: 0.2, space between bar
                borderWidth: 0          // remove bar border
            }
        },
        series: [   //actual data of chart
            {
                name: 'Tickets',
                data: {!! json_encode($values) !!}
            },
            
        ]
});
</script>

<script>
Highcharts.chart('agentchart',{
    chart:{
        type:'pie'
    },
    title:{
        text:'Agent Performance'
    },
     tooltip: {
            valueSuffix: ' tickets'      //hover chart show that 
        },
        plotOptions:{   //extra setting 
            pie:{
                allowPointSelect:true,  //click pie slice 

                cursor: 'pointer',

                  dataLabels:{ //show labels
                    enabled:true,

//                     format: '<b>{point.name}</b>: {point.y}'
                }
            }   
        },
        series:[{
            name:"Tickets", 
            colorByPoint:true,
            data:{!! json_encode($pie) !!}
        }]
})
    </script>


@endsection