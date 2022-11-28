@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<div class="bx-title">
				<h3></h3>
				</div>
				<div class="bx bx-body">
					<div id='msg'>
					    @if($reg_msg) {{$reg_msg}} @endif
					</div>
					<!-- <p>**For free test, just select only one category</p> -->
					<table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Exam Category</th>
					            <th>Status</th>
					            <th>Request Date</th>
					            <th>Expiry Date</th>
					        </tr>
					    </thead>
					    <tbody>
					    {{$choosen}}
					    </tbody>
					    <tfoot>
					        <tr>
					            <td colspan="2"></td>
					        </tr>
					    </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<link href="{{$base_url}}asset/css/square/blue.css" rel="stylesheet" />
@stop

@section('script')
 <script type="text/javascript" src="{{$base_url}}asset/js/icheck.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.ck_cat').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
		});
		$('.ck_cat').on('ifToggled',function(){
		var cat=0,
		    state=0;
		if($(this).is(':checked')){
		    cat=$(this).val();
		    state=1;
		}
		else
		{
		    cat=$(this).val();
		    state=0;
		}
		
		  $.ajax({
		  url: '<?php
		  echo base_url(); ?>member/account_setting/user_category_save',
		  type: 'POST',
		  data: {cat:cat,state:state},
		  })
		  .done(function(msg) {
		  $('#msg').html(msg);
		  });
		});
	});
</script>

@stop