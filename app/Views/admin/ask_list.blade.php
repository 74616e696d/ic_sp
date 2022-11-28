@extends('admin_master.layout')

@section('content')
@if($lists)
	<table class="table table-stripped table-bordered">
		<thead>
			<tr>
				<th>Title</th>
				<th style='width:40%'>Question</th>
				<th>Published</th>
				<th>View</th>
				<th>Answer</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($lists as $lst)
				@if($lst->answered)
				<tr style='background:#E2ECFC;'>
					<td>{{ $lst->title }}</td>
					<td>{{ strip_tags($lst->ques) }}</td>
					<td>
						<input type="checkbox" name="ck_display" {{ $lst->published?'checked':'' }} class="ck_display" data-id='{{ $lst->id }}' value='{{ $lst->published }}'> <span>{{ $lst->published?'Published':'Not Published' }}</span>
					</td>
					<td><a class='btn btn-info btn-small' href=""><i class="fa fa-eye"></i> View</a></td>
					<td>
					<a data-toggle="modal" data-target="#reply_modal" class='btn btn-primary btn-small' href="{{ $base_url }}admin/ask_list/reply_view/{{ $lst->id }}"><i class="fa fa-edit"></i> Answer</a></td>
					<td>
					<a onclick='return(confirm("are you sure to delete?"));' class='btn btn-danger btn-small' href="{{ $base_url }}admin/ask_list/remove/{{ $lst->id }}">
					<i class="fa fa-trash-o"></i> Delete</a>
					</td>
				</tr>
				@else
				<tr>
					<td>{{ $lst->title }}</td>
					<td>{{ strip_tags($lst->ques) }}</td>
					<td>
						<input  type="checkbox" {{ $lst->published?'checked':'' }} name="ck_display" data-id='{{ $lst->id }}' class="ck_display" value="{{ $lst->published }}"> <span>{{ $lst->published?'Published':'Not Published' }}</span>
					</td>
					<td><a class='btn btn-info btn-small' href=""><i class="fa fa-eye"></i> View</a></td>
					<td><a data-toggle="modal" data-target="#reply_modal" class='btn btn-primary btn-small' href="{{ $base_url }}admin/ask_list/reply_view/{{ $lst->id }}"><i class="fa fa-edit"></i> Answer</a></td>
					<td>
					<a onclick='return(confirm("are you sure to delete?"));' class='btn btn-danger btn-small' href="{{ $base_url }}admin/ask_list/remove/{{ $lst->id }}">
					<i class="fa fa-trash-o"></i> Delete</a>
					</td>
				</tr>

				@endif
			@endforeach
		</tbody>
	</table>
@endif


<!-- Modal -->
<div class="modal fade" id="reply_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="{{ $base_url }}admin/ask_list/reply" method="post" class="form-form-horizontal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Reply members question</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type='submit' class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
  </form>
</div>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#reply_modal').on('hidden', function () {
            $(this).removeData('modal');
        });

		$('.ck_display').click(function(){
			var display=$(this).is(':checked')?1:0;
			var id=$(this).data('id');
			$.ajax({
				url: '{{ $base_url }}admin/ask_list/publish',
				type: 'GET',
				data: {display: display,id:id},
			})
			.done(function(data) {
				if(data=='Ok')
				{
					if(display==1)
					{
						$('.ck_display').next('span').text('Published');
					}
					else
					{
						$('.ck_display').next('span').text('Not Published');
					}
				}
			});
			
		});
	});
</script>
@stop