<ul class="nav nav-tabs" id="tab">
	<li><a href="#tab1">Step1</a></li>
	<li><a href="#tab2" id="button2">Step2</a></li>
	<li><a href="#tab3" id="button3">Step3</a></li>
</ul>
<div class="tab-content">
	<div id="tab1" class="tab-pane">

  <!---  <form action="admin/add_question/add" method="POST">-->
        <label for="ddl_exam">Exam Category:</label>
        <select name="ddl_exam" id="ddl_exam">
            <option value="-1">-Select Exam Cat--</option>
            <?php if($exams){foreach($exams as $exam){ ?>
            <option value="<?php echo $exam->id; ?>"><?php echo $exam->name; ?></option>
            <?php }} ?>
        </select>
        <span id="err_exam"></span>
        <label for="ddl_exam_name">Exam Name:</label>
        <select name="ddl_exam_name" id="ddl_exam_name">
            <option value="-1">-Select Exam Name-</option>
        </select>
        <label for="ddl_subject">Subject:</label>
        <select name="ddl_subject" id="ddl_subject">
            <option value="-1">-Select Subject-</option>
        </select>
        <label for="ddl_chapter">Chapter:</label>
        <select name="ddl_chapter" id="ddl_chapter">
            <option value="-1">-Select Chapter-</option>
        </select>
		<br/>
		<br/>
		<br/>

	</div>
	<div id="tab2" class="tab-pane"> 
	
		<input type="checkbox" name="chkparagraph" style='margin-top:-2px;width:20px;height:20px' id="chkparagraph"> Set comprehension
	<div id="comprehension"><br/>
		<label>Title:</label><input type='text' id="txttitle" name="txt" placeholder="Title">
		<label>Comprehension:</label>
	<textarea rows="10" cols="25"id="txtdescription" name="txtdescription" placeholder="Your description goes here"></textarea>
		
	</div>	<br/><br/>
	<input type="checkbox" name="chkmodule" style='margin-top:-2px;width:20px;height:20px' id="chkmodule"> Set Question Module
	<div id="module">
		<label>Module Names(Seperated by <b>';'</b>):</label>
		<textarea rows="10" cols="25"id="txtmodule" name="txtmodule" placeholder="Your description goes here"></textarea>
	</div><br/><br/>
	    <button type="submit" id="btn_do" name="btn_save" class="btn" value="1"><i class="icon-ok-circle"></i>&nbsp;Save</button>&nbsp;&nbsp;
	</div>
	<div id="tab3" class="tab-pane">
	<div id="message"></div>
	 <label for="txt_ques">Add Module</label>
	 <select name="txtmodulename" id="txtmodulename">
		<option></option>
	 </select>
		 <label for="txt_ques">Question:</label>
		
        <textarea required="required" name="txt_ques" id="txt_ques"></textarea>
		<label>Question Options:</label>
		 <textarea required="required" name="txtoptions" id="txt_option"></textarea>
        <label for="txt_marks">Marks Carry:</label>
        <input type="text" required="required" name="txt_marks" id="txt_marks"/>
        <label for="ck_display">Display:</label>
        <input type="checkbox" value="1" name="ck_display" id="ck_display"/>
        <label for="ck_prev">Is Previous:</label>
        <input type="checkbox" name="ck_prev" id="ck_prev" value="1"/>
		<label>Picture</label>
		<input type="file" name="userfile" size="20" />
        <div class="clearfix"></div>
        <br/>
        <div class="btn-row">
            <button type="submit" id="btn_save" name="btn_save" class="btn" value="1"><i class="icon-ok-circle"></i>&nbsp;Save</button>&nbsp;&nbsp;
            <button type="submit" name="btn_save_new" class="btn" value="2"><i class="icon-ok-circle"></i>&nbsp;Save &amp; New</button>&nbsp;&nbsp;
            <a href="<?php echo base_url(); ?>admin/question_bank" class="btn" title="Cancel"><i class="icon-remove-circle"></i>&nbsp;Cancel</a>
        </div>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
	$("#comprehension").hide();
	$("#chkparagraph").click(function(){
	if($("#chkparagraph").is(":checked")){
	$("#comprehension").show(900);
	}
	else{
	$("#comprehension").hide(900);
	}
	
	});
	//set module
	$("#module").hide();
	$("#chkmodule").click(function(){
	if($("#chkmodule").is(":checked")){
	$("#module").show(900);
	}
	else{
	$("#module").hide(900);
	}
	
	});
	//end
        $('#ddl_exam').change(function(){
		
            var exam_id=$('#ddl_exam option:selected').val();
			
            if(exam_id>0){
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/set_question/get_subject',
                    type:'POST',
                    data:{eid:exam_id},
                    success:function(msg){
                        $('#ddl_subject').html(msg);
                    }

                });
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/add_question/exam_by_cat',
                    type:'POST',
                    data:{eid:exam_id},
                    success:function(msg){
                        $('#ddl_exam_name').html(msg);
                    }

                });
            }else
            {
                //$('#err_exam').html('<span style="color:#900;">select exam!</span>').fadeOut('20000');
            }

        });


        $('#ddl_subject').change(function(){
            var sub_id=$('#ddl_subject option:selected').val();
            $.ajax({
                url:'<?php echo base_url(); ?>admin/set_question/get_chapter',
                type:'POST',
                data:{prnt:sub_id},
                success:function(msg){
                    $('#ddl_chapter').html(msg);
                }
            });
        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){
	
	
		$('#tab li:eq(2) a').tab('show');
		$('#tab a').click(function(e){
			e.preventDefault();
			$(this).tab('show');
		});
		
		$('.prnt').hide();
		$('#ckParent').removeAttr('checked');
		$('#ckParent').click(function(){
			if($('#ckParent').is(':checked'))
			{
				$('.prnt').show('1000');
			}else
			{
				$('.prnt').hide('1000');
			}
		});
		
		$('#ddlRefGroupFilter').change(function(){
		var gid=$('#ddlRefGroupFilter option:selected').val();
		$.ajax({
			url:'<?php echo base_url(); ?>admin/reference_text/get_ref_text_ddl',
			type:'POST',
			data:{groupid:gid},
			success:function(msg){
				$('#ddlParent').html(msg);
			}
			});
		});
		
		
		//Search ReferenceText by Group
		
		//End search Reference Text By Group
	
		//Display Modal dialog
		$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});
		//End Display Modal Dialog
        //Maintain state of selected tab
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
        }

        // Change hash for page-reload
        $('.nav-tabs a').on('shown', function (e) {
            window.location.hash = e.target.hash;
        })
        //end Maintain state of selected tab

	});

	$(document).ready(function()
	{
	var exam_ctg,exam_name,subject,chapter,title,des;
		$("#button2").click(function()
		{
			exam_ctg=$("#ddl_exam").val();
			 exam_name=$("#ddl_exam_name").val();
			 subject=$("#ddl_subject").val();
			 chapter=$("#ddl_chapter").val();
			if(exam_ctg!="-1" && exam_name!="-1" && subject!="-1")
			{
			
			}
			else{
			alert("please fill the step1 requirement!");
			return false;
			}
		});
		$("#button3").click(function(){
		if(exam_ctg!="-1" && exam_name!="-1" && subject!="-1")
			{
			title=$("#txttitle").val();
			des=$("#txtdescription").val();
			module=$("#txtmodule").val();
			$.ajax({
			url:'<?php echo base_url(); ?>admin/question_management/set_comprehesion',
			type:'post',
			data:{title:title,des:des,ctg:exam_ctg,e_name:exam_name,subject:subject,chapter:chapter,module:module},
			success:function(data)
			{
			alert(data);
			}
			});
		
			}
			else
			{
			alert("please fill the step1 requirement!");
			return false;
			}
		
		});
		$("#btn_save").click(function()
		{
			var question=$("#txt_ques").val();
			var option=$("#txt_option").val();
			var marks=$("#txt_marks").val();
			var display=$("#ck_display").val();
			var prv=$("#ck_prev").val();
			var md=$("#txtmodulename").val();
			$.ajax({
			url:'<?php echo base_url(); ?>admin/question_management/add_question',
			type:'post',
			data:{ddl_exam:exam_ctg,ddl_exam_name:exam_name,ddl_subject:subject,ddl_chapter:chapter,txt_marks:marks,txt_ques:question,txtoptions:option,ck_display:display,ck_prev:prv},
			success:function(data)
			{
				alert("successfully Inserted!")
			},
			error:function(data)
			{
				alert("error");
			}
			});
		});
	});
</script>