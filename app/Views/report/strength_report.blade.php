@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx-header">
				<h4 class="bx-title"></h4>
			</div>
			<div class="bx bx-body">
				<form class='form-inline' action="{{ base_url() }}/report/strength_report" method="post">
					<div class="form-group">
					<select class='form-control' name="ddl_subject" id="ddl_subject">
						<option value="-1">Select Subject</option>
						@if($subject)
						@foreach($subject as $sbj)
						<option @if($sel_subject==$sbj->id){{ 'selected' }}@endif value="{{ $sbj->id }}">{{ $sbj->name }}</option>
						@endforeach
						@endif
					</select>
					<button class='btn btn-info' type='submit' name='btn_search' value='1'><i class="fa fa-search"></i> Search</button>
					</div>
				</form>
				<div id="chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript" src="<?php echo base_url(); ?>/public/asset/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/asset/js/exporting.js"></script>
<script type="text/javascript">
	$(function () {

		Highcharts.theme = {
		   colors: ["#f45b5b", "#8085e9", "#8d4654", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
		      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
		   chart: {
		      backgroundColor: null,
		      style: {
		         fontFamily: "Signika, serif"
		      }
		   },
		   title: {
		      style: {
		         color: 'black',
		         fontSize: '16px',
		         fontWeight: 'bold'
		      }
		   },
		   subtitle: {
		      style: {
		         color: 'black'
		      }
		   },
		   tooltip: {
		      borderWidth: 0
		   },
		   legend: {
		      itemStyle: {
		         fontWeight: 'bold',
		         fontSize: '13px'
		      }
		   },
		   xAxis: {
		      labels: {
		         style: {
		            color: '#6e6e70'
		         }
		      }
		   },
		   yAxis: {
		      labels: {
		         style: {
		            color: '#6e6e70'
		         }
		      }
		   },
		   plotOptions: {
		      series: {
		         shadow: true
		      },
		      candlestick: {
		         lineColor: '#404048'
		      },
		      map: {
		         shadow: false
		      }
		   },

		   // Highstock specific
		   navigator: {
		      xAxis: {
		         gridLineColor: '#D0D0D8'
		      }
		   },
		   rangeSelector: {
		      buttonTheme: {
		         fill: 'white',
		         stroke: '#C0C0C8',
		         'stroke-width': 1,
		         states: {
		            select: {
		               fill: '#D0D0D8'
		            }
		         }
		      }
		   },
		   scrollbar: {
		      trackBorderColor: '#C0C0C8'
		   },

		   // General
		   background2: '#E0E0E8'
		   
		};

		// Apply the theme
		Highcharts.setOptions(Highcharts.theme);

	    $('#chart').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Strength Comparison Chart'
	        },
	        xAxis: {
	            //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
	            categories:{{ $chapter_list }}
	        },
	        yAxis: {
	            min: 0,
	            max:100,
	            title: {
	                text: 'Chapter Wise Progress'
	            },
	            stackLabels: {
	                enabled: true,
	                style: {
	                    fontWeight: 'bold',
	                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
	                }
	            }
	        },
	        legend: {
	            align: 'right',
	            x: -70,
	            verticalAlign: 'top',
	            y: 20,
	            floating: true,
	            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
	            borderColor: '#CCC',
	            borderWidth: 1,
	            shadow: false
	        },
	        tooltip: {
	            formatter: function () {
	                return '<b>' + this.x + '</b><br/>' +
	                    this.series.name + ': ' + this.y + '%<br/>'; 
	                   // +'Total: ' + this.point.stackTotal;
	            }
	        },
	        plotOptions: {
	            column: {
	                stacking: 'normal',
	                dataLabels: {
	                    enabled: true,
	                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
	                    style: {
	                        textShadow: '0 0 3px black, 0 0 3px black'
	                    }
	                }
	            }
	        },
	        series: [
	         {
	            name: 'Wrong',
	            //data: [2, 2, 3, 2, 1]
	            data:{{ $wrong_series }}
	        },
	        {
	            name: 'Correct',
	            //data: [5, 3, 4, 7, 2]
	            data:{{ $correct_series }}
	        }]
	    });

	
	
	});
</script>
@stop