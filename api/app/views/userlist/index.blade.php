@extends('layout.layout')

@section('content')
<p id='msg'></p>
<?php
	$un=Session::has('un')?Session::get('un'):'';
	$uid=Session::has('uid')?Session::get('uid'):'';
	$mtp=Session::has('mtp')?Session::get('mtp'):'';
 ?>
{{Form::open(array('route'=>array('userlist'),'method'=>'GET','class'=>'form-inline'))}}
	<input type="text" name="un" id="username" placeholder='email' value="{{$un}}">
	<input type="hidden" name="uid" id='hdn_uid' value="{{$uid}}">
	{{Form::select('mtp',$mtype,$mtp,array('class'=>'form-control','id'=>'ddl_mtype'))}}

	<button class='btn btn-info btn-sm' type='submit' name="search" value='1'>
	<i class="fa fa-search"></i>&nbsp;Search</button>
	<button id='btn_send' type="button" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Send Mail</button>

{{Form::close()}}

<p>Total:{{$total}}</p>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>
				<input type="checkbox" name="ck_all" class="ck_all"> All
			</th>
			<th>User Name</th>
			<th>Email</th>
			<th>Mobile</th>
		</tr>
	</thead>
	<tbody>
		@if($ulist)
			@foreach($ulist as $lst)
			<?php $details=UserDetails::where('user_id',$lst->id)->first(); ?>
			<tr>
				<td>
					<input type="checkbox" name="ck_select" value="{{$lst->id}}" class='ck_select'>
				</td>
				<td>{{$lst->user_name}}</td>
				<td>{{$lst->email}}</td>
				<td>{{$details?$details->phone:''}}</td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>

{{$ulist->appends(array('un'=>$un,'uid'=>$uid,'mtp'=>$mtp))->links()}}
@stop


@section('style')
<style>
	.pagination {
	  display: inline-block;
	  padding-left: 0;
	  margin: 20px 0;
	  border-radius: 4px;
	}

	.pagination > li {
	  display: inline;
	}

	.pagination > li > a,
	.pagination > li > span {
	  position: relative;
	  float: left;
	  padding: 6px 12px;
	  margin-left: -1px;
	  line-height: 1.428571429;
	  text-decoration: none;
	  background-color: #ffffff;
	  border: 1px solid #dddddd;
	}

	.pagination > li:first-child > a,
	.pagination > li:first-child > span {
	  margin-left: 0;
	  border-bottom-left-radius: 4px;
	  border-top-left-radius: 4px;
	}

	.pagination > li:last-child > a,
	.pagination > li:last-child > span {
	  border-top-right-radius: 4px;
	  border-bottom-right-radius: 4px;
	}

	.pagination > li > a:hover,
	.pagination > li > span:hover,
	.pagination > li > a:focus,
	.pagination > li > span:focus {
	  background-color: #eeeeee;
	}

	.pagination > .active > a,
	.pagination > .active > span,
	.pagination > .active > a:hover,
	.pagination > .active > span:hover,
	.pagination > .active > a:focus,
	.pagination > .active > span:focus {
	  z-index: 2;
	  color: #ffffff;
	  cursor: default;
	  background-color: #428bca;
	  border-color: #428bca;
	}

	.pagination > .disabled > span,
	.pagination > .disabled > a,
	.pagination > .disabled > a:hover,
	.pagination > .disabled > a:focus {
	  color: #999999;
	  cursor: not-allowed;
	  background-color: #ffffff;
	  border-color: #dddddd;
	}

	.pagination-lg > li > a,
	.pagination-lg > li > span {
	  padding: 10px 16px;
	  font-size: 18px;
	}

	.pagination-lg > li:first-child > a,
	.pagination-lg > li:first-child > span {
	  border-bottom-left-radius: 6px;
	  border-top-left-radius: 6px;
	}

	.pagination-lg > li:last-child > a,
	.pagination-lg > li:last-child > span {
	  border-top-right-radius: 6px;
	  border-bottom-right-radius: 6px;
	}

	.pagination-sm > li > a,
	.pagination-sm > li > span {
	  padding: 5px 10px;
	  font-size: 12px;
	}

	.pagination-sm > li:first-child > a,
	.pagination-sm > li:first-child > span {
	  border-bottom-left-radius: 3px;
	  border-top-left-radius: 3px;
	}

	.pagination-sm > li:last-child > a,
	.pagination-sm > li:last-child > span {
	  border-top-right-radius: 3px;
	  border-bottom-right-radius: 3px;
	}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#username').autocomplete({
	    source: function (request, response) {
	       $.ajax({
	           url:'{{url('user_email')}}',
	           type: 'GET',
	           dataType: 'json',
	           data: request,
	           success: function (data) {
	               response($.map(data, function (item) { 
	                    return {
	                        label: item.email,
	                        value: item.id
	                    };
	               }));
	           }
	       });
	    },
	     select: function(event, ui) {
	          event.preventDefault();
	          $('#username').val(ui.item.label);
	          $('#hdn_uid').val(ui.item.value);
	    },
	    change:function( event, ui ) {
	    	
	    },  
	    minLength: 2
	});

	$('.ck_all').click(function(){
		if($(this).is(':checked'))
		{
			$('.ck_select').attr('checked', 'checked');
		}
		else
		{
			$('.ck_select').removeAttr('checked');
		}
	});

	$('#btn_send').click(function(){
		var id=$('#ddl_mtype').val();
		$.ajax({
			url: '{{url('send_email')}}',
			type: 'GET',
			data: {id:id},
		})
		.done(function(data) {
			$('#msg').html(data);
		});
	});


	


});
</script>
@stop