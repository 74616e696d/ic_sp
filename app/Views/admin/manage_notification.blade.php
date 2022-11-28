@extends('admin_master.layout')

@section('content')
	
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Type</th>
				<th>Title</th>
				<th>Published Date</th>
				<th>Published</th>
				<th>
				<a class="btn btn-mini" href="{{$base_url}}admin/manage_notification/create"><i class="fa fa-plus-circle"></i>&nbsp;Add New</a></th>
			</tr>
		</thead>
		<tbody>
			@if($messages)
			@foreach ($messages as $msg)
				<tr>
					<td>@if($msg->type==1){{'Message'}}@else{{'Notification'}}@endif</td>
					<td>{{$msg->title}}</td>
					<td>{{$msg->publish_date}}</td>
					<td>@if($msg->published){{'Published'}}@else{{'Not Published'}}@endif</td>
					<td>
						<a class="btn btn-mini" href="{{$base_url}}admin/manage_notification/edit/{{$msg->id}}"><i class="fa fa-edit"></i>&nbsp;Edit</a>
						@if($msg->assign_to==1)
						<a data-toggle='modal' data-target='#assign_dlg' class='btn btn-info btn-mini' href="{{$base_url}}admin/manage_notification/assign_view/{{$msg->id}}"><i class="fa fa-plus"></i>&nbsp;Assign</a>
						@else 
							<a class='btn btn-mini btn-assign' data-id={{$msg->id}}><i class="fa fa-refresh"></i>&nbsp;Assign
						@endif
						<a onclick="return(confirm('are you sure to delete?'))" class='btn btn-danger btn-mini' href="{{$base_url}}admin/manage_notification/delete/{{$msg->id}}">
						<i class="fa fa-trash-o"></i>&nbsp;Delete
						</a>
					</td>
				</tr>
			@endforeach
			@endif
		</tbody>
	</table>



<div id="assign_dlg" class="modal hide fade">
<form method="POST" action="<?php echo base_url(); ?>admin/manage_notification/assign">
	<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Assign Message To Users</h3>
  	</div>
  	<div class="modal-body">
   
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-info pull-left">Save</button>
  </div>
 </form>
</div>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#pass_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});

	$('.btn.btn-mini.btn-assign').click(function(e){
		e.preventDefault();
		var id=$(this).data('id');
		$.ajax({
			url: '{{$base_url}}admin/manage_notification/group_assign',
			type: 'POST',
			data: {id:id},
		})
		.done(function(msg) {
			console.log(msg);
		});
		
	});

	});
</script>
@stop