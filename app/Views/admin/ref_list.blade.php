@extends('admin_master.layout')

@section('content')
<div class="span12">
	<div class="form-inline">
		<input type="text" name="txt_id" id="txt_id" placeholder='ID'>
		<select name="ddl_group" id="ddl_group">
			<option value="-1">Select Group</option>
			@if($ref_group)
			@foreach($ref_group as $rg)
			<?php $sel=$sel_group==$rg->id?'selected':''; ?>
			<option {{$sel}}  value="{{$rg->id}}">{{$rg->name}}</option>
			@endforeach;
			@endif
		</select>
		<select name="ddl_parent" id="ddl_parent">
			{{$parent_list}}
		</select>
		<a class="btn btn-info" id='btn_search' type="submit"><i class="fa fa-search"></i>&nbsp;Search</a>
	</div>
</div>
<br><br>
{{$ref_text}}
{{$page_link}}


<div id="edit_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/edit_ref_text/update">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Edit Reference Text</h3>
  	</div>
  	<div class="modal-body">
   	 <p>One fine body…</p>
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-primary">Save changes</button>
  </div>
  </form>
</div>
@stop


@section('style')
<style>
	#txt_id{width:100px;}
</style>
@stop

@section('script')

<script type="text/javascript">
function get_parent(gid)
{
	$.ajax({
		url: '{{$base_url}}admin/ref_list/parent_list',
		type: 'GET',
		data: {group:gid},
	})
	.done(function(data) {
		$('#ddl_parent').html(data);
	});
	
}
$(document).ready(function() {

	$('#ddl_parent option').filter(function(index) {
		return $.trim( $(this).val() ) == '{{$sel_parent}}';
	}).attr('selected','selected');

	var id='na',
	group=$('#ddl_group').val(),
	parent=$('#ddl_parent').val(),
	url='{{$base_url}}admin/ref_list/index/na/-1/-1';
	$('#btn_search').attr('href',url);
	$('#txt_id').blur(function(event) {
		id=$(this).val();
		if(id.length>0)
		{
		url='{{$base_url}}admin/ref_list/index/'+id+'/'+group+'/'+parent;
		}
		else
		{
			url='{{$base_url}}admin/ref_list/index/na/'+group+'/'+parent;
		}
		$('#btn_search').attr('href',url);
	});

	$('#ddl_group').change(function(){
		group=$(this).val();
		get_parent(group);
		url='{{$base_url}}admin/ref_list/index/'+id+'/'+group+'/'+parent;
		$('#btn_search').attr('href',url);

	});


	$('#ddl_parent').change(function(){
		parent=$(this).val();
		url='{{$base_url}}admin/ref_list/index/'+id+'/'+group+'/'+parent;
		$('#btn_search').attr('href',url);
	});


	$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
	});

});
</script>

@stop