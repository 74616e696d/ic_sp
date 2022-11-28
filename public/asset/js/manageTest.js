 $(document).on('click', '.ck_ans', function() {
   var qid = $('#hdn_qid').val(),
     ans_sl = '',
     serial=$("#qlist li input[value='" + qid + "']").parent('li').children('a').children('span#sl').html(),
     serial_plain=serial.replace('.','');

   if ($(this).is(':checked')) {
     ans_sl = $(this).parent('label').children('span').text()[3];

   } else {
     var ans_sl = $(this).parent('label').children('span').text()[3] + '_' + 0;
   }

   var ans_str={'ques_id':qid,'ques_sl':ans_sl},
        ans='ques_ans'+serial_plain;
    if(qid!='' && ans_sl!='')
   {
      $.jStorage.set(ans,JSON.stringify(ans_str));
   }

   // $.ajax({
   //   url: store_ans_url,
   //   type: 'get',
   //   data: {
   //     qid: qid,
   //     ans_sl: ans_sl
   //   },
   //   success: function(data) {

   //   }
   // });
 }); //end storing answer to database

 $(document).on('click', '#btn_next', function(e) {
   e.preventDefault();
   var ttnm = $('#hdn_test_name').val(),
     timeTaken = $('#hdnSec').val(),
     ttl=$('#ttl_ques').val();

    var obj=new Array(),
      loopCount=parseInt(ttl);
      //alert(loopCount);
      obj.push({'test_name':ttnm,'timeTaken':timeTaken});
    for(var i=1;i<loopCount+1; i++)
    {
      var itemStr=$.jStorage.get('ques_ans'+i);
      if(itemStr!=null)
      {
        var item=JSON.parse(itemStr);
        obj.push(item);
      }
    }
    //console.log($.jStorage.get('ques_ans1'));
   $.ajax({
     url: finish_action,
     type: 'POST',
     data:{'obj':JSON.stringify(obj)}
   })
  .success(function(msg) {
       pageLeaveState = 'finish';
       window.location.href = msg;
     });
   // $.ajax({
   //   url: finish_action,
   //   type: 'GET',
   //   data: {
   //     test_name: ttnm,
   //     timeTaken: timeTaken
   //   }
   // })
   //   .success(function(msg) {
   //     pageLeaveState = 'finish';
   //     window.location.href = msg;
   //   });
 }); //end btnNext button click event

 $(document).ready(function() {

   $('#btnReport').click(function() {
     var question_id = $('#hdn_qid').val();
     $.ajax({
       url: report_action,
       type: 'post',
       data: {
         qid: question_id
       },
       success: function(data) {
         showSuccess(data);
       }
     });
   }); //end btnReport click event


   $('#btnReview').click(function() {
     var qid = $('#hdn_qid').val();
     $.ajax({
       url: review_action,
       type: 'POST',
       data: {
         qid: qid
       },
     })
       .done(function(msg) {
         if (msg == 's') {
           showSuccess(msg);
         }
       });

   }); //end btnReview click event


   $('#lblMarked').click(function() {
    var present = $(this),
      total=parseInt($('#ttl_ques').val()),
      obj=new Array();

      for(var i=1;i<total+1;i++)
      {
        var status_str=$.jStorage.get('flag_status'+i), 
            ques=JSON.parse(status_str);
        if(ques!=null)
        {
          if(ques.status!=0)
          {
            if(ques.flag_qid!=null)
            {
              obj.push(ques.flag_qid);
            }
          }
        }
      }

      var mrkd=JSON.stringify(obj);
     
     $.ajax({
       url: get_mrk_ques_action,
       type: 'POST',
       data:{obj:mrkd}
     })
       .done(function(msg) {
         $('#qlist').html(msg);
         present.removeClass('label label-default');
         present.addClass('label label-info');
         $('#lblAll').removeClass('label label-info');
         $('#lblAll').addClass('label label-default');
       });

   }); //end lblMarked click event

   $('#lblAll').click(function() {
     var test_name = $('#hdn_test_name').val(),
       present = $(this);
     $.ajax({
       url: get_all_ques_action,
       type: 'POST',
       data: {
         'testname': test_name
       }
     })
       .done(function(msg) {
         $('#qlist').html(msg);
         present.removeClass('label label-deafult');
         present.addClass('label label-info');
         $('#lblMarked').removeClass('label label-info');
         $('#lblMarked').addClass('label label-default');
       });

   }); //end lnlAll click event

 }); //end document ready event


 /*** functions to display status message ***/
 function showInfo(msg) {
   toastr.options = {
     "closeButton": false,
     "debug": false,
     "positionClass": "toast-bottom-right",
     "onclick": null,
     "showDuration": "300",
     "hideDuration": "1000",
     "timeOut": "5000",
     "extendedTimeOut": "1000",
     "showEasing": "swing",
     "hideEasing": "linear",
     "showMethod": "fadeIn",
     "hideMethod": "fadeOut"
   }

   toastr.info(msg);
 } //funtion to display Info message

 function showSuccess(msg) {
   toastr.options = {
     "closeButton": false,
     "debug": false,
     "positionClass": "toast-bottom-right",
     "onclick": null,
     "showDuration": "300",
     "hideDuration": "1000",
     "timeOut": "20000",
     "extendedTimeOut": "1000",
     "showEasing": "swing",
     "hideEasing": "linear",
     "showMethod": "fadeIn",
     "hideMethod": "fadeOut"
   }

   toastr.success(msg);
 } //function to display Success message

 function showError(msg) {
   toastr.options = {
     "closeButton": false,
     "debug": false,
     "positionClass": "toast-bottom-right",
     "onclick": null,
     "showDuration": "300",
     "hideDuration": "1000",
     "timeOut": "5000",
     "extendedTimeOut": "1000",
     "showEasing": "swing",
     "hideEasing": "linear",
     "showMethod": "fadeIn",
     "hideMethod": "fadeOut"
   }

   toastr.error(msg);
 } //function to display Error message


 function showWarning(msg) {
   toastr.options = {
     "closeButton": false,
     "debug": false,
     "positionClass": "toast-bottom-right",
     "onclick": null,
     "showDuration": "300",
     "hideDuration": "1000",
     "timeOut": "5000",
     "extendedTimeOut": "1000",
     "showEasing": "swing",
     "hideEasing": "linear",
     "showMethod": "fadeIn",
     "hideMethod": "fadeOut"
   }

   toastr.warning(msg);
 } //function to display Warning message

 /*** end of functions to display status message ***/


 // NOTE:this script is used in v_test page