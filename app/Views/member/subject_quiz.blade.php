@extends('member.exam.master')

@section('content')
  <input type="hidden" id='hdn_test_name' value="{{$subject_name}}">
  <input type="hidden" name="hdn_user" value="{{$user}}">
  <input type="hidden" id="ttl_ques" name="ttl_ques" value="{{$ttl_ques}}">
  <input type="hidden" id="hdn_last_ques" name="hdn_last_ques" value="{{$last_ques}}">

  <div class="col-sm-12 col-xs-12 visible-xs visible-sm toolbar-mobile">

    <div class="exp pull-left"><i class="fa fa-angle-down"></i>&nbsp;All Questions</div>
    <div class="pull-left"><h4><?php if($test_name)echo exam_model::get_text($test_name); ?></h4>
     <div class='clockDiv'></div> 
    </div>
    <div id='exp-calc' class='pull-right'><i class="fa fa-calculator"></i></div>
    
  </div>

  <section class="row top-buffer">
    <div id='left-portion' class="col-lg-4 col-md-4 col-sm-10 col-xs-10">
      <div id="sidebar" role="navigation">
        <div class="well sidebar-nav">
          <h2 class="title tutorial-color"><?php if($subject_name)echo ref_text_model::get_text($subject_name); ?></h2>
         
           <label id='lblAll' class='label label-info'><strong>All Questions</strong></label>
           <label id='lblMarked' class='label label-deafault'><strong>Marked Questions</strong></label>
        
                <ul id='qlist' class="nav nav_1">
                  <?php echo $questions; ?>
                </ul>
        
        </div>
        <!--/.well -->
      </div>
    </div>
    <div id='middle-potion' class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
    
   <!--  <hr/> -->
      <div class="jumbotron">
        <h4>Choose the correct sentence.</h4>
        <form method="post">
        <div id='ans'>
          
        </div>
       
        <ul class="pager">
          <li class="previous"><a id="prev" class="disabled" role="button">
          <i class="icon icon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Prev&nbsp;&nbsp;&nbsp;</a>
          </li>
          <li id='next' class="next">
              <a  id='next' role="button">&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;<i class="icon icon-arrow-right"></i></a>

          </li>
        </ul>
        </form>
        <div>
          <button type='button' class='btn btn-primary btn-mini' id='btnReport'>Report This Question<span class='ttp' data-toggle='tooltip' data-placement='top' 
          title='If you think something wrong with this question,please report'>(*)</span></button>

          <button type='button' class='btn btn-info btn-mini' id='btnReview'>Add to review list<span class='ttp' data-toggle='tooltip' data-placement='top' 
          title='Add this question to list for future review'>(*)</span></button>

               <a onClick='return(confirm("Are you sure to discard the exam and leave this page"))' href="{{ $base_url }}member/dashboard" class='btn btn-danger btn-small'>Discard Exam</a>
        </div>
      </div>
    

    </div>
    <div id='right-portion' class="col-lg-3 col-md-3 col-sm-8 col-xs-8">

<!--    start count down-->
   <input name="hdnSec" type="hidden" id="hdnSec"/>
   <div id='clockDiv'>
      
   </div> <!-- end countdown-->

     
  <!-- start calculator -->
  @include('member.exam.calc')
  <!--end calculator -->
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/css/jquery.countdown.css">
<link type='text/css' rel='stylesheet' href='{{$base_url}}asset/css/toastr.css'/>
<style>
.well .title
{
  width:17%;
}
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
  var store_ans_url='{{$base_url}}member/subject_quiz/store_ans',
  finish_action='{{$base_url}}member/subject_quiz/finish_exam',
  report_action='{{$base_url}}member/subject_quiz/report_question',
  review_action='{{$base_url}}member/test/add_to_review',
  get_mrk_ques_action='{{$base_url}}member/subject_quiz/marked_questions',
  get_all_ques_action='{{$base_url}}member/subject_quiz/all_questions';
