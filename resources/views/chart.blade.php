@extends('layout')
@section('title', 'Ticket Chart')

@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Chart') }}
        </h2>
    </x-slot>
@endsection

@section('main')
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Dashboard</title>
    <!-- Modern Google Font -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <style>
        /* Modern Dashboard Card Container */
        .dashboard-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            max-width: 900px;
            margin: 2rem auto;
            padding: 24px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #container {
            height: 420px;
            width: 100%;
        }

        .chart-description {
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
            margin-top: 1rem;
            font-weight: 500;
        }
    </style>
</head>

<body style="background-color: #f8fafc; margin: 0; padding: 0;">

<div class="dashboard-card">
    <div id="container"></div>
    <p class="chart-description">
        📊 Chart showing live breakdown of ticket distributions and status.
    </p>
</div>

<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        backgroundColor: '#ffffff',
        style: {
            fontFamily: "'Plus Jakarta Sans', sans-serif"
        }
    },
    title: {
        text: 'Ticket Status Overview',
        align: 'left',
        style: {
            color: '#0f172a',
            fontSize: '20px',
            fontWeight: '700'
        }
    },
    subtitle: {
        text: 'Overview of cumulative and categorical support tickets',
        align: 'left',
        style: {
            color: '#64748b',
            fontSize: '13px'
        }
    },
    xAxis: {
        categories: {!! json_encode($categories) !!},
        gridLineWidth: 0,
        lineColor: '#cbd5e1',
        labels: {
            style: {
                color: '#475569',
                fontSize: '12px',
                fontWeight: '500'
            }
        }
    },
    yAxis: {
        min: 0,
        gridLineColor: '#f1f5f9',
        title: {    
            text: 'Number Of Tickets',
            style: {
                color: '#64748b',
                fontSize: '12px',
                fontWeight: '600'
            }
        },
        labels: {
            style: {
                color: '#475569'
            }
        }
    },
    credits: {
        enabled: false // Removes the highcharts.com watermark link
    },
    legend: {
        itemStyle: {
            color: '#334155',
            fontWeight: '600'
        }
    },
    tooltip: {
        backgroundColor: '#0f172a',
        style: {
            color: '#ffffff'
        },
        borderRadius: 8,
        shared: true,
        borderWidth: 0,
        shadow: true,
        valueSuffix: ' tickets'
    }, 
    plotOptions: {
        column: {
            borderRadius: 6, // Smooth rounded columns
            borderWidth: 0,
            maxPointWidth: 50 // Prevents bars from becoming awkwardly thick
        },
        pie: {
            borderWidth: 2,
            borderColor: '#ffffff', // Clean white separators between donut slices
            shadow: false
        }
    },
    series: [
        {
            type: 'column',
            name: 'Tickets By Category',
            color: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#3b82f6'], // Modern electric blue top
                    [1, '#1d4ed8']  // Professional deep blue bottom
                ]
            },
            data: {!! json_encode($series['data']) !!}
        }, 
        {
            type: 'pie',
            name: 'Total Shares',
            data: {!! json_encode($pie) !!},
            colorByPoint: true,
          
          colors: ['#00f5d4', '#ff007f', '#3a86ff', '#ffbe0b', '#7b2cbf'],


            center: ['88%', '15%'], // Shifted to top right corner out of the bar lines' way
            size: 90,
            innerSize: '75%', // Sleeker donut ring thickness
            showInLegend: false,
            dataLabels: {
                enabled: false
            },
            states: {
                hover: {
                    brightness: 0.05
                }
            }
        }
    ]
});
</script>
</body>
</html> 
@endsection

 {{-- //     data: [{
    //         name: '2020',
    //         y: 619,
    //         color: Highcharts.getOptions().colors[0], // 2020 color
    //         dataLabels: {
    //             enabled: true,   //label show
    //             distance: -50,   // move text inside slice  
    //             format: '{point.total} M',
    //             style: {
    //                 fontSize: '15px',
    //                 color: 'var(--highcharts-neutral-color-100, black)'
    //             }
    //         }
    //     }, {
    //         name: '2021',
    //         y: 586,
    //         color: Highcharts.getOptions().colors[1] // 2021 color
    //     }, {
    //         name: '2022',
    //         y: 647,
    //         color: Highcharts.getOptions().colors[2] // 2022 color
    //     }],
    //     center: [75, 65],
    //     size: 100,
    //     innerSize: '70%',
    //     showInLegend: false,
    //     dataLabels: {
    //         enabled: false
    //     } --}}

{{-- {
        type: 'line',
        step: 'center',
        name: 'Average',
        data: [47, 83.33, 70.66, 239.33, 175.66],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'var(--highcharts-background-color, white)'
        }
    }, 
     --}}


{{-- <!DOCTYPE html>
<html>
<head>
    <title>Ticket Dashboard</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>

<div id="container"></div>

<script>
Highcharts.chart('container', {

    title: {
        text: 'Ticket Analytics Dashboard'
    },

    xAxis: {
        categories: {!! json_encode($categories) !!}
    },

    yAxis: {
        title: {
            text: 'Number of Tickets'
        }
    },

    tooltip: {
        shared: true
    },

    plotOptions: {
        column: {
            borderRadius: 5
        }
    },

    series: {!! json_encode($series) !!},

    // 🥧 Pie chart inside same chart
    series: {!! json_encode($series) !!}.concat([{
        type: 'pie',
        name: 'Total',
        data: {!! json_encode($pie) !!},
        center: [100, 80],
        size: 120,
        innerSize: '60%',
        showInLegend: false,
        dataLabels: {
            enabled: false
        }
    }])

});
</script>

</body>
</html> --}}





{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h4>Ticket Status Chart</h4>
            </div>
            <div class="card-body">
                <div id="container"></div>
            </div> 
        </div>
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
// create chart 
    Highcharts.chart('container', {
        chart: {
            type: 'column'  // vertical bar chart 
        },
        title: {
            text: 'Ticket Status Overview'   // main heading
        },
        subtitle: {
            text:
                "Ticket Charts"
                // 'Source: <a target="_blank" ' +
                // 'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>'
        },
        xAxis: {
            categories: {!! json_encode($data->keys()) !!},  //bottom label   data fetch from controller    
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
                data: {!! json_encode($data->values()) !!}
            },
            
        ]
});

</script>
</body>
</html> --}}