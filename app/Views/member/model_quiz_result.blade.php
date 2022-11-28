@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Your Score in {{$test_meta->name}}</h4>
			</div>
			<div class="bx-body">
				<div style='width:70%;margin:0 auto;' class="table-responsive">
					<div>
						@if(!empty($result['rating']))
							@if($result['rating']<50)
								<p class='grd grd1'>
								Your score is {{$result['score']}}. Please practice more in iconpreparation.com.
								</p>
							@elseif($result['rating']>=50 && $result['rating']<60)
								<p class='grd grd2'>
								 Your score is {{$result['test_top']}}. You have fair result. Please practice more.
								</p>
							@elseif($result['rating']>=60 && $result['rating']<70)
								<p class='grd grd3'>
								Your score is {{$result['test_top']}}. You have done an excellent job.<br/>
								This is your strength, please try to capitalize on this.
								</p>
							@elseif(($result['rating']>=70 && $result['rating']<80))
								<p class='grd grd4'>
								 Your score is {{$result['test_top']}}. Hurray!!<br/> You are almost there!! Please focus more on written part.
								</p>
							@else
								<p class='grd grd5'>
								Your score is {{$result['test_top']}}. WOWWWWWWW!!!!!!!<br/>
								You are certainly getting a job soon. Best Luck!.
								</p>
							@endif
						@endif



						<div id="chart-area" style='width:70%;margin: 0 auto;'>
							<canvas id="chart" />
						</div>

					</div>

					<table class="table table-bordered">
						<tr>
							<td colspan="2">
								<!-- <a href="{{$base_url}}member/model_quiz_progress/show/{{$result['test_id']}}/{{$quiz_id[0]}}"><i class="fa fa-eye"></i> View All</a> -->
								<a class='btn btn-info btn-xs' href="{{$base_url}}member/model_quiz_progress/show/{{$model_quiz_id}}"><i class="fa fa-eye"></i> View Answer Sheet</a>
							</td>
						</tr>
						<tr>
							<th>Model Test:</th>
							<td>{{$test_meta->name}}</td>
						</tr>
						<tr>
							<th>Total Correct</th>
							<td> <span class="badge"> {{$result['correct']}}</span></td>
						</tr>
						<tr>
							<th>Total Wrong</th>
							<td> <span class="badge"> {{$result['wrong']}}</span></td>
						</tr>
						<tr>
							<th>You Score</th>
							<td> <span class="badge"> {{$result['score']}}</span></td>
						</tr>
						<tr>
							<th>Total Question</th>
							<td> <span class="badge"> {{$test_meta->total_ques}}</span></td>
						</tr>
						<tr>
							<th>Date Of Exam</th>
							<td>{{$result['dt']}}</td>
						</tr>
						<tr>
							<th>Time Taken</th>
							<td>{{$result['time']}}</td>
						</tr>
						{{-- <tr>
							<th>Your Top Score</th>
							<td>{{$result['user_top_score']}}</td>
						</tr> --}}
						
					</table>
					<div id='ask_expert'>
						<input type="hidden" id="hdn_user" value="{{$user}}"> 
						<input type="hidden" id="hdn_quiz_id" value="{{$model_quiz_id}}"> 
						<button class="btn btn-danger" id='btnAsk'><i class="fa fa-question-circle"></i> Ask An Expert to Review Your Answer Sheet</button>
						<p>
							<i class="fa fa-info-circle"></i> Iconpreparation Experts will go through your answer sheet and indentify your weakness. 
							They will give you a guideline how to overcome your weakness. 
							This will allow you to do better in future. 
							Our goal is to assist you not to make the same mistake again. 
							This will take up to 24 hours. Please check "Expert Guideline" in the menu for updates.
							Thank you!!


						</p>
					</div>
					<br>
					<div>
					Share On Facebook and get a bonus.*  Your score will not be shared.
					<div class="fb-share-button" data-href="http://iconpreparation.com" data-layout="button"></div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/vendor/sweetalert/sweetalert.css">
<style>
	.sweet-alert h2
	{
		font-size:21px;
		margin:0;
	}
	.btn-danger
	{
		background: #FF0000 !important;
	}

	.table tr th
	{
		width:30%;
		font-size:15px;
		background:#F3F4F5;
	}
	.grd {
		/*text-shadow: 3px 4px 4px rgba(150, 150, 150, 1);*/
		font-weight: bold;
	    font-size: 24px;
	    text-align: center;
		/*padding:10px;*/
	    -webkit-animation: fadein 4s; /* Safari, Chrome and Opera > 12.1 */
	    -moz-animation: fadein 4s; /* Firefox < 16 */
	    -ms-animation: fadein 4s; /* Internet Explorer */
	    -o-animation: fadein 4s; /* Opera < 12.1 */
	     animation: fadein 4s;
	}

	.grd1
	{
		color:red;
	}

	.grd2
	{
		color:#4966B6;
	}
	.grd3
	{
		color:activeborder;
	}
	.grd4
	{
		color: #0F9D58;
	}

	.grd5
	{
		color:green;
	}

	@keyframes fadein {
	    from { opacity: 0; }
	    to   { opacity: 1; }
	}

	/* Firefox < 16 */
	@-moz-keyframes fadein {
	    from { opacity: 0; }
	    to   { opacity: 1; }
	}

	/* Safari, Chrome and Opera > 12.1 */
	@-webkit-keyframes fadein {
	    from { opacity: 0; }
	    to   { opacity: 1; }
	}

	/* Internet Explorer */
	@-ms-keyframes fadein {
	    from { opacity: 0; }
	    to   { opacity: 1; }
	}
	/* Opera < 12.1 */
@-o-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

#ask_expert
{
	padding:8px;
	border: 1px solid #ccc;
}
#ask_expert button
{
	margin-bottom:5px;
}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/vendor/sweetalert/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<div id="fb-root"></div>
<script>
(function(d, s, id) 
{
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1390651954534358&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(document).ready(function() {
	$('#btnAsk').click(function() 
	{
		var quiz_id=$('#hdn_quiz_id').val();
		$.ajax({
			url: '{{$base_url}}member/model_quiz/ask_expert',
			type: 'POST',
			data: {quiz_id: quiz_id},
		})
		.done(function(res) {
			if(res=='asked')
			{
				swal('Already asked an expert help for this model test!!',"","info");
			}
			if(res=="ok")
			{
				swal("You successfully asked for an expert help!!","","success");
			}
		});
		
	});

	 var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    chartColor = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};
	var config = {
	       type: 'pie',
	       data: {
	           datasets: [{
	               data: [
	                   {{ $result['correct'] }},
	                   {{ $result['wrong'] }},
	                   {{ $test_meta->total_ques-($result['correct']+$result['wrong']) }}
	               ],
	               backgroundColor: [
	                   chartColor.green,
	                   chartColor.red,
	                   chartColor.yellow
	               ],
	               label: 'Dataset 1'
	           }],
	           labels: [
	               "Correct",
	               "Wrong",
	               "Unanswered"
	           ]
	       },
	       options: {
	           responsive: true
	       }
	   };

	    var ctx =  document.getElementById("chart").getContext("2d");
	    new Chart(ctx, config);


});
</script>
@stop