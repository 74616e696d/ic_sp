 //storing answer temporarily in client side
 $(document).on('click', '.ck_ans', function() {
   var qid = $('#hdn_qid').val(),
     ans_sl = '',
     serial=$("#qlist li input[value='" + qid + "']").parent('li').children('a').children('span#sl').html(),
     serial_plain=serial.replace('.','');

   if ($(this).is(':checked')) {
     ans_sl = $(this).parent('label').children('span').text()[3];
   } 
   else
  {
     var ans_sl = $(this).parent('label').children('span').text()[3] + '_' + 0;
   }
   var ans_str={'qid':qid,'sl':ans_sl},
        ans='ans'+serial_plain;
   if(qid!='' && ans_sl!='')
   {
      $.jStorage.set(ans,JSON.stringify(ans_str));
   }

 }); //end storing answer temporarily in client side

 $(document).on('click', '#btn_next', function(e) {
   e.preventDefault();
   var ttnm = $('#hdn_test_name').val(),
     timeTaken = $('#hdnSec').val(),
     ttl=$('#ttl_ques').val();

    var obj=new Array(),
      loopCount=parseInt(ttl);
      obj.push({'test_name':ttnm,'timeTaken':timeTaken});
    for(var i=1;i<loopCount+1; i++)
    {
      var itemStr=$.jStorage.get('ans'+i);
      if(itemStr!=null)
      {
        var item=JSON.parse(itemStr);
        obj.push(item);
      }
    }

   $.ajax({
     url: finish_action,
     type: 'POST',
     data:{'obj':JSON.stringify(obj)}
   })
  .success(function(msg) {
       pageLeaveState = 'finish';
       window.location.href = msg;
     });
 }); //end btnNext button click event

 $(document).ready(function() {

   $('#btnReport').click(function() {
     var question_id = $('#hdn_qid').val();
     //alert(question_id);
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
        var ques=$.jStorage.get('flag'+i);
        if(ques!=null)
        {
          obj.push(ques);
        }
      }

      var mrkd=JSON.stringify(obj);
      //alert(mrkd);
     $.ajax({
       url: get_mrk_ques_action,
       type: 'POST',
       data:{'obj':mrkd}
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
       present = $(this),
        total=parseInt($('#ttl_ques').val()),
        obj=new Array();
        //console.log($.jStorage.get('qsrl1'));
        for(var i=1;i<total+1;i++)
        {
          var ques=$.jStorage.get('qsrl'+i);
         // alert(ques);
          if(ques!=null)
          {
            obj.push(ques);
          }
        }

        var ques_all=JSON.stringify(obj);

     $.ajax({
       url: get_all_ques_action,
       type: 'POST',
       data: {qid:ques_all}
     }).done(function(msg) {
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
 $.ajax({
   url: '/path/to/file',
   type: 'default GET (Other values: POST)',
   dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
   data: {
     param1: 'value1'
   },
 })
   .done(function() {
     console.log("success");
   })
   .fail(function() {
     console.log("error");
   })
   .always(function() {
     console.log("complete");
   });


 // NOTE:this script is used in chapter quiz page