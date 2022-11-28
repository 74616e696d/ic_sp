@extends('member.exam.master')

@section('content')
<input type="hidden" id='hdn_test_name' value="<?php echo $test_name; ?>">
<input type="hidden" id="ttl_ques" name="ttl_ques" value="{{$ttl_ques}}">
<div class="col-sm-12 col-xs-12 visible-xs visible-sm toolbar-mobile">

  <div class="exp pull-left"><i class="fa fa-angle-down"></i>&nbsp;All Questions</div>
  <div class="pull-left"><h4><?php if($test_name)echo exam_model::get_text($test_name); ?></h4>
   <!-- <div class='clockDiv'></div>  -->
  </div>
  <div id='exp-calc' class='pull-right'><i class="fa fa-calculator"></i></div>
  
</div>

<div class='col-sm-12 col-xs-12 col-md-12 clockDiv clock-mobile hidden-lg hidden-md'></div> 

<section class="row top-buffer">
    <div id='left-portion' class="col-lg-4 col-md-4 col-sm-10 col-xs-10">
      
        <div id="sidebar" role="navigation">
          <div class="well sidebar-nav">
            <h2 class="hidden-sm hidden-xs title tutorial-color"><?php if($test_name)echo exam_model::get_text($test_name); ?></h2>
           
             <label id='lblAll' class='label label-info'><strong>All Questions</strong></label>
             <label id='lblMarked' class='label label-deafault'><strong>Marked Questions</strong></label>
          
                  <ul id='qlist' class="nav nav_1">
                    <?php echo $questions; ?>
                  </ul>
          
          </div>
        
        </div>
    </div>


    <div id='middle-potion' class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
      <div class="jumbotron">
        <h4>Choose the correct answer.</h4>
        <form method="post">
        <div id='ans'>
          
        </div>
       
        <ul class="pager">
          <li class="previous"><a id="prev" class="disabled" role="button">
          <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Prev&nbsp;&nbsp;&nbsp;</a>
          </li>
          <li id='next' class="next">
              <a  id='next' role="button">&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>

          </li>
        </ul>
        </form>
        <div>
        <!--   <button type='button' class='btn btn-primary btn-xs' id='btnReport'>Report This Question<span class='ttp' data-toggle='tooltip' data-placement='top' 
          title='If you think something wrong with this question,please report'>(*)</span></button> -->

          <button type='button' class='btn btn-info btn-xs' id='btnReview'>Add to review list<span class='ttp' data-toggle='tooltip' data-placement='top' 
          title='Add this question to list for future review'>(*)</span></button>
               <a onClick='return(confirm("Are you sure to discard the exam and leave this page"))' href="{{ $base_url }}member/dashboard" class='btn btn-danger btn-xs'>Discard Exam</a>
        </div>
      </div>
    </div>


    <div id='right-portion' class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
        
         <input name="hdnSec" type="hidden" id="hdnSec"/>

         <div class='clockDiv hidden-phone hidden-tablet'>
            
         </div> 
        <!-- start calculator -->
        @include('member.exam.calc')
        <!--end calculator -->
    </div>

</section>

<?php
  $time=!empty($test_meta->total_time)?$test_meta->total_time:60;
?>
@stop

@section('style')
  <link rel="stylesheet" href="{{$base_url}}asset/css/jquery.countdown.css">
  <link type='text/css' rel='stylesheet' href='{{$base_url}}asset/css/toastr.css'/>
  <style>
  #countDown
  {
    border:1px solid #f5f5f5;
  }
  .pager .previous:hover
  {
    cursor: pointer;
  }
  .pager .next:hover
  {
    cursor: pointer;
  }
  .sidebar-nav
  {
    min-height:400px;
  }
  .label{width:46%;}
  </style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/member/js/media_helper.js"></script>
<script type='text/javascript'>
  var store_ans_url='{{$base_url}}member/test/store_ans',
  finish_action='{{$base_url}}member/test/finish_exam',
  report_action='{{$base_url}}member/test/report_question',
  review_action='{{$base_url}}member/test/add_to_review',
  get_mrk_ques_action='{{$base_url}}member/test/marked_questions',
  get_all_ques_action='{{$base_url}}member/test/all_questions';
