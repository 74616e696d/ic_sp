<div class="form-horizontal form-ques">
	<input type="hidden" name="hdn_test_id" id="hdn_test_id" value="{{$test_id}}">
		<div class="control-group">
			<label for="category" class="control-label">Category:</label>
			<div class="controls" id='div_cat'>
				<select name="category" id="category">
				<option value="-1">Select Exam Category</option>
					@if($category)
						@foreach($category as $c)
						<option value="{{$c->id}}">{{$c->name}}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="prev_exam" class="control-label">Previous Exam:</label>
			<div class="controls" id='div_cat'>
				<select name="prev_exam" id="prev_exam">
				<option value="-1">Select Previous Exam</option>
				</select>
			</div>
		</div>
		
		<div class="control-group">
			<label for="subject" class="control-label">Subject:</label>
			<div class="controls" id='div_subj'>
				<select name="subject" id="subject">
					<option value="-1">Select Subject</option>
				</select>
			</div>
		</div>
		
		<div class="control-group">
			<label for="chapter" class="control-label">Chapter:</label>
			<div class="controls" id='div_chap'>
				<select name="chapter" id="chapter">
					<option value="-1">Select Chapter</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label"></label>
			<div class="controls">
				<button type='button' id='btnFind' class="btn btn-default">
					<fa class="fa fa-search"></fa> Find
				</button>
			</div>
		</div>
</div>

<ul class="list-group">
	
</ul>



<script type="text/javascript">
$(document).ready(function() {

	$('#div_cat').on('change','#category',function(){
		var cid=$(this).val();

		/**
		 * get subject list by category
		 */
		$.ajax({
			url: '{{$base_url}}admin/modeltest/filter_subject',
			type: 'GET',
			data: {category: cid},
		})
		.done(function(data) {
			$('#subject').html(data);
		});

		/**
		 * get prvious exam list by category
		 */
		$.ajax({
			url: '{{ $base_url }}admin/modeltest/filter_prev_exam',
			type: 'GET',
			data: {category: cid}
		})
		.done(function(res) {
			$('#prev_exam').html(res);
		});
		
	});

	$('#div_subj').on('change','#subject',function(){
		var sid=$(this).val();
		$.ajax({
			url: '{{$base_url}}admin/modeltest/filter_chapter',
			type: 'GET',
			data: {subject: sid},
		})
		.done(function(data) {
			$('#chapter').html(data);
		});
	});

	$('.form-ques').on('click','#btnFind',function(){
		var category=$('#category').val();
		var exam=$('#prev_exam').val();
		var subject=$('#subject').val();

		var cid=$('#chapter').val();
		var tid=$('#hdn_test_id').val();
		$.ajax({
			url: '{{$base_url}}admin/modeltest/ques_list',
			type: 'GET',
			data: {category:category,exam:exam,subject:subject,chapter: cid,tid:tid},
		})
		.done(function(data) {
			$('.list-group').html(data);
		});
	});

	$('.list-group').on('click',".list-group li input[type='checkbox']",function(){
		if($(this).is(':checked'))
		{
			// alert($(this).parent('li').html());
			$(this).parent('li').addClass('selected-option');
		}
		else
		{
			$(this).parent('li').removeClass('selected-option');
		}
	});

});
</script>

