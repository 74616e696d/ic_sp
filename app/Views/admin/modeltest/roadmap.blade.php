<form id='frm_map_course' method="post" action="{{ $base_url }}admin/modeltest/save_roadmap" class="form-horizontal form-ques">
		<div id="msg-content"></div>
		<input type="hidden" name="hdn_test_id" id="hdn_test_id" value="{{$test_id}}">
		<input type="hidden" name="hdn_test_cat" id="hdn_test_cat" value="{{$test_cat}}">
		<div class="control-group">
			<label for="name" class="control-label">Display Name</label>
			<div class="controls" id='div_cat'>
				<input type="text" name="name" id="name" placeholder="Display Name">
			</div>
		</div>


		<div class="control-group">
			<label for="subject" class="control-label">Subject</label>
			<div class="controls">
				<select name="subject" id="subject">
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="chapter" class="control-label">Chapter</label>
			<div class="controls">
				<select name="chapter[]" id="chapter" multiple style='min-height:100px;'>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="date" class="control-label">Date</label>
			<div class="controls">
				<input type="text" name="date" class='dt' id="date" placeholder="Date">
			</div>
		</div>
		<div class="control-group">
			<label for="" class="control-label"></label>
			<div class="controls">
				<label  class="checkbox">
				<input type="checkbox" name="display" id="display" value="1"> Publish
				</label>
			</div>
		</div>

	
		<div class="control-group">
			<label for="" class="control-label"></label>
			<div class="controls">
				<button class='btn btn-info' type="button" id="btn_save_mapping"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
</form>


<script type="text/javascript">
$(document).ready(function() {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	
	//fileter subject by category
	var category=$('#hdn_test_cat').val();
	$.ajax({
		url: '{{ $base_url }}admin/modeltest/filter_subject',
		type: 'GET',
		data:{category:category}
	})
	.done(function(res) {
		$('#subject').html(res);
	});//end filter subject by category


	//filter chapter by subject
	$('#subject').click(function(){

		var subject=$('#subject').val();
		$.ajax({
			url: '{{ $base_url }}admin/modeltest/filter_chapter',
			type: 'GET',
			data: {subject: subject},
		})
		.done(function(res) {
			$('#chapter').html(res);
		});
	});//end filter chapter by subject
	

	/**
	 * save crash course mapping to model test
	 */
	$('#btn_save_mapping').click(function(){

		var frm=$('#frm_map_course');
		var data=frm.serialize();
		var url=frm.attr('action');
		var method=frm.attr('method');

		$.ajax({
			url: url,
			type: method,
			data:data
		})
		.done(function(res) {

			if(res==1)
			{
				$('#msg-content').html(msgSuccess('Successfully saved !'));

				setTimeout(function() {
					$('#modal_roadmap').modal('hide');
				},2000);
			}
			else
			{
				$('#msg-content').html(msgError('Unable to save !'));
			}
		});
		
	});//end save crash course mapping to model test
});


var msgSuccess=function(message){
	var msg='<div class="alert alert-info">';
	 msg+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	 msg+='<strong>Success</strong>'+message;
	msg+='</div>';

	return msg;
}

var msgError=function(message){
	var msg='<div class="alert alert-error">';
	 msg+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	 msg+='<strong>Success</strong>'+message;
	msg+='</div>';

	return msg;
}


</script>