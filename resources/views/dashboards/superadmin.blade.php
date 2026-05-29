@extends('layout')

@section('title', 'Super Admin Dashboard')

@section('main')

<style>
    body {
        background: #f4f7fc;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .dashboard-header h3 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .dashboard-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        padding: 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.12);
    }

    .dashboard-card .icon {
        position: absolute;
        right: 18px;
        top: 18px;
        font-size: 42px;
        opacity: 0.25;
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
        opacity: 0.9;
    }

    .dashboard-card h2 {
        font-size: 38px;
        font-weight: 700;
        margin: 0;
    }

    /* Gradient Colors */
    .bg-users {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    .bg-tickets {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .bg-teams {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .bg-permissions {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .bg-roles {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
</style>

<div class="container-fluid py-4">

    <div class="dashboard-header">
        <h3>🧠 Super Admin Control Panel</h3>
        <p>
            Monitor users, manage teams, track tickets, and control permissions from one powerful dashboard.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-card bg-users">
                <div class="icon">👤</div>
                <h6>Total Users</h6>
                <h2>{{ $totaluser }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-tickets">
                <div class="icon">🎫</div>
                <h6>All Tickets</h6>
                <h2>{{ $totalticket }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-teams">
                <div class="icon">👥</div>
                <h6>Total Teams</h6>
                <h2>{{ $totalteam }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-permissions">
                <div class="icon">🔐</div>
                <h6>Permissions</h6>
                <h2>{{ $totalpermission }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card bg-roles">
                <div class="icon">🛡️</div>
                <h6>Total Roles</h6>
                <h2>{{ $totalrole }}</h2>
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