</script>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.plugin.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.countdown.min.js"></script>
<script type='text/javascript' src='{{$base_url}}asset/js/toastr.min.js'></script>
<script type="text/javascript" src="{{$base_url}}asset/js/jstorage.min.js"></script>
<script type="text/javascript" src='{{$base_url}}asset/js/manageTest.js'></script>
<script type="text/javascript">
$(document).ready(function() {
   $.jStorage.flush();
       //strong all question id to temp storage
  $('#qlist li').each(function(){
    var q=$(this).children("input[type=hidden]").val(),
      srl=$(this).children('a').children('span').text().replace('.',''),
      qsrl='ques_srl'+srl;
      $.jStorage.set(qsrl,q); 

  });
  //end strong all question id to temp storage
  
  var pageLeaveState = 'refresh';

  $(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
   $(document).bind("contextmenu",function(e){
          return false;
   }); 
  //set selected questions class
  

// show first question on page load 
var first_qid=$('#qlist li:first input[type=hidden]').val(),
    test_name = $('#hdn_test_name').val();
    showAns(first_qid,1,test_name);
// end show first question on page load

$(document).on('click', '#qlist li a', function(event) {
  event.preventDefault();
  $('#qlist li').removeAttr('class');
  $(this).parent('li').attr('class', 'selected-ques');

  var qid = $(this).prev('input[type=hidden]').val(),
    sl = $(this).children('span').text();
    
  //getting answer option of selected question
  showAns(qid, sl, test_name);

   var w=$(window).width();
  if(w<=768){
  $('#left-portion').hide();
  }

  var lnk_cur_val = $(this).parent('li').children('input').val();
  // plnk=$(this).parent('li').prev('li').children('input').val();
  next_lnk.attr('data-val', lnk_cur_val);
  prev_lnk.attr('data-val', lnk_cur_val);

});

  //displaying question according to next and previous
  var sel_val = $('#qlist li:first input[type=hidden]').val(),
    prev_val = $('#qlist li:first input[type=hidden]').val(),
    next_lnk = $('#next'),
    prev_lnk = $('#prev');
  // alert(next_val);
  next_lnk.attr('data-val', sel_val);
  prev_lnk.attr('data-val', prev_val);

  next_lnk.click(function(e) {
    e.preventDefault();
    var cur_id = $(this).attr('data-val'),
      query_id = $("#qlist li input[value='" + cur_id + "']").parent('li').next('li').children('input').val(),
      serial = $("#qlist li input[value='" + cur_id + "']").parent('li').next('li').children('a').children('span#sl').html().trim(),
      testname = $('#hdn_test_name').val();
    
    if (typeof query_id != 'undefined') {
      showAns(query_id, serial, testname);
      $(this).attr('data-val', query_id);
      prev_lnk.removeClass('disabled');
      prev_lnk.attr('data-val', query_id);
      $('#qlist li').removeAttr('class');

      var serial_plain=serial.replace('.','');
      $('#hdn_ques_sl'+serial_plain).parent('a').parent('li').attr('class','selected-ques');
     
    }
    else {
      $(this).addClass('disabled');
      prev_lnk.removeClass('disabled');
    }
  });

prev_lnk.click(function(e) {
  e.preventDefault();
  var cur_id = $(this).attr('data-val'),
    query_id = $("#qlist li input[value='" + cur_id + "']").parent('li').prev('li').children('input').val(),
    serial = $("#qlist li input[value='" + cur_id + "']").parent('li').prev('li').children('a').children('span#sl').html().trim(),
    testname = $('#hdn_test_name').val();

  if (typeof query_id != 'undefined') {
    showAns(query_id, serial, testname);
    $(this).attr('data-val', query_id);
    next_lnk.removeClass('disabled');
    next_lnk.attr('data-val', query_id);
    $('#qlist li').removeAttr('class');
    var serial_plain=serial.replace('.','');
      $('#hdn_ques_sl'+serial_plain).parent('a').parent('li').attr('class','selected-ques');
  } else {
    $(this).addClass('disabled');
    next_lnk.removeClass('disabled');
  }
});
//end displaying question according to next and previous

  //tabs contents
  $(document).on('click', '#hintsTab li a', function(e) {
    e.preventDefault();
    $(this).tab('show');
  });
  //end tabs contents

  function liftOffCountDown() {
    pageLeaveState = 'noaction';
    window.location = "{{$base_url}}member/dashboard";
  }
 var time='{{ $time }}';
 function watchCountdown(periods) {
   var timeRemain = (periods[5] * 60) + periods[6];
   var totalTime=time*60;
   var elapsedTime = totalTime - timeRemain;
   $('#hdnSec').val(elapsedTime);
 }

  $('.clockDiv').countdown({
    onExpiry: liftOffCountDown,
    onTick: watchCountdown,
    until: '+0h +'+time+'m +0s'
  }); //count down clock

}); //end document ready


// show confirmation alter before page leave or refresh
$(window).on('beforeunload', function(e) {
  if (pageLeaveState == 'refresh') {
    return 'You have an unsubmitted exam. Are you sure to leave?';
  } else if (pageLeaveState == 'finish') {
    return 'Are you sure to submit your exam?';
  } else {

  }
});
//end show confirmation alter before page leave or refresh


//show answer
function showAns(qid, sl, test_name) {
  $('#ans').isLoading({
      text: "Loading",
      position: "overlay"
      });
  $.ajax({
      url: '{{$base_url}}member/test/get_ans',
      type: 'GET',
      data: {
        qid: qid,
        sl: sl,
        test_name: test_name
      },
    })
    .done(function(msg) {
     //etTimeout( function(){
    $( "#ans" ).isLoading( "hide" );
    $( "#ans" ).html(msg);
    //}, 2000 ); 
   // $('#ans').html(msg);
    var tnm = $('#hdn_last_ques').val();

    if (tnm == 1) {
      $('#next').html("<button  id='btn_next' type='submit'>&nbsp;&nbsp;&nbsp;Finish &amp; Submit&nbsp;&nbsp;&nbsp;</button>");
    } 
    else 
    {
      $('#next').html("<a  id='next' role='button'>&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;<i class='fa fa-arrow-right'></i></a>");
    }

    //display checked answer from local storage
     var sl=$('.ques').children('span').text().replace('.','');

    $('.radio label input[type=radio]').each(function(){
        var ans=$(this).parent('label').children('span').text().replace('(','').replace(')','').replace('.',''),
            given=$.jStorage.get('ques_ans'+sl);
            if(given!=null)
            {
             var given_parsed=JSON.parse(given);
              if(ans.trim()==given_parsed.ques_sl)
              {
                $(this).attr('checked','checked');
              }
            }
           
    });//end loop
    //end display checked answer from local storage
    

    //display if question is marked
    var given_status=$.jStorage.get('flag_status'+sl),
      status_parsed=JSON.parse(given_status);

    if(status_parsed!=null){
      if (status_parsed.status == 1) 
      {
        $('#flag').removeClass('flag flag-grey');
        $("#flag").addClass('flag flag-blue');
      } 
      else 
      {
        $("#flag").removeClass('flag flag-blue');
        $("#flag").addClass('flag flag-grey');
      } 
    }
    //end display if question is marked

  });
}
//end show answer

$(document).on('click', '#flag', function() {
  var qid = $('#hdn_qid').val(),
  mark_qid="mrk_qid"+qid,
  sl=$('.ques').children('span').text().replace('.','');

  if ($(this).data('status') == 0) 
  {
    $(this).data('status','1');
    $(this).removeClass('flag flag-grey');
    $(this).addClass('flag flag-blue');
  } 
  else 
  {
    $(this).data('status','0');
    $(this).removeClass('flag flag-blue');
    $(this).addClass('flag flag-grey');
  }


  var status=$(this).data('status'),
      flag_str={'status':status,flag_qid:qid},
      flqid='flag_status'+sl;
  $.jStorage.set(flqid,JSON.stringify(flag_str));
  //alert($.jStorage.get('flag_status1'));
});


$('.ttp').tooltip();
  </script>
@stop
 





