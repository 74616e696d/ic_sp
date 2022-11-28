<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Edit Education</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<div id="msg"></div>
	</div>
    <div class="form-group">
    	<label for="degree">Degree</label>
    	<input type="text" name="degree" id="degree" class='form-control border-input' placeholder="Degree" value="{{ $education->degree }}">
    </div>
    <div class="form-group">
    	<label for="major_topics">Major Topics</label>
    	<input type="text" name="major_topics" id="major_topics" class='form-control border-input' placeholder="Major Topics" value="{{ $education->major_topics }}">
    </div>

    <div class="form-group">
    	<label for="result">Result</label>
    	<input type="text" name="result" id="result" class='form-control border-input' placeholder="Result" value="{{ $education->result }}">
    </div>

    <div class="form-group">
    	<label for="passing_year">Passing Year</label>
    	<input type="text" name="passing_year" id="passing_year" class='form-control border-input' placeholder="Passing Year" value="{{ $education->passing_year }}">
    </div>

    <div class="form-group">
    	<label for="institution">Institution</label>
    	<input type="text" name="institution" id="institution" class='form-control border-input' placeholder="Institution" value="{{ $education->institution }}">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" id='btnSaveEducation' class="btn btn-primary">Save changes</button>
</div>

<script type="text/javascript" src="{{ $base_url }}asset/expert/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#btnSaveEducation').click(function(){
		var id='{{ $education->id }}';
		var degree=$('#degree').val();
		var major_topics=$('#major_topics').val();
		var passing_year=$('#passing_year').val();
		var result=$('#result').val();
		var institution=$('#institution').val();

		if(degree.length>0){
		$.ajax({
			url: '{{ $base_url }}expert/profile/update_education',
			type: 'POST',
			data: {id:id,degree:degree,major_topics:major_topics,result:result,institution:institution,passing_year:passing_year}
		})
		.done(function(res) {
			$('#msg').html(sp.success(res));
			setTimeout(function(){
				$('#new-education').modal('hide');
			},5000);
		});
		}
		else{
			$('#msg').html(sp.error('Degree must be given'));
		}
		
	});
});
</script>