</script>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.plugin.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.countdown.min.js"></script>
<script type='text/javascript' src='{{$base_url}}asset/js/toastr.min.js'></script>
<script type="text/javascript" src="{{$base_url}}asset/js/jstorage.min.js"></script>
<script type="text/javascript" src='{{$base_url}}asset/js/subject_quiz.js'></script>
<script type="text/javascript">
$(document).ready(function() {
  $.jStorage.flush();
    //strong all question id to temp storage
  $('#qlist li').each(function(){
    var q=$(this).children("input[type=hidden]").val(),
      srl=$(this).children('a').children('span').text().replace('.',''),
      qsrl='sbj_qsrl'+srl;
      $.jStorage.set(qsrl,q); 

  });
  //alert($.jStorage.get('qsrl5'));
  //end strong all question id to temp storage
  
  var pageLeaveState = 'refresh';

  // $(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
  //  $(document).bind("contextmenu",function(e){
  //         return false;
  //  }); 
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
      serial = $("#qlist li input[value='" + cur_id + "']").parent('li').next('li').children('a').children('span#sl').html(),
      testname = $('#hdn_test_name').val();
    ;
    //alert(serial);
    if (typeof query_id != 'undefined') {
      showAns(query_id, serial, testname);
      $(this).attr('data-val', query_id);
      prev_lnk.removeClass('disabled');
      prev_lnk.attr('data-val', query_id);
      $('#qlist li').removeAttr('class');
      var serial_plain=serial.replace('.','');
      $('#hdn_ques_sl'+serial_plain).parent('a').parent('li').attr('class','selected-ques');
    } else {
      $(this).addClass('disabled');
      prev_lnk.removeClass('disabled');
    }
  });

prev_lnk.click(function(e) {
  e.preventDefault();
  var cur_id = $(this).attr('data-val'),
    query_id = $("#qlist li input[value='" + cur_id + "']").parent('li').prev('li').children('input').val(),
    serial = $("#qlist li input[value='" + cur_id + "']").parent('li').prev('li').children('a').children('span#sl').html(),
    testname = $('#hdn_test_name').val();
  //alert();
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
  function watchCountdown(periods) {
    var timeRemain = (periods[5] * 60) + periods[6];
    var elapsedTime = 3600 - timeRemain;
    $('#hdnSec').val(elapsedTime);

  }

  $('#clockDiv').countdown({
    onExpiry: liftOffCountDown,
    onTick: watchCountdown,
    until: '+0h +30m +0s'
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
      url: '{{$base_url}}member/subject_quiz/get_ans',
      type: 'GET',
      data: {
        qid: qid,
        sl: sl,
        test_name: test_name
      },
    })
    .done(function(msg) {
    $( "#ans" ).isLoading( "hide" );
    $('#ans').html(msg);
    var tnm = $('#hdn_last_ques').val();
    //alert(tnm);
    if (tnm == qid) 
    {
      $('#next').html("<button  id='btn_next' type='submit'>&nbsp;&nbsp;&nbsp;Finish &amp; Submit&nbsp;&nbsp;&nbsp;</button>");
    } else 
    {
      $('#next').html("<a  id='next' role='button'>&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;<i class='icon icon-arrow-right'></i></a>");
    }

    var sl=$('.ques').children('span').text().replace('.','');

    $('.radio label input[type=radio]').each(function(){
        var ans=$(this).parent('label').children('span').text().replace('(','').replace(')','').replace('.',''),
            given=$.jStorage.get('sub_ans'+sl);
            if(given!=null)
            {
              var given_parsed=JSON.parse(given);
              if(ans.trim()==given_parsed.sl)
              {
                $(this).attr('checked','checked');
              }
            }
           
    });

  });
}
//end show answer

$(document).on('click', '#flag', function() {

  var qid = $('#hdn_qid').val(),
      sl=$(this).parent('p').children('span').text()
      sl_plain=sl.replace('.',''),
      key='sub_flag'+sl_plain;
      $.jStorage.set(key,qid);
  if ($(this).data('status') == 1) {
    $(this).removeClass('flag flag-grey');
    $(this).addClass('flag flag-blue');
  } else {
    $(this).removeClass('flag flag-blue');
    $(this).addClass('flag flag-grey');
  }

});


$('.ttp').tooltip();
  </script>
@stop