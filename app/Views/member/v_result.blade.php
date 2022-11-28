<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Iconpreparation  | @if(isset($title)){{$title}}@endif</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{$base_url}}asset/member/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{$base_url}}asset/member/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{$base_url}}asset/member/css/ionicons.min.css" rel="stylesheet" type="text/css" />
      
        <!-- Theme style -->
        <link href="{{$base_url}}asset/member/css/AdminLTE.css" rel="stylesheet" type="text/css" /> 

        <link rel="stylesheet" href="{{$base_url}}asset/member/css/common.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    <style>
	.row
	{
		margin:0;	
	}
	.container
	{
		padding-top:2%;
	}
	.container>div
	{
		padding:10px;
		border:1px solid #ddd;
	}
	.table caption
	{
		font-size:18px;
	}
	.list-group-item
	{
		font-size: 15px;
	}
	.list-group-item strong
	{
		width:40%;
		font-weight: bolder;
	}
	.list-group-item span
	{
		float:right;
		text-align:left;
		width:60%;
	}
	.copy
	{
		float:right;
		padding-right:8px;
	}
	.copy>a
	{
		color:#444;
	}
	#result
	{
		background:#f6f6f6;
	}

	.skin-blue .right-side > .content-header > h1
	{
		display:none;
	}
	.right-side
	{
		margin-left:0;
	}
	.right-side>.content-header
	{
		padding:15px 15px 0px 20px;
	}
	.table
	{
		background: #fff;
	}
	</style>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        @include('master.header')
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
          

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
               @include('master.content_header')

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            {{render_message()}}
                        </div>
                    </div>  
		           <div id="result" class="col-sm-6 col-sm-offset-3">
					<div>
						<h3>Result Of {{$result['exam_name']}}</h3>
						<a href="#" style='float:left;' class="print"><i class="fa fa-print"></i></a>


						<a class='btn btn-default btn-xs' style='float:right' href="{{$base_url}}member/result_details/index/{{$result['exam_id']}}"><i class="fa fa-eye">&nbsp;&nbsp;View Details</i></a>
						<a class='btn btn-default btn-xs' style='float:right' href="{{$base_url}}member/result_not_answered/index/{{$result['exam_id']}}"><i class="fa fa-eye">&nbsp;&nbsp;View Unanswered Details</i></a>&nbsp;&nbsp;
						
						<div class="clearfix"></div>
						<br>
						<ul class="list-group">
							<li class="list-group-item"><strong>Exam ID</strong><span>{{$result['exam_id']}}</span></li>
							<li class="list-group-item"><strong>Exam Name</strong><span>{{$result['exam_name']}}</span></li>
							<li class="list-group-item"><strong>Date</strong><span>{{$result['exam_date']}}</span></li>
							<li class="list-group-item"><strong>Time Taken</strong><span>{{$result['time_taken']}}</span></li>

						</ul>
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Total Question</th>
									<th>Total Correct</th>
									<th>Total Wrong</th>
									<th>Not Answered</th>
									<th>Your Top Correct Answer</th>
									<th>Exam Top</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$result['total_question']}}</td>
									<td>{{$result['total_correct']}}</td>
									<td>{{$result['total_wrong']}}</td>
									<td>{{$result['not_answered']}}</td>
									<td>{{$result['user_top']}}</td>
									<td>{{$result['top']}}</td>
								</tr>
							</tbody>
						</table>
						<div id="map"></div>
						<a href="{{$base_url}}member/dashboard">Back To Dashboard</a>
				<span class='copy'>&copy;&nbsp;{{date('Y')}}&nbsp;<a href="{{$base_url}}">iconpreparation.com</a></span>
					</div>
				</div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


<!-- jQuery 2.0.2 -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
<script type="text/javascript" src="{{$base_url}}asset/member/js/jquery-1.10.2.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="{{$base_url}}asset/member/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{$base_url}}asset/member/js/bootstrap.min.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="{{$base_url}}asset/member/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>  
<!-- AdminLTE App -->
<script src="{{$base_url}}asset/member/js/AdminLTE/app.js" type="text/javascript"></script>

<script type="text/javascript" src="{{$base_url}}asset/js/jQuery.print.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/js/highcharts.js"></script>
<script type="text/javascript" src="{{$base_url}}js/custom/general.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var curr_uri='{{current_url()}}',
        curr_uri_plain=curr_uri.replace('/index.php','');
        lists=$('ul.sidebar-menu>li');
        $('ul.sidebar-menu>li').removeAttr('class');
        $.each(lists,function(){
            var url=$(this).children('a').attr('href');
            if(url==curr_uri_plain)
            {
                $(this).attr('class','active');
            }

        });

        // Create the chart
        $('#map').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Exam Result'
            },
            xAxis: {
                type: 'Result'
            },
            yAxis: {
                title: {
                    text: 'Total Marks'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },

            tooltip: {
                // headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [{
                    name: "Total Correct",
                    y: {{$result['total_correct']}}
                }, 
                {
                    name: "Total Wrong",
                    y: {{$result['total_wrong']}}
                }, 
                {
                    name: "Exam Top",
                    y: {{$result['top']}}
                },{
                	name:'Total Question',
                	y:{{$result['total_question']}}
                }]
            }]
        });


        ('.print').click(function(e){
				e.preventDefault();
				$('#table').print();

		});
    });
</script>
<script type="text/javascript" src="{{$base_url}}asset/member/js/custom.js"></script>

    </body>
</html>







@section('content')

@stop

@section('style')
	<style>
	.row
	{
		margin:0;	
	}
	.container
	{
		padding-top:2%;
	}
	.container>div
	{
		padding:10px;
		border:1px solid #ddd;
	}
	.table caption
	{
		font-size:18px;
	}
	.list-group-item span
	{
		float:right;
		text-align:left;
		width:60%;
	}
	.copy
	{
		float:right;
		padding-right:8px;
	}
	.copy>a
	{
		color:#444;
	}
	#result
	{
		background:#f6f6f6;
	}
	</style>
@stop

@section('script')
	<script type="text/javascript" src="{{$base_url}}asset/js/jQuery.print.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.print').click(function(e){
				e.preventDefault();
				$('#table').print();

			});
		});
	</script>
@stop

	
<!-- </head>
<body>
	
	<div class='row'>
		<div class='container'>
			
	
		</div>
	</div>


	
</body>
</html> -->
