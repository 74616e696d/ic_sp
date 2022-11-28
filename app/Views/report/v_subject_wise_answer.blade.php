@extends('master.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx bx-title"></h4>
            </div>
            <div class="bx bx-body">
                <div id='chart'></div>
            </div>
        </div>
    </div>
</div>
    
@stop

@section('script')
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/exporting.js"></script>

    <script type="text/javascript">
    //$(document).ready(function() {
        // Create the chart
       $(function () {
            $('#chart').highcharts({
                chart: {
                    type: 'column',
                    margin: [ 50, 50, 100, 80]
                },
                title: {
                    text: 'Subject Wise Correct Answer Of <?php echo $test_name; ?>'
                },
                xAxis: {
                    categories:<?php echo $xAxis; ?>,
                    labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Marks'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Obtained Marks: <b>{point.y:.1f} millions</b>',
                },
                series: [{
                    name: 'Population',
                    data: [34.4],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: 4,
                        y: 10,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif',
                            textShadow: '0 0 3px black'
                        }
                    }
                }]
            });
        });
        

    //});
    </script>
@stop

