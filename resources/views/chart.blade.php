<!DOCTYPE html>
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
</html>