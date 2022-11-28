@extends('admin_master.layout')

@section('content')
	<form class="form-inline" action="">
	<input type="text" name="username" id="username" placeholder='User Email'>
	<input type="hidden" name="hdb_uid" id='hdn_uid'>
		<select name="ddl_mem" id="ddl_mem">
			<option value="-1">Select Membership</option>
			@if($membership)
				@foreach ($membership as $mem)
					<option @if($mem->id==$sel_mem){{'selected'}}@endif value="{{$mem->id}}">{{$mem->name}}</option>
				@endforeach
			@endif
		</select>
		<select  name="ddl_status" id="ddl_status">
			<option value="-1">Select Status</option>
			<option @if($sel_stat==1){{'selected'}}@endif value="1">Pending</option>
			<option @if($sel_stat==2){{'selected'}}@endif value="2">Approved</option>
		</select>
		<br><br>
		<input type="text" class='dt' value="{{$sel_req_date}}" name="txt_req_date" id="txt_req_date" placeholder='Request Date'>
		<input type="text" class='dt' value="{{$sel_exp_date}}" name="txt_exp_date" id="txt_exp_date" placeholder='Expiry Date'>
		<a id='btn_search' class='btn btn-info' href=""><i class="fa fa-search"></i>&nbsp;GO</a>
		<button class='btn btn-default' type="reset"><i class="fa fa-refresh"></i>&nbsp;Reset</button>
	</form>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>User</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Membership</th>
				<th>Request Date</th>
				<th>Expiry Date</th>
				<th>Change Status</th>
			</tr>
		</thead>
		<tbody>
			{{$request}}
		</tbody>
	</table>
	{{$pagi}}


@stop

@section('style')
<style>
form
{
	padding:7px;
	border:1px solid #f6f6f6;
}
.ck-label
{
	
}
.ck_upgrade
{
	margin-right:10px;
	float:left;
}
</style>
@stop


@section('script')
<script type="text/javascript">
	$(document).ready(function() {


	 var skey1=$('#ddl_mem').val(),
	 	skey2=$('#ddl_status').val(),
	 	skey3=$('#txt_req_date').val()?$('#txt_req_date').val():'na',
        skey4=$('#txt_exp_date').val()?$('#txt_exp_date').val():'na',
        skey5=$('#hdn_uid').val()?$('#hdn_uid').val():'0';
        make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;

       $('#btn_search').attr('href',make_url);

       $('#ddl_mem').change(function(){
       	//alert($('#username').val());
       		skey1=$(this).val();
       		if(skey1!=-1)
       		{
       		    make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

       		}
       		else
       		{
       		    make_url='<?php echo base_url();?>admin/upgrade_request/index/'+-1+'/'+-skey2+'/'+skey3+'/'+skey4;

       		}
       		$('#btn_search').attr('href',make_url);
       });//end ddl mem change event
       $('#ddl_status').change(function(){
            skey2=$(this).val();
            if(skey2!=-1)
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

            }
            else
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+-1+'/'+skey3+'/'+skey4;

            }
            $('#btn_search').attr('href',make_url);
        }); //end ddl status change event

       	$('#txt_req_date').change(function(){
       		skey3=$(this).val();
           var len=skey3.length=='NaN'?0:skey3.length;
       		 if(len>0 && len!='NaN')
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

            }
            else
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+'na'+'/'+skey4;

            }
            $('#btn_search').attr('href',make_url);
       	}); //end request date change event

          $('#txt_exp_date').change(function(){
            skey4=$(this).val();
            var len=skey4.length=='NaN'?0:skey4.length;
           if(len>0 && len!='NaN')
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

            }
            else
            {
                make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+'na';

            }
            $('#btn_search').attr('href',make_url);
        }); //end expiry date change event

		$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});


		$(".ck_upgrade").change(function() {
			var upid=$(this).val(),
			stat=$(this).is(':checked')?2:1,
			user=$(this).data('user'),
			utype=$(this).data('utype'),
			spn=$(this).next('span');
			//alert(upid);
			$.ajax({
				url: '{{$base_url}}admin/upgrade_request/approve_req',
				type: 'GET',
				data: {upid:upid,stat:stat,utype:utype,user:user},
			})
			.done(function(data) {
				if(stat==2)
				{
					spn.replaceWith("<span style='color:#009000;''>Approved</span>");
				}
				else
				{
					spn.replaceWith("<span style='color:#FFAA00;''>Pending</span>");
				}
			});


		});

		//$(function () {
		    $('#username').autocomplete({
		        source: function (request, response) {
		           $.ajax({
		               url:'{{ $base_url }}admin/upgrade_request/user_list',
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
		        	 skey5=$('#hdn_uid').val();
		        	 //var len=skey4.length=='NaN'?0:skey4.length;
		        	if(skey5>0)
		        	 {
		        	     make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;

		        	 }
		        	 else
		        	 {
		        	     make_url='<?php echo base_url();?>admin/upgrade_request/index/'+skey1+'/'+skey2+'/'+skey3+'/'+'na'+'/0';

		        	 }
		        	 $('#btn_search').attr('href',make_url);
		        },  
		        minLength: 2
		    });
		//});

	});
</script>
@stop