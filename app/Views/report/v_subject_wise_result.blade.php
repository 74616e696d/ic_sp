@extends('master.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx-title"></h4>
            </div>
            <div class="bx bx-body">
                <div id='chart' style='width:90%;'></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
    $(function () {
            $('#chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Subject Wise Result'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories:<?php echo $subject_list; ?>
                },
                yAxis: {
                    min: 0,
                    max:100,
                    title: {
                        text: 'Marks (percent)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}%</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Correct Answer',
                    data:<?php echo $correct; ?>
        
                }, {
                    name: 'Wrong Answer',
                    data:<?php echo $wrong; ?>
        
                }]
            });
        });
    </script>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/exporting.js"></script>
@stop



