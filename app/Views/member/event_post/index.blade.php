@extends('master.layout')
@section('content')
<div class="row">
    <div class="col-md-6 right-pad-zero">
        <div class="bx bx-evnt">
            <div class="bx bx-header">
                <h4 class="bx-title">
                <i class="fa fa-calendar"></i> {{$event->name}} | 
                <i class="fa fa-clock-o"></i> {{date_long($event->event_time)}}
                </h4>
                <div class="colps">
                    <a href=""><i class="fa fa-angle-up"></i></a>
                </div>
            </div>
            <div class="bx bx-body">
              <!-- start display video(if any) -->
              @if(!empty($event->featured_image))
              <?php $headers=get_headers($event->featured_image,1);?>
              @if(count($headers))
              <?php if($headers['Content-Type']=='video/mp4'){ ?>
              <div id='media-player'>
                <video id='media-video' controls>
                  <source src='{{$event->featured_image}}' type='video/mp4'>
                </video>
                <div id='media-controls'>
                  <button id='replay-button' class='replay' title='replay' onclick='replayMedia();'>Replay</button> 
                  <button id='play-pause-button' class='play' title='play' onclick='togglePlayPause();'>Play</button>
                  <button id='stop-button' class='stop' title='stop' onclick='stopPlayer();'>Stop</button>
                  <button id='volume-inc-button' class='volume-plus' title='increase volume' onclick='changeVolume("+");'>Increase volume</button>
                  <button id='volume-dec-button' class='volume-minus' title='decrease volume' onclick='changeVolume("-");'>Decrease volume</button>
                  <button id='mute-button' class='mute' title='mute' onclick='toggleMute("true");'>Mute</button>  
                  <progress id='progress-bar' min='0' max='100' value='0'>0% played</progress>
                </div>
              </div> 
              <?php }else{ ?> <!-- end start display video(if any) -->

              <!-- display featured image -->
            	<img width="100%" src="{{$event->featured_image}}" alt="">
              <!-- display featured image -->

            	<?php } ?>
              @endif
              @endif

              <!-- display slide -->
              @if(!empty($event->slide))
              <div style='text-align:center;'>
              <iframe src="{{$event->slide}}" width="490px" height="470px" 
              frameborder="0" marginwidth="0" marginheight="0" scrolling="no" 
              style="border:none;" allowfullscreen webkitallowfullscreen mozallowfullscreen>
              </iframe>
              </div>
              @endif
              <!-- end display slide -->

                {{$event->details}}
            </div>
        </div>

        <!-- display event post -->
        <input type="hidden" name="eid" id='eid' value="{{$event->id}}">
        <div class="bx bx-post">
        	{{$posts}}
        </div>

        <div class="bx">
        	<div class="bx bx-header">
        		<h3 class="bx-title">Comments</h3>
        	</div>
        	<div class="bx bx-body">
        		<textarea name="txt_post_comment" id="txt_post_comment" cols="30" class='form-control'></textarea>
        		<a id='btn_comment' class="btn btn-primary btn-xs">Save</a>
        		<div id="comments">
        			
        		</div>
        	</div>
        </div>
        <!-- end display event post -->
    </div>

    <div class="col-sm-6 right-zero-pad">
      <div class="col-sm-5 no-pad">
      <div class="bx">
      	<div class="bx bx-header">
      		<h3 class="bx-title">Other Classes</h3>
      	</div>
      	<div class="bx bx-body bx-going-event">
      		{{$ongoing_events}}
      	</div>
      </div>
        <div class="bx">
         
          <div class="bx bx-body adv">
            <a target="_blank" href="http://revinr.com"><img src="{{$base_url}}asset/frontend/img/revinr.png" alt="revinr.com"></a>
          </div>
        </div>
      </div>
    <div class="col-sm-7">
        <div class="bx">
          <div class="bx bx-header">
            <h4 class="bx bx-title">Current World</h4>
          </div>
          <div class="bx bx-body">
            <ul class='list-unstyled'>
              {{$current_world}}
              <a class='btn btn-default' href='{{ $base_url }}member/reading/index/315'>View All</a>
            </ul>
          </div>
        </div>

      </div>
    </div>
</div>

@stop


@section('style')
<link rel="stylesheet" type="text/css" href="{{$base_url}}asset/vendor/video-player/media-player.css">
<style>
  iframe{
    width:100%;
  }
  table{
    width: 100% !important;
  }
  .bx-evnt .bx-header{background: #FFDC80;}

  .bx-evnt .bx-body{ background: #FFDC80;}

	.bx .bx-header{
		height:55px;
	}
	.bx-title p{
		font-size: 12px;
		color:#666;
		margin-top: 5px;
		margin-bottom: 5px;
	}
  .bx-going-event h3{
    margin-top: 0;
  }
  .bx-going-event h3 a{
    color:#F37F2E;
    font-size: 19px;
  }
	#comments p
	{
		margin-top: 10px;
		font-size: 12px;
	}
	#comments p span
	{
		margin-right: 25px;
	}
	#comments p span i{
		margin-right: 5px;
	}
  #media-player
  {
    float: none;
    background: none;
    padding: 0;
    margin-bottom: 12px;
  }
  video
  {
    height:100%;
    width:100%;
    background:#fff;
  }
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/vendor/video-player/media-player.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	//load post by pagination
	$('.bx-post').on('click','.pager li a',function(e){
		e.preventDefault();
		var page=$(this).data('page');
		var eid=$('#eid').val();
		$.ajax({
			url: '{{$base_url}}member/event_post/get_event_post',
			type: 'GET',
			data: {page: page,eid:eid}
		})
		.done(function(res) {
			$('.bx-post').html(res);
			var pid=$('#hdn_post').val();
			load_comment(pid);
		});
	});//end load post by pagination

	//call on load
	var post_id=$('#hdn_post').val();
	load_comment(post_id);
	//post comment
	$('#btn_comment').click(function(e){
    e.preventDefault();
		var pid=$('#hdn_post').val();
		var comment=$('#txt_post_comment').val();
		$.ajax({
			url: '{{$base_url}}member/event_post/save_comment',
			type: 'POST',
			data: {pid: pid,comment:comment},
		})
		.done(function(res) {
			console.log("success");
			load_comment(pid);
			$('#txt_post_comment').val('');
		});
		
	});
	//end post comment
	
	
});
//start load comment
function load_comment(pid)
{
	$.ajax({
		url: '{{$base_url}}member/event_post/get_post_comment',
		type: 'GET',
		data: {pid: pid}
	})
	.done(function(res) {
		$('#comments').html(res);
	});
}
//end load comment
</script>
@